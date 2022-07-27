<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;

class Posts extends Component
{
    public $posts;

    public function render()
    {
        $this->posts = Post::query()->orderByDesc('publish_date')->get();

        return view('livewire.posts');
    }
}
