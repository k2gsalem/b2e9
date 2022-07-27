<?php

namespace App\Http\Livewire\Admin\WebsiteSettings;

use App\Models\Setting;
use App\Traits\LivewireAlert;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Nda extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public $nda_content;
    public $nda_image;
    public $nda_image_url;

    public function mount()
    {
        $this->sync();
    }

    public function render()
    {
        return view('livewire.admin.website-settings.nda');
    }

    public function updatedNdaContent()
    {
        Setting::set('home_nda_content', $this->nda_content);
    }

    public function updatedNdaImage()
    {
        if ($this->nda_image) {
            $path = $this->nda_image->store('uploads', 'public');
            Setting::set('home_nda_image', Storage::url($path));
            $this->nda_image = null;
            $this->success('Updated successfully');
            $this->sync();
        }
    }

    public function sync()
    {
        $this->nda_content = config('settings.home_nda_content');
        $this->nda_image_url = config('settings.home_nda_image', 'https://picsum.photos/200/200');
    }

    public function submit()
    {
        $this->success($this->nda_content);
    }
}
