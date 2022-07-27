<?php

namespace App\Http\Livewire;

use App\Models\ContactEnquiry;
use App\Traits\LivewireAlert;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class ContactForm extends Component
{
    use LivewireAlert;

    public $contact_enquiry;

    public function mount()
    {
        $this->contact_enquiry = new ContactEnquiry();
    }

    public function render()
    {
        return view('livewire.contact-form');
    }

    public function rules()
    {
        return [
            'contact_enquiry.name' => ['required', 'string', 'max:255'],
            'contact_enquiry.email' => ['required', 'email', 'max:255'],
            'contact_enquiry.company' => ['required', 'string', 'max:255'],
            'contact_enquiry.phone' => ['required', 'string', 'max:255'],
            'contact_enquiry.message' => ['required', 'string']
        ];
    }

    public function getInTouch()
    {
        $this->validate();

        $this->contact_enquiry->save();
        Mail::to("info@b2ehub.com")
            ->send(new \App\Mail\ContactEnquiry($this->contact_enquiry));
        $this->contact_enquiry = new ContactEnquiry();
        $this->success('Thank you for reaching us. We will contact you ASAP');
    }
}
