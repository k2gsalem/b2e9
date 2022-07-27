<?php

namespace App\Http\Livewire\Auth;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Livewire\Component;

class PhoneVerification extends Component
{
    public $otp;
    public $code;

    protected $validationAttributes = [
        'code' => 'OTP'
    ];

    public function rules()
    {
        return [
            'code' => [
                'required',
                'numeric',
                Rule::exists('one_time_passwords')->where('id', $this->otp->id)->whereNull('verified_at')
            ]
        ];
    }

    public function mount(Request $request)
    {
        $this->otp = $request->user()->sendPhoneVerificationNotification();
        session()->flash('status', 'OTP sent successfully.');
    }

    public function render()
    {
        return view('livewire.auth.phone-verification')->layout('layouts.guest');
    }

    public function resend()
    {
        $this->otp->send();
        session()->flash('status', 'OTP resent successfully.');
    }

    public function verify(Request $request)
    {
        $this->validate();
        if ($this->otp->verify($this->code)) {
            $request->user()->phone_verified_at = now();
            $request->user()->save();
            return redirect()->intended('dashboard');
        }
        else
            session()->flash('status', 'Failed to verify');
    }
}
