<?php

namespace App\Http\Livewire\Admin\WebsiteSettings;

use App\Models\Setting;
use App\Traits\LivewireAlert;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Banners extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public $home_banner1;
    public $home_banner1_url;
    public $home_banner2;
    public $home_banner2_url;
    public $home_banner3;
    public $home_banner3_url;

    public function mount()
    {
        $this->sync();
    }

    public function render()
    {
        return view('livewire.admin.website-settings.banners');
    }

    public function updated($field)
    {
        switch ($field) {
            case 'home_banner1':
            case 'home_banner2':
            case 'home_banner3':
                $this->validate([
                    $field => 'image|max:1024', // 1MB Max
                ]);
                $this->submit();
                break;
        }
    }

    public function sync()
    {
        $this->home_banner1_url = config('settings.home_banner1', 'https://picsum.photos/200/200');
        $this->home_banner2_url = config('settings.home_banner2', 'https://picsum.photos/200/200');
        $this->home_banner3_url = config('settings.home_banner3', 'https://picsum.photos/200/200');
    }

    public function submit()
    {
        if ($this->home_banner1) {
            $path = $this->home_banner1->store('uploads', 'public');
            Setting::set('home_banner1', Storage::url($path));
            $this->home_banner1 = null;
        }
        if ($this->home_banner2) {
            $path = $this->home_banner2->store('uploads', 'public');
            Setting::set('home_banner2', Storage::url($path));
            $this->home_banner2 = null;
        }
        if ($this->home_banner3) {
            $path = $this->home_banner3->store('uploads', 'public');
            Setting::set('home_banner3', Storage::url($path));
            $this->home_banner3 = null;
        }
        $this->sync();
        $this->success('Updated successfully');
    }
}
