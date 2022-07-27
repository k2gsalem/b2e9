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
                <form method="post" action="{{ route('login') }}" class="card-body md:space-y-4">
                    <h2 class="text-center text-2xl font-bold uppercase mb-5">Sign In</h2>

                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('status') }}
                        </div>
                    @endif
                    <x-form.text-input type="text" name="username" label="Email address / Phone number" autocomplete="off" required />
                    <div class="space-y-2">
                        <div class="pt-5">
                            <div class="relative">
                                <input :type="showPassword ? 'text' : 'password'" id="password" name="password" placeholder="Password"
                                       class="peer w-full h-12 pl-3 py-2 text-lg rounded-lg border border-gray-300 text-gray-500 placeholder-transparent focus:outline-none focus:ring-transparent focus:border-2 focus:border-secondary"
                                />
                                <label for="password" class="absolute left-3 -top-3.5 text-gray-600 text-base transition-all bg-white px-2 rounded-lg
                        peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3 peer-placeholder-shown:px-0
                        peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-base peer-focus:px-2">
                                    Password <span class="text-error">*</span>
                                </label>
                                <span @click="showPassword = !showPassword" class="absolute right-3 top-3 cursor-pointer">
                                <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </span>
                            </div>
                            @error('password')<span class="text-error text-sm pl-2">{{ $message }}</span> @enderror
                        </div>
                        <div class="flex justify-between gap-4 pt-1">
                            <label for="remember_me" class="flex items-center">
                                <x-jet-checkbox id="remember_me" name="remember" />
                                <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                            </label>
                            <a href="{{ route('forgot-password') }}">Forgot Password?</a>
                        </div>
                    </div>
                    <div class="pt-5">
                        <button type="submit" class="btn btn-primary btn-block font-bold">Login</button>
                    </div>
                    @csrf
                    <div class="text-center pt-5">
                        Don't have an account? <a href="{{ route('register') }}" class="text-secondary underline">Signup</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
