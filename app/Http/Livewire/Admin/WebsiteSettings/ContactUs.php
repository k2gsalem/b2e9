<?php

namespace App\Http\Livewire\Admin\WebsiteSettings;

use App\Models\Setting;
use App\Traits\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class ContactUs extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public $fields = [
        'phone' => '',
        'email' => '',
        'toll_free' => '',
        'rfq_percentage' => 3
    ];

    public function mount()
    {
        foreach ($this->fields as $field => $val) {
            $this->fields[$field] = config('settings.support_'.$field);
        }
    }

    public function render()
    {
        return view('livewire.admin.website-settings.contact-us');
    }

    public function updated($field)
    {
        switch ($field) {
            case 'fields.phone':
                Setting::set('support_phone', $this->getPropertyValue($field));
                break;
            case 'fields.email':
                Setting::set('support_email', $this->getPropertyValue($field));
                break;
            case 'fields.toll_free':
                Setting::set('support_toll_free', $this->getPropertyValue($field));
                break;
            case 'fields.rfq_percentage':
                Setting::set('support_rfq_percentage', $this->getPropertyValue($field));
                break;
        }
    }
}
