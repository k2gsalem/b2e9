<?php

namespace App\Http\Livewire\Admin\Auth;

use App\Models\Admin;
use App\Models\OneTimePassword;
use App\Traits\LivewireAlert;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Rules\Password;
use Livewire\Component;

class ForgotPassword extends Component
{
    use LivewireAlert;

    public $username;
    public $user;
    public $otp;
    public $code;
    public $password;
    public $password_confirmation;

    public function render()
    {
        return view('livewire.admin.auth.forgot-password')
            ->layout('layouts.admin.guest-layout');
    }

    public function sendOTP()
    {
        $this->resetErrorBag();
        if ($this->username) {
            $this->user = Admin::query()
                ->where('email', $this->username)
                ->first();
            if ($this->user) {
                $this->otp = OneTimePassword::query()->create([
                    'phone' => $this->user->phone,
                    'email' => $this->user->email
                ]);
                $this->otp->send();
//                $this->code = $this->otp->code;
                $this->success('OTP has been sent to your Email address');
            }
            else
                $this->addError('username', 'Account not found');
        }
        else
            $this->addError('username', 'This field is required');
    }

    public function verifyOTP()
    {
        $data = $this->validate([
            'code' => [
                'required', 'numeric',
                Rule::exists('one_time_passwords')
                    ->where('id', $this->otp->id)
                    ->whereNull('verified_at')
            ],
            'password' => ['required', 'string', new Password, 'confirmed'],
        ]);

        $this->user->forceFill([
            'password' => Hash::make($data['password']),
        ])->save();

        $this->flash('success', 'New password updated successfully', [], route('admin.login'));
    }
}
