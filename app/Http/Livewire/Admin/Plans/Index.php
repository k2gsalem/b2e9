<?php

namespace App\Http\Livewire\Admin\Plans;

use App\Models\Plan;
use App\Models\PlanBenefit;
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

    public $benefits;

    public function rules()
    {
        $rules = [];
        switch ($this->action)
        {
            case 'create':
                $rules = [
                    'model.code' => ['required', 'string', 'max:255', Rule::unique('plans', 'code')],
                    'model.type' => ['required', 'string', Rule::in([Plan::TYPE_PREMIUM, Plan::TYPE_STANDARD])],
                    'model.title' => ['required', 'string', 'max:255'],
                    'model.description' => ['required', 'string'],
                    'model.actual_amount' => ['required', 'numeric', 'min:0'],
                    'model.sale_amount' => ['required', 'numeric', 'min:0'],
                    'model.fresh_bids' => ['required', 'numeric', 'min:0'],
                    'model.additional_bids' => ['required', 'numeric', 'min:0'],
                    'model.validity_days' => ['required', 'numeric', 'min:1'],
                    'model.order_pos' => ['required', 'numeric'],
                    'model.active' => ['required', 'boolean']
                ];
                break;
            case 'edit':
                $rules = [
                    'model.code' => ['required', 'string', 'max:255', Rule::unique('plans', 'code')->ignore($this->modelId)],
                    'model.type' => ['required', 'string', Rule::in([Plan::TYPE_PREMIUM, Plan::TYPE_STANDARD])],
                    'model.title' => ['required', 'string', 'max:255'],
                    'model.description' => ['required', 'string'],
                    'model.actual_amount' => ['required', 'numeric', 'min:0'],
                    'model.sale_amount' => ['required', 'numeric', 'min:0'],
                    'model.fresh_bids' => ['required', 'numeric', 'min:0'],
                    'model.additional_bids' => ['required', 'numeric', 'min:0'],
                    'model.validity_days' => ['required', 'numeric', 'min:1'],
                    'model.order_pos' => ['required', 'numeric'],
                    'model.active' => ['required', 'boolean'],
                    'benefits.*.title' => ['nullable', 'string']
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
                $view = view('livewire.admin.plans.create');
                break;
            case 'edit':
                $view = view('livewire.admin.plans.edit');
                break;
            default:
                $table_items = $this->getModels();
                $view = view('livewire.admin.plans.index', compact('table_items'));
        }
        return $view->layout('layouts.admin.app-layout');
    }

    public function getModels()
    {
        $query = Plan::query()->search($this->search, ['code', 'title']);

        $query->orderByDesc('id');
        return $query->paginate($this->perPage, ['*'], $this->pageName);
    }

    public function getModel()
    {
        $item = Plan::query()->find($this->modelId);
        if ($item) {
            $counts = $item->benefits()->count();
            if ($counts < 7) {
                for ($i = 0; $i < 7 - $counts; $i++) {
                    PlanBenefit::query()->create([
                        'plan_id' => $item->id, 'title' => null
                    ]);
                }
//                PlanBenefit::factory(6 - $item->benefits()->count())->state(['plan_id' => $item->id, 'title' => null])->create();
                $item = Plan::query()->find($this->modelId);
            }
            $this->benefits = $item->benefits;
        }
        return $item ?: new Plan();
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

    public function updateBenefits()
    {
        $this->benefits->each(function ($item){
            $item->save();
        });

        $this->success('Updated successfully');
    }
}
