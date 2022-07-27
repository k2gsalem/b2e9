<?php

namespace App\Http\Livewire\Admin\WebsiteSettings;

use App\Traits\LivewireAlert;
use Livewire\Component;

class Index extends Component
{
    use LivewireAlert;

    public $section = 'banners';

    public function render()
    {
        return view('livewire.admin.website-settings.index')->layout('layouts.admin.app-layout');
    }
}
