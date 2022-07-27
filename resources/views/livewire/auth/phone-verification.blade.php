<div class="bg-right bg-cover bg-no-repeat lg:bg-center"
     style="background-image: url({{ asset('img/bg-auth.jpg') }})">
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
            <div class="card max-w-md ml-auto">
                <div class="card-body space-y-8">
                    <h2 class="text-center text-2xl font-bold uppercase">Phone Verification</h2>
                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">OTP (One-Time Password)</span>
                        </label>
                        <div class="input-group">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                            </svg>
                        </span>
                            <input type="text" wire:model.defer="code" class="input input-bordered" />
                        </div>
                        <label class="label">
                            @error('code') <span class="text-error label-text-alt">{{ $message }}</span>@enderror
                        </label>
                    </div>
                    <div>
                        <button type="button" wire:click="verify" class="btn btn-primary btn-block font-bold">Verify</button>
                    </div>
                    @csrf
                    <div class="text-center pt-5">
                        OTP not received? <button type="button" wire:click="resend" class="text-secondary underline">Resend</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
