<?php

namespace App\Http\Livewire\Admin;

use App\Models\NewsletterSubscriber;
use App\Models\User;
use App\Traits\LivewireAlert;
use App\Traits\WithPagination;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Newsletter extends Component
{
    use WithPagination;
    use LivewireAlert;
    use WithFileUploads;

    public $image;
    public $image_url;
    public $content;

    public $action = 'index';

    public function render()
    {
        switch ($this->action) {
            case 'create':
                $view = view('livewire.admin.newsletter');
                break;
            default:
                $table_items = NewsletterSubscriber::query()->orderByDesc('id')->paginate($this->perPage, ['*'], $this->pageName);
                $view = view('livewire.admin.newsletter-subscribers', compact('table_items'));
        }
        return $view->layout('layouts.admin.app-layout');
    }

    public function updated($field)
    {
        switch ($field) {
            case 'image':
                $this->validate([
                    $field => 'image|max:1024', // 1MB Max
                ]);
                break;
        }
    }

    public function submit()
    {
        if ($this->image) {
            $path = $this->image->store('uploads', 'public');
            $this->image_url = url(Storage::url($path));
        }

        foreach (NewsletterSubscriber::query()->get() as $item) {
            Mail::to($item->email)
                ->send(new \App\Mail\NewsLetter($this->content, $this->image_url));
        }
        foreach (User::query()->whereNotNull('email')->pluck('email') as $item) {
            if (!empty($item)) {
                Mail::to($item)
                    ->send(new \App\Mail\NewsLetter($this->content, $this->image_url));
            }
        }
        $this->success('Submitted successfully.');
    }
}
