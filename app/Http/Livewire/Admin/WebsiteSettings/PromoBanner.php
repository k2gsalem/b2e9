<?php

namespace App\Http\Livewire\Admin\WebsiteSettings;

use App\Models\Setting;
use App\Traits\LivewireAlert;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class PromoBanner extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public $promo_banner;
    public $promo_banner_url;
    public $promo_content;

    public function mount()
    {
        $this->sync();
    }

    public function render()
    {
        return view('livewire.admin.website-settings.promo-banner');
    }

    public function updated($field)
    {
        switch ($field) {
            case 'promo_banner':
                $this->validate([
                    $field => 'image|max:1024', // 1MB Max
                ]);
                $this->submit();
                break;
            case 'promo_content':
                Setting::set('promo_content', $this->promo_content);
                break;
        }
    }

    public function sync()
    {
        $this->promo_banner_url = config('settings.promo_banner', 'https://picsum.photos/200/200');
        $this->promo_content = config('settings.promo_content');
    }

    public function submit()
    {
        if ($this->promo_banner) {
            $path = $this->promo_banner->store('uploads', 'public');
            Setting::set('promo_banner', Storage::url($path));
            $this->promo_banner = null;
        }
        $this->sync();
        $this->success('Updated successfully');
    }
}
