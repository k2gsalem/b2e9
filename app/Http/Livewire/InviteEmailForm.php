<?php

namespace App\Http\Livewire;

use App\Notifications\ReferralInvite;
use App\Traits\LivewireAlert;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;

class InviteEmailForm extends Component
{
    use LivewireAlert;

    public $email;

    public function render()
    {
        return view('livewire.invite-email-form');
    }

    public function rules()
    {
        return [
            'email' => ['required', 'email']
        ];
    }

    public function submit()
    {
        $this->validate();
        Notification::route('mail', $this->email)->notify(new ReferralInvite(auth()->user()));
        $this->phone = '';
        $this->success('Invitation sent successfully');
    }
}
