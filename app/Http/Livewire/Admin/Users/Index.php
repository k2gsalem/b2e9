<?php

namespace App\Http\Livewire\Admin\Users;

use App\Exports\UsersExport;
use App\Models\User;
use App\Traits\LivewireAlert;
use App\Traits\WithPagination;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Rules\Password;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class Index extends Component
{
    use WithFileUploads;
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

    public $password;
    public $password_confirmation;

    public function rules()
    {
        $rules = [];
        switch ($this->action)
        {
            case 'create':
            case 'edit':
                $rules = [
                    'model.name' => ['required', 'string', 'max:255'],
                    'model.contact_name' => ['required', 'regex:/^[_A-z0-9]*((-|\s)*[_A-z0-9])*$/', 'max:255'],
                    'model.organization_type' => ['required', 'string', 'max:255'],
                    'model.email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->model->id)],
                    'model.phone' => ['required', 'regex:/^[6-9][0-9]{9}$/', Rule::unique('users', 'phone')->ignore($this->model->id)],
                    'model.alternate_phone' => ['nullable', 'regex:/^[6-9][0-9]{9}$/'],
                    'model.incorporation_date' => ['required', 'date', 'before_or_equal:'.now()->format('Y-m-d')],
                    'model.sales_turnover' => ['required', 'numeric'],
                    'model.gst_number' => ['required', 'regex:/^\d{2}[A-Z]{5}\d{4}[A-Z]{1}[A-Z\d]{1}[Z]{1}[A-Z\d]{1}$/'],
                    'model.active' => ['required', 'boolean']
                ];
                break;
            case 'import':
                $rules = [
                    'import_file' => 'file|mimes:csv,txt|max:1024', // 1MB Max
                ];
                break;
            case 'index':
                $rules = [
                    'search' => ['nullable', 'string', 'max:256'],
                    'start_date' => ['nullable', 'date'],
                    'end_date' => ['nullable', 'date'],
                    'filter.role' => ['nullable', 'string', Rule::in(['Customer', 'Supplier', 'Both'])],
                    'filter.active' => ['nullable', 'boolean']
                ];
                break;
        }
        return $rules;
    }

    public function mount()
    {
        $this->model = $this->getModel();
    }

    public function render()
    {
        switch ($this->action) {
            case 'create':
                $view = view('livewire.admin.users.create');
                break;
            case 'edit':
                $view = view('livewire.admin.users.edit');
                break;
            default:
                $table_items = $this->getModels();
                $view = view('livewire.admin.users.index', compact('table_items'));
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
        $item = User::query()->find($this->modelId);
        return $item ?: new User();
    }

    public function editModel($modelId)
    {
        $this->modelId = $modelId;
        $this->model = $this->getModel();
        $this->action = 'edit';
    }

    public function update()
    {
        $this->validate();
        $this->model->save();
//        $this->modelId = null;
//        $this->model = $this->getModel();
//        $this->action = 'index';
        $this->success('Updated successfully');
    }

    public function export()
    {
        return (new UsersExport)
            ->search($this->search)
            ->startDate($this->start_date)
            ->endDate($this->end_date)
            ->role($this->filter['role'])
            ->active($this->filter['active'])
            ->download('users.xlsx');
    }

    public function updatePassword()
    {
        $this->validate([
            'password' => ['required', 'string', new Password, 'confirmed'],
        ]);
        $this->model->password = Hash::make($this->password);
        $this->model->save();
        $this->reset('password', 'password_confirmation');
//        $this->model->forceFill([
//            'password' => Hash::make($input['password']),
//        ])->save();
        $this->success('Updated successfully');
    }
}
