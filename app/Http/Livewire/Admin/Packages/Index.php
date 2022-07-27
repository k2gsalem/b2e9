<?php

namespace App\Http\Livewire\Admin\Packages;

use App\Models\Package;
use App\Traits\LivewireAlert;
use App\Traits\WithPagination;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Index extends Component
{
    use WithPagination;
    use LivewireAlert;
    public $search = '';

    public $action = 'index';
    public $modelId;
    public $model;

    public function rules()
    {
        $rules = [];
        switch ($this->action)
        {
            case 'create':
                $rules = [
                    'model.code' => ['required', 'string', 'max:255', Rule::unique('packages', 'code')],
                    'model.actual_amount' => ['required', 'numeric', 'min:0'],
                    'model.sale_amount' => ['required', 'numeric', 'min:0'],
                    'model.bids' => ['required', 'numeric', 'min:0'],
                    'model.order_pos' => ['required', 'numeric'],
                    'model.active' => ['required', 'boolean']
                ];
                break;
            case 'edit':
                $rules = [
                    'model.code' => ['required', 'string', 'max:255', Rule::unique('packages', 'code')->ignore($this->model->id)],
                    'model.actual_amount' => ['required', 'numeric', 'min:0'],
                    'model.sale_amount' => ['required', 'numeric', 'min:0'],
                    'model.bids' => ['required', 'numeric', 'min:0'],
                    'model.order_pos' => ['required', 'numeric'],
                    'model.active' => ['required', 'boolean']
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
                $view = view('livewire.admin.packages.create');
                break;
            case 'edit':
                $view = view('livewire.admin.packages.edit');
                break;
            default:
                $table_items = $this->getModels();
                $view = view('livewire.admin.packages.index', compact('table_items'));
        }
        return $view->layout('layouts.admin.app-layout');
    }

    public function getModels()
    {
        $query = Package::query()->search($this->search, ['code']);

        $query->orderBy('order_pos');
        return $query->paginate($this->perPage, ['*'], $this->pageName);
    }

    public function getModel()
    {
        $item = Package::query()->find($this->modelId);
        return $item ?: new Package();
    }

    public function editModel($modelId)
    {
        $this->modelId = $modelId;
        $this->model = $this->getModel();
        $this->action = 'edit';
    }

    public function create()
    {
        $this->validate();
        $this->model->save();
        $this->model = $this->getModel();
        $this->action = 'index';
        $this->success('Created successfully');
    }

    public function update()
    {
        $this->validate();
        $this->model->save();

        $this->success('Updated successfully');
    }
}
