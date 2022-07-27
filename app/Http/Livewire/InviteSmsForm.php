<?php

namespace App\Http\Livewire;

use App\Notifications\ReferralInvite;
use App\Traits\LivewireAlert;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;

class InviteSmsForm extends Component
{
    use LivewireAlert;

    public $phone;

    public function render()
    {
        return view('livewire.invite-sms-form');
    }

    public function rules()
    {
        return [
            'phone' => ['required', 'regex:/[6-9][0-9]{9}/']
        ];
    }

    public function submit()
    {
        $this->validate();
        Notification::route('sms', $this->phone)->notify(new ReferralInvite(auth()->user()));
        $this->phone = '';
        $this->success('Invitation sent successfully');
    }
}
