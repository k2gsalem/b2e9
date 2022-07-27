<?php

namespace App\Http\Livewire\Admin\Processes;

use App\Models\Process;
use App\Traits\WithPagination;
use Illuminate\Support\Facades\Storage;
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

    public $import_file;

    public function rules()
    {
        $rules = [];
        switch ($this->action)
        {
            case 'create':
            case 'edit':
                $rules = [
                    'model.title' => ['required', 'string', 'max:255'],
                    'model.hourly_price' => ['required', 'string', 'max:255'],
                    'model.image' => ['required', 'url'],
                    'model.description' => ['required', 'string'],
                    'model.wikipedia' => ['required', 'string', 'max:255'],
                    'model.active' => ['required', 'boolean']
                ];
                break;
            case 'import':
                $rules = [
                    'import_file' => 'file|mimes:csv,txt|max:1024', // 1MB Max
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
                $view = view('livewire.admin.processes.create');
                break;
            case 'edit':
                $view = view('livewire.admin.processes.edit');
                break;
            case 'import':
                $view = view('livewire.admin.processes.import');
                break;
            default:
                $table_items = $this->getModels();
                $view = view('livewire.admin.processes.index', compact('table_items'));
        }
        return $view->layout('layouts.admin.app-layout');
    }

    public function getModels()
    {
        $query = Process::query()->search($this->search);

        $query->orderBy('title');
        return $query->paginate($this->perPage, ['*'], $this->pageName);
    }

    public function getModel()
    {
        $item = Process::query()->find($this->modelId);
        return $item ?: new Process();
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

    public function import()
    {
        $this->validate();
        $filename = now()->format('YmdHis').'.csv';
        $this->import_file->storeAs('processes-imports', $filename);
        $file = Storage::path('processes-imports/'.$filename);

        foreach ($this->csvToArray($file) as $item)
        {
            Process::query()->updateOrCreate(
                ['title' => $item['title']],
                ['hourly_price' => $item['hourly_price']]
            );
        }
        $this->action = 'index';
    }

    function csvToArray($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename))
            return false;

        $header = null;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false)
        {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
            {
                if (!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }

        return $data;
    }
}
