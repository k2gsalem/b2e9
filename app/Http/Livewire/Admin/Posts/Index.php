<?php

namespace App\Http\Livewire\Admin\Posts;

use App\Models\Post;
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
    public $content;
    public $image;
    public $image_url;

    public function rules()
    {
        $rules = [];
        switch ($this->action)
        {
            case 'create':
                $rules = [
                    'model.title' => ['required', 'string', 'max:255'],
                    'model.summary' => ['required', 'string'],
                    'model.publish_date' => ['required', 'date'],
                    'image' => ['required', 'image', 'max:1024'],
                    'content' => ['required', 'string'],
                ];
                break;
            case 'edit':
                $rules = [
                    'model.title' => ['required', 'string', 'max:255'],
                    'model.summary' => ['required', 'string'],
                    'model.publish_date' => ['required', 'date'],
                    'image' => ['nullable', 'image', 'max:1024'],
                    'content' => ['required', 'string'],
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
                $view = view('livewire.admin.posts.create');
                break;
            case 'edit':
                $view = view('livewire.admin.posts.edit');
                break;
                break;
            default:
                $table_items = $this->getModels();
                $view = view('livewire.admin.posts.index', compact('table_items'));
        }
        return $view->layout('layouts.admin.app-layout');
    }

    public function getModels()
    {
        $query = Post::query()->search($this->search);

        $query->orderByDesc('publish_date');
        return $query->paginate($this->perPage, ['*'], $this->pageName);
    }

    public function getModel()
    {
        $this->image = null;
        $this->image_url = 'https://via.placeholder.com/250x200';
        $this->content = null;
        $item = Post::query()->find($this->modelId);
        if ($item) {
            $this->content = $item->content;
            $this->image_url = Storage::url($item->image);
        }
        return $item ?: new Post();
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
        $this->model->content = $this->content;
        $this->model->image = $this->image->store('post-images', 'public');
        $this->model->save();
        $this->model = $this->getModel();
        $this->action = 'index';
    }

    public function updatedImage()
    {
        $this->validate([
            'image' => 'image|max:1024', // 1MB Max
        ]);
    }

    public function update()
    {
        $this->validate();
        $this->model->content = $this->content;
        if ($this->image) {
            $this->model->image = $this->image->store('post-images', 'public');
        }
        $this->model->save();
        $this->modelId = null;
        $this->model = $this->getModel();
        $this->action = 'index';
    }
}
