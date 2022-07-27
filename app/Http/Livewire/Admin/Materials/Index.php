<?php

namespace App\Http\Livewire\Admin\Materials;

use App\Exports\MaterialsExport;
use App\Models\Material;
use App\Traits\LivewireAlert;
use App\Traits\WithPagination;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Index extends Component
{
    use WithFileUploads;
    use WithPagination;
    use LivewireAlert;

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
                    'model.price' => ['required', 'numeric', 'min:0'],
                    'model.density' => ['required', 'numeric', 'min:0']
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
                $view = view('livewire.admin.materials.create');
                break;
            case 'edit':
                $view = view('livewire.admin.materials.edit');
                break;
            case 'import':
                $view = view('livewire.admin.materials.import');
                break;
            default:
                $table_items = $this->getModels();
                $view = view('livewire.admin.materials.index', compact('table_items'));
        }
        return $view->layout('layouts.admin.app-layout');
    }

    public function getModels()
    {
        $query = Material::query()->search($this->search);

        $query->orderBy('title');
        return $query->paginate($this->perPage, ['*'], $this->pageName);
    }

    public function getModel()
    {
        $item = Material::query()->find($this->modelId);
        return $item ?: new Material();
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
        $this->modelId = null;
        $this->model = $this->getModel();
        $this->action = 'index';
        $this->success('Updated successfully');
    }

    public function import()
    {
        $this->validate([
            'import_file' => 'file|mimes:csv,txt|max:1024', // 1MB Max
        ]);
        $filename = now()->format('YmdHis').'.csv';
        $this->import_file->storeAs('material-imports', $filename);
        $file = Storage::path('material-imports/'.$filename);

        foreach ($this->csvToArray($file) as $item)
        {
            Material::query()->updateOrCreate(
                ['title' => $item['title']],
                ['price' => $item['price'], 'density' => $item['density']]
            );
        }
        $this->action = 'index';
        $this->success('Imported successfully');
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

    public function export()
    {
        return (new MaterialsExport())
            ->download('materials.csv');
    }
}
