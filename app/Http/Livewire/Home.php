<?php

namespace App\Http\Livewire;

use App\Models\ContactEnquiry;
use App\Models\Material;
use App\Models\NewsletterSubscriber;
use App\Models\Post;
use App\Models\Process;
use App\Models\Project;
use App\Models\User;
use App\Traits\LivewireAlert;
use Livewire\Component;

class Home extends Component
{
    use LivewireAlert;

    public $materials;
    public $processes;
    public $latest_posts;
    public $processId;
    public $stats = [
        'projects' => 0,
        'clients' => 0,
        'customers' => 0
    ];
    public $banners;

    public $newsletter_subscriber;

    public function mount()
    {
        $this->banners = [
            'banner1' => config('settings.home_banner1', 'https://picsum.photos/200/200'),
            'banner2' => config('settings.home_banner2', 'https://picsum.photos/200/200'),
            'banner3' => config('settings.home_banner3', 'https://picsum.photos/200/200')
        ];
        $this->newsletter_subscriber = new NewsletterSubscriber();
        $this->materials = Material::query()->orderBy('title')->get();
        $this->processes = Process::query()->select('id', 'title')->orderBy('title')->get();
        $this->latest_posts = Post::query()->orderByDesc('publish_date')->limit(3)->get();
        $this->stats['projects'] = Project::query()->count();
        $this->stats['clients'] = User::query()->whereIn('role', ['supplier', 'both'])->count();
        $this->stats['customers'] = User::query()->whereIn('role', ['customer', 'both'])->count();

        if (count($this->processes) > 0)
            $this->processId = $this->processes->first()->id;
    }

    public function render()
    {
        return view('livewire.home');
    }

    public function getProcessProperty()
    {
        return Process::query()->find($this->processId);
    }

    public function rules()
    {

    }

    public function subscribeToNewsletter()
    {
        $data = $this->validate(['email' => ['required', 'email', 'max:255']]);
        if (NewsletterSubscriber::query()->create($data))
            $this->success('Thank you for reaching us. We will contact you ASAP', ['timer' => null]);
    }
}
