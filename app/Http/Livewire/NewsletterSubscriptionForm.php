<?php

namespace App\Http\Livewire;

use App\Models\NewsletterSubscriber;
use App\Traits\LivewireAlert;
use Livewire\Component;

class NewsletterSubscriptionForm extends Component
{
    use LivewireAlert;

    public $model;

    public function mount()
    {
        $this->model = new NewsletterSubscriber();
    }

    public function render()
    {
        return view('livewire.newsletter-subscription-form');
    }

    public function rules()
    {
        return [
            'model.email' => ['required', 'email', 'max:255']
        ];
    }

    public function submit()
    {
        $this->validate();
        if (NewsletterSubscriber::query()->firstWhere('email', $this->model->email) || $this->model->save()) {
            $this->model = new NewsletterSubscriber();
            $this->success('Newsletter subscription added successfully');
        }
    }
}
