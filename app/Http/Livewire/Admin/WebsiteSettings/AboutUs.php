<?php

namespace App\Http\Livewire\Admin\WebsiteSettings;

use App\Models\Setting;
use App\Traits\LivewireAlert;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class AboutUs extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public $about_us_content;
    public $about_us_image;
    public $about_us_image_url;

    public function mount()
    {
        $this->sync();
    }

    public function render()
    {
        return view('livewire.admin.website-settings.about-us');
    }

    public function updatedAboutUsContent()
    {
        Setting::set('home_about_us_content', $this->about_us_content);
    }

    public function updatedAboutUsImage()
    {
        if ($this->about_us_image) {
            $path = $this->about_us_image->store('uploads', 'public');
            Setting::set('home_about_us_image', Storage::url($path));
            $this->about_us_image = null;
            $this->success('Updated successfully');
            $this->sync();
        }
    }

    public function sync()
    {
        $this->about_us_content = config('settings.home_about_us_content');
        $this->about_us_image_url = config('settings.home_about_us_image', 'https://picsum.photos/200/200');
    }

    public function submit()
    {
        $this->success($this->about_us_content);
    }
}
