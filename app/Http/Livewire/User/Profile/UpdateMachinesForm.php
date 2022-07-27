<?php

namespace App\Http\Livewire\User\Profile;

use App\Models\Process;
use Illuminate\Validation\Rule;
use Livewire\Component;

class UpdateMachinesForm extends Component
{
    public $machines;
    public $processes;
    public $machine_ids;
    public $process_ids;
    public $filter = [
        'machines' => [
            'query' => '',
            'options' => [],
            'selected' => [
                'values' => [],
                'options' => []
            ]
        ],
        'processes' => [
            'query' => '',
            'options' => [],
            'selected' => [
                'values' => [],
                'options' => []
            ]
        ]
    ];

    public function mount()
    {
        $this->filter['machines']['selected']['values'] = auth()->user()->machines()->pluck('processes.id');
        $this->filter['machines']['selected']['options'] = Process::query()
            ->whereIn('id', $this->filter['machines']['selected']['values'])
            ->select('id', 'title')
            ->orderBy('title')->get();

        $this->filter['processes']['selected']['values'] = auth()->user()->processes()->pluck('processes.id');
        $this->filter['processes']['selected']['options'] = Process::query()
            ->whereIn('id', $this->filter['processes']['selected']['values'])
            ->select('id', 'title')
            ->orderBy('title')->get();
    }

    public function render()
    {
        $this->filter['machines']['options'] = Process::query()->search($this->filter['machines']['query'])
            ->select('id', 'title')
            ->orderBy('title')->get();
        $this->filter['processes']['options'] = Process::query()->search($this->filter['processes']['query'])
            ->select('id', 'title')
            ->orderBy('title')->get();

        return view('livewire.user.profile.update-machines-form');
    }

    public function rules()
    {
        return [
            'filter.machines.selected.values' => ['required', 'array'],
            'filter.machines.selected.values.*' => ['required', Rule::exists('processes', 'id')],
            'filter.processes.selected.values' => ['array'],
            'filter.processes.selected.values.*' => ['required', Rule::exists('processes', 'id')]
        ];
    }

    public function updated($field)
    {
        switch ($field)
        {
            case 'filter.machines.selected.values':
                $this->filter['machines']['selected']['options'] = Process::query()
                    ->whereIn('id', $this->filter['machines']['selected']['values'])
                    ->select('id', 'title')
                    ->orderBy('title')->get();
                break;
            case 'filter.processes.selected.values':
                $this->filter['processes']['selected']['options'] = Process::query()
                    ->whereIn('id', $this->filter['processes']['selected']['values'])
                    ->select('id', 'title')
                    ->orderBy('title')->get();
                break;
        }
    }

    public function save()
    {
        $this->validate();

        auth()->user()->machines()->sync($this->filter['machines']['selected']['values']);
        auth()->user()->processes()->sync($this->filter['processes']['selected']['values']);
        $this->emit('saved');
    }
}
