<?php

namespace App\Http\Livewire\Admin\Admins;

use App\Exports\UsersExport;
use App\Models\Admin;
use App\Models\User;
use App\Traits\LivewireAlert;
use App\Traits\WithPagination;
use Illuminate\Http\Request;
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

    public $search = '';
    public $action = 'index';
    public $modelId;
    public $model;

    public $password;
    public $password_confirmation;

    public $permissions = [
        'users.list',
        'users.edit',
        'users.reset_password',
        'projects.list',
        'projects.details',
        'projects.export',
        'materials.list',
        'materials.create',
        'materials.edit',
        'materials.import',
        'materials.export',
        'processes.list',
        'processes.create',
        'processes.edit',
        'processes.import',
        'blog.list',
        'blog.create',
        'blog.edit',
        'reports.project_transactions',
        'reports.subscriptions',
        'membership_plans.list',
        'membership_plans.create',
        'membership_plans.edit',
        'rfq_packages.list',
        'rfq_packages.create',
        'rfq_packages.edit',
        'newsletter.list',
        'newsletter.send',
        'website_settings',
        'locations.create',
        'locations.edit',
        'support',
    ];
    public $new_permissions = [];

    public function rules()
    {
        $rules = [];
        switch ($this->action)
        {
            case 'create':
            case 'edit':
                $rules = [
                    'model.name' => ['required', 'string', 'max:255'],
                    'model.email' => ['required', 'email', 'max:255', Rule::unique('admins', 'email')->ignore($this->model->id)],
                    'password' => ['required', 'string', new Password, 'confirmed'],
                ];
                break;
            case 'index':
                $rules = [
                    'search' => ['nullable', 'string', 'max:256'],
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
                $this->modelId = null;
                $this->model = $this->getModel();
                $view = view('livewire.admin.admins.create');
                break;
            case 'edit':
                $view = view('livewire.admin.admins.edit');
                break;
            default:
                $table_items = $this->getModels();
                $view = view('livewire.admin.admins.index', compact('table_items'));
        }
        return $view->layout('layouts.admin.app-layout');
    }

    public function updated($field)
    {
        switch ($field) {
            case 'search':
                $this->resetPage($this->pageName);
                break;
        }
    }

    public function getModels()
    {
        $query = Admin::query()->where('id', '>', 1);
        if ($this->search) {
            $query->where(function ($query) {
                $query->where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('email', 'like', '%'.$this->search.'%');
            });
        }
        $query->orderByDesc('id');
        return $query->paginate($this->perPage, ['*'], $this->pageName);
    }

    public function getModel()
    {
        $item = Admin::query()->find($this->modelId);
        return $item ?: new Admin();
    }

    public function editModel($modelId)
    {
        $this->modelId = $modelId;
        $this->model = $this->getModel();
        $this->new_permissions = $this->model->permissions()->pluck('name');
        $this->action = 'edit';
    }

    public function create()
    {
        $this->validate();
        $this->model->password = Hash::make($this->password);
        $this->model->save();
        $this->model = $this->getModel();
        $this->action = 'index';
        $this->password = null;
        $this->password_confirmation = null;
        $this->success('Created successfully');
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

    public function updatePassword()
    {
        $this->validate([
            'password' => ['required', 'string', new Password, 'confirmed'],
        ]);
        $this->model->password = Hash::make($this->password);
        $this->model->save();
        $this->reset('password', 'password_confirmation', 'new_permissions');
//        $this->model->forceFill([
//            'password' => Hash::make($input['password']),
//        ])->save();
        $this->success('Updated successfully');
    }

    public function updatePermissions()
    {
        $input = $this->validate([
            'new_permissions' => ['array']
        ]);
        $this->model->syncPermissions($input['new_permissions']);
        $this->success('Updated successfully');
    }
}
