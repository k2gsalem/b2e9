<?php

namespace App\Http\Livewire\Admin\Auth;

use App\Models\Admin;
use App\Traits\LivewireAlert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Login extends Component
{
    use LivewireAlert;

    public $email;
    public $password;
    public $remember;

    public function rules()
    {
        return [
            'email' => [
                'required', 'email', 'exists:admins,email'
            ],
            'password' => [
                'required', 'string'
            ]
        ];
    }

    public function render()
    {
        return view('livewire.admin.auth.login')->layout('layouts.admin.guest-layout');
    }

    public function login(Request $request)
    {
        $credentials = $this->validate();

        if (Auth::guard('admin')->attempt($credentials, (bool)$this->remember)) {
            return redirect()->route('admin.dashboard');
        }
        else
            $this->error('Invalid credentials');
        /*$user = Admin::query()->where('email', $this->username)->firstOrFail();
        if ($user && Hash::check($this->password, $user->password)) {
            auth('admin')->login($user, $request->has('remember'));
            return redirect()->route('admin.dashboard');
        }
        else
            $this->addError('password', 'Invalid credentials');*/
    }
}
