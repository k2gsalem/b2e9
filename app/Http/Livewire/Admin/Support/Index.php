<?php

namespace App\Http\Livewire\Admin\Support;

use App\Models\ProjectTransaction;
use App\Models\Subscription;
use App\Models\User;
use App\Traits\LivewireAlert;
use App\Traits\WithPagination;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Index extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $start_date;
    public $end_date;
    public $search = '';
    public $action = 'index';
    public $modelId;
    public $model;
    public $filter = [
        'role' => null,
        'active' => true,
    ];

    public $sub_start_date;
    public $sub_end_date;
    public $sub_search = '';

    public $proj_start_date;
    public $proj_end_date;
    public $proj_search = '';

    public function rules()
    {
        return [
            'search' => ['nullable', 'string', 'max:256'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date'],
            'filter.role' => ['nullable', 'string', Rule::in(['Customer', 'Supplier', 'Both'])],
            'filter.active' => ['nullable', 'boolean']
        ];
    }

    public function mount()
    {
        $this->model = $this->getModel();
    }

    public function render()
    {
        switch ($this->action) {
            case 'details':
                $view = view('livewire.admin.support.details');
                break;
            default:
                $table_items = $this->getModels();
                $view = view('livewire.admin.support.index', compact('table_items'));
        }
        return $view->layout('layouts.admin.app-layout');
    }

    public function updated($field)
    {
        switch ($field) {
            case 'search':
            case 'filter.role':
            case 'filter.active':
                $this->resetPage($this->pageName);
                break;
        }
    }

    public function getModels()
    {
        $query = User::query();

        if ($this->filter['role']) {
            switch ($this->filter['role']) {
                case 'Customer':
                    $query->whereIn('role', ['Customer', 'Both']);
                    break;
                case 'Supplier':
                    $query->whereIn('role', ['Supplier', 'Both']);
                    break;
                case 'Both':
                    $query->whereIn('role', ['Both']);
                    break;
            }
        }
        if (!is_null($this->filter['active']))
            $query->where('active', $this->filter['active']);

        if ($this->start_date)
            $query->whereDate('created_at', '>=', $this->start_date);
        if ($this->end_date)
            $query->whereDate('created_at', '<=', $this->end_date);
        $query->search($this->search)->orderByDesc('id');
        return $query->paginate($this->perPage, ['*'], $this->pageName);
    }

    public function getModel()
    {
        $item = User::query()
            ->where('id', $this->search)
            ->orWhere('email', $this->search)
            ->orWhere('phone', $this->search)
            ->first();
        return $item ?: new User();
    }

    public function editModel($modelId)
    {
        $this->modelId = $modelId;
        $this->model = $this->getModel();
        $this->action = 'details';
    }

    public function search()
    {
        $this->model = User::query()
            ->where('id', $this->search)
            ->orWhere('email', $this->search)
            ->orWhere('phone', $this->search)
            ->first();
        $this->resetPage('subs');
        $this->resetPage('projs');
    }

    public function clear()
    {
        $this->search = '';
        $this->search();
    }

    public function getSubRecordsQuery()
    {
        $query = Subscription::query();

        $query->where('user_id', $this->model->id);

        if ($this->sub_start_date)
            $query->where('starts_at', '>=', Carbon::parse($this->sub_start_date));
        if ($this->sub_end_date)
            $query->where('starts_at', '<=', Carbon::parse($this->sub_end_date));
        $query->search($this->sub_search)->orderByDesc('id');

        return $query;
    }

    public function getSubRecordsProperty()
    {
        return $this->getSubRecordsQuery()
            ->paginate($this->perPage, ['*'], 'subs');
    }

    public function getProjRecordsQuery()
    {
        $query = ProjectTransaction::query();

        $user_id = $this->model->id;
        $query->whereHas('project', function ($q) use ($user_id) {
            $q->where('user_id', $user_id);
        });

        if ($this->proj_start_date)
            $query->where('paid_at', '>=', Carbon::parse($this->proj_start_date));
        if ($this->proj_end_date)
            $query->where('paid_at', '<=', Carbon::parse($this->proj_end_date));
        $query->search($this->proj_search)->orderByDesc('id');

        return $query;
    }

    public function getProjRecordsProperty()
    {
        return $this->getProjRecordsQuery()
            ->paginate($this->perPage, ['*'], 'projs');
    }
}
