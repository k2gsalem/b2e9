<div x-data="{ showPassword: false }"
     class="bg-right bg-cover bg-no-repeat lg:bg-center"
     style="background-image: url({{ asset('img/bg-auth.jpg') }})" >
    <div class="min-h-screen w-full mx-auto p-6 max-w-7xl flex items-center justify-between">
        <div class="flex-1 hidden lg:flex flex-col items-center justify-center">
            <div class="flex flex-col justify-center px-6 space-y-16">
                <img src="{{ config('settings.promo_banner') }}" class="w-full" />
                <div class="text-center">
                    {{ config('settings.promo_content') }}
                </div>
            </div>
        </div>
        <div class="flex-1">
            <div class="card compact max-w-md ml-auto">
                <form method="post" wire:submit.prevent="{{ $otp ? 'verifyOTP' : 'sendOTP' }}" class="card-body md:space-y-4">
                    <h2 class="text-center text-2xl font-bold uppercase mb-5">Forgot Password</h2>

                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if($otp)
                        <x-form.text-input wire:model.defer="username"
                                           name="username"
                                           label="Email address / Phone number"
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
                                           label="Email address / Phone number"
                                           autocomplete="off" required />
                        <div class="pt-8">
                            <button type="submit" class="btn btn-primary btn-block font-bold">Send OTP</button>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
