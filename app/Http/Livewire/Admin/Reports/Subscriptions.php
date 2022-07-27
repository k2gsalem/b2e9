<?php

namespace App\Http\Livewire\Admin\Reports;

use App\Exports\SubscriptionsExport;
use App\Models\Subscription;
use App\Models\User;
use App\Traits\LivewireAlert;
use App\Traits\WithPagination;
use Illuminate\Support\Carbon;
use Livewire\Component;

class Subscriptions extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $start_date;
    public $end_date;
    public $search = '';
    public $filter = [
        'customer' => [
            'options' => null,
            'option' => null,
            'value' => null
        ]
    ];

    public function mount()
    {
        $this->filter['customer']['options'] = User::query()
            ->whereIn('role', ['supplier', 'both'])
            ->orderBy('name')->get();
    }

    public function render()
    {
        return view('livewire.admin.reports.subscriptions')->layout('layouts.admin.app-layout');
    }

    public function updated($field)
    {
        switch ($field) {
            case 'filter.customer.value':
                $this->filter['customer']['option'] = User::query()->find($this->filter['customer']['value']);
                $this->resetPage($this->pageName);
                break;
            case 'search':
            case 'start_date':
            case 'end_date':
                $this->resetPage($this->pageName);
                break;
        }
    }

    public function getRecordsQuery()
    {
        $query = Subscription::query();

        if ($this->filter['customer']['value'])
            $query->where('user_id', $this->filter['customer']['value']);

        if ($this->start_date)
            $query->where('starts_at', '>=', Carbon::parse($this->start_date));
        if ($this->end_date)
            $query->where('starts_at', '<=', Carbon::parse($this->end_date));
        $query->search($this->search)->orderByDesc('id');

        return $query;
    }

    public function getRecordsProperty()
    {
        return $this->getRecordsQuery()
            ->paginate($this->perPage, ['*'], $this->pageName);
    }

    public function export()
    {
        return (new SubscriptionsExport())
            ->customQuery($this->getRecordsQuery())
            ->download('subscriptions.xlsx');
    }
}
