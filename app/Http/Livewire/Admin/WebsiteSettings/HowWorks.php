<?php

namespace App\Http\Livewire\Admin\WebsiteSettings;

use App\Models\Setting;
use App\Traits\LivewireAlert;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class HowWorks extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public $how_works_content;
    public $how_works_image;
    public $how_works_image_url;
    public $how_works_video;
    public $how_works_video_content;
    public $how_works_video2;
    public $how_works_video2_content;
    public $how_works_video2_content2;
    public $how_works_video3;
    public $how_works_video3_content;
    public $how_works_video3_content2;

    public function mount()
    {
        $this->sync();
    }

    public function render()
    {
        return view('livewire.admin.website-settings.how-works');
    }

    public function updatedHowWorksContent()
    {
        Setting::set('home_how_works_content', $this->how_works_content);
    }

    public function updatedHowWorksImage()
    {
        if ($this->how_works_image) {
            $path = $this->how_works_image->store('uploads', 'public');
            Setting::set('home_how_works_image', Storage::url($path));
            $this->how_works_image = null;
            $this->success('Updated successfully');
            $this->sync();
        }
    }

    public function updatedHowWorksVideo()
    {
        Setting::set('home_how_works_video', $this->how_works_video);
    }

    public function updatedHowWorksVideoContent()
    {
        Setting::set('home_how_works_video_content', $this->how_works_video_content);
    }

    public function updatedHowWorksVideo2()
    {
        Setting::set('home_how_works_video2', $this->how_works_video2);
    }

    public function updatedHowWorksVideo2Content()
    {
        Setting::set('home_how_works_video2_content', $this->how_works_video2_content);
    }

    public function updatedHowWorksVideo2Content2()
    {
        Setting::set('home_how_works_video2_content2', $this->how_works_video2_content2);
    }

    public function updatedHowWorksVideo3()
    {
        Setting::set('home_how_works_video3', $this->how_works_video3);
    }

    public function updatedHowWorksVideo3Content()
    {
        Setting::set('home_how_works_video3_content', $this->how_works_video3_content);
    }

    public function updatedHowWorksVideo3Content2()
    {
        Setting::set('home_how_works_video3_content2', $this->how_works_video3_content2);
    }

    public function sync()
    {
        Setting::sync();
        $this->how_works_content = config('settings.home_how_works_content');
        $this->how_works_image_url = config('settings.home_how_works_image', 'https://picsum.photos/200/200');
        $this->how_works_video = config('settings.home_how_works_video');
        $this->how_works_video_content = config('settings.home_how_works_video_content');
        $this->how_works_video2 = config('settings.home_how_works_video2');
        $this->how_works_video2_content = config('settings.home_how_works_video2_content');
        $this->how_works_video2_content2 = config('settings.home_how_works_video2_content2');
        $this->how_works_video3 = config('settings.home_how_works_video3');
        $this->how_works_video3_content = config('settings.home_how_works_video3_content');
        $this->how_works_video3_content2 = config('settings.home_how_works_video3_content2');
    }
}
