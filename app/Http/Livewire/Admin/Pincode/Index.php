<?php

namespace App\Http\Livewire\Admin\Pincode;

use App\Models\Location;
use App\Traits\WithPagination;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class Index extends Component
{
    use WithFileUploads;
    use WithPagination;
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
            case 'edit':
                $rules = [
                    'model.pincode' => ['required', 'regex:/^[1-9][0-9]{5}$/', Rule::unique('locations', 'pincode')->ignore($this->model->id)],
                    'model.latitude' => ['required', 'regex:/^(\+|-)?(?:90(?:(?:\.0{1,6})?)|(?:[0-9]|[1-8][0-9])(?:(?:\.[0-9]{1,6})?))$/'],
                    'model.longitude' => ['required', 'regex:/^(\+|-)?(?:180(?:(?:\.0{1,6})?)|(?:[0-9]|[1-9][0-9]|1[0-7][0-9])(?:(?:\.[0-9]{1,6})?))$/'],
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
                $view = view('livewire.admin.pincode.create');
                break;
            case 'edit':
                $view = view('livewire.admin.pincode.edit');
                break;
            default:
                $table_items = $this->getModels();
                $view = view('livewire.admin.pincode.index', compact('table_items'));
        }
        return $view->layout('layouts.admin.app-layout');
    }

    public function getModels()
    {
        $query = Location::query()->search($this->search, ['pincode']);

        $query->orderBy('pincode');
        return $query->paginate($this->perPage, ['*'], $this->pageName);
    }

    public function getModel()
    {
        $item = Location::query()->find($this->modelId);
        return $item ?: new Location();
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
    }

    public function update()
    {
        $this->validate();
        $this->model->save();
        $this->modelId = null;
        $this->model = $this->getModel();
        $this->action = 'index';
    }
}
