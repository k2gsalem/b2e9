<div class="min-h-screen w-full flex justify-center items-center">
    <div class="max-w-md w-full space-y-12">
        <img src="{{ asset('img/logo.png') }}" class="w-full max-w-sm mx-auto" />
        <div class="card">
            <form wire:submit.prevent="{{ $otp ? 'verifyOTP' : 'sendOTP' }}" class="card-body space-y-4">
                <h2 class="card-title text-center">Forgot Password</h2>
                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @endif
                @if($otp)
                    <x-form.text-input wire:model.defer="username"
                                       name="username"
                                       label="Email address"
                                       autocomplete="off" disabled />
                    <x-form.text-input type="number"
                                       wire:model.defer="code"
                                       name="code"
                                       label="OTP (One-Time Password)"
                                       autocomplete="off" required />
                    <x-form.text-input type="password"
                                       wire:model.defer="password"
                                       name="password"
                                       label="New Password"
                                       autocomplete="new-password" required />
                    <x-form.text-input type="password"
                                       wire:model.defer="password_confirmation"
                                       name="password_confirmation"
                                       label="Confirm Password"
                                       autocomplete="new-password" required />
                    <div class="pt-8">
                        <button type="submit" class="btn btn-primary btn-block font-bold">Reset Password</button>
                    </div>
                @else
                    <x-form.text-input wire:model.defer="username"
                                       name="username"
                                       label="Email address"
                                       autocomplete="off" required />
                    <div class="pt-8">
                        <button type="submit" class="btn btn-primary btn-block font-bold">Send OTP</button>
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>
