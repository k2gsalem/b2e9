<?php

namespace App\Http\Livewire\Admin\Projects;

use App\Exports\ProjectsExport;
use App\Models\Project;
use App\Traits\LivewireAlert;
use App\Traits\WithPagination;
use Livewire\Component;
use Livewire\WithFileUploads;

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
        'role' => null
    ];

    public function mount()
    {
        $this->model = $this->getModel();
    }

    public function render()
    {
        switch ($this->action) {
            case 'create':
                $view = view('livewire.admin.projects.create');
                break;
            case 'edit':
                $view = view('livewire.admin.projects.details', ['project' => $this->model]);
                break;
            default:
                $table_items = $this->getModels();
                $view = view('livewire.admin.projects.index', compact('table_items'));
        }
        return $view->layout('layouts.admin.app-layout');
    }

    public function getRecordsQuery()
    {
        $query = Project::query();

        if ($this->filter['role'])
            $query->where('role', $this->filter['role']);

        if ($this->start_date)
            $query->whereDate('close_at', '>=', $this->start_date);
        if ($this->end_date)
            $query->whereDate('close_at', '<=', $this->end_date);

        $query->search($this->search)->orderByDesc('id');
        return $query;
    }

    public function getModels()
    {
        return $this->getRecordsQuery()
            ->paginate($this->perPage, ['*'], $this->pageName);
    }

    public function getModel()
    {
        $item = Project::query()->find($this->modelId);
        return $item ?: new Project();
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
        $this->modelId = null;
        $this->model = $this->getModel();
        $this->action = 'index';
        $this->success('Updated successfully');
    }

    public function export()
    {
        return (new ProjectsExport())
            ->customQuery($this->getRecordsQuery())
            ->download('projects.xlsx');
    }
}
