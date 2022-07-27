<!--<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <x-jet-welcome />
            </div>
        </div>
    </div>
</x-app-layout>-->
<x-app-layout>
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
            <div class="space-y-8 pt-16 pb-40 min-h-screen flex-1 flex flex-col justify-around items-end">
                <a href="{{ route('customer.dashboard') }}"
                   class="group w-full max-w-sm flex flex-col items-center justify-center shadow-xl bg-secondary text-secondary-content rounded-full p-8 space-y-4 border-white hover:border hover:bg-gradient-to-br from-secondary to-primary">
                    <p class="text-4xl uppercase font-bold">{{ __('Customer') }}</p>
                    <p class="text-base-content group-hover:text-white">{{ __('To get your projects completed') }}</p>
                </a>
                <a href="{{ route('supplier.dashboard') }}"
                   class="group w-full max-w-sm flex flex-col items-center justify-center shadow-xl bg-secondary text-secondary-content rounded-full p-8 space-y-4 border-white hover:border hover:bg-gradient-to-br from-secondary to-primary">
                    <p class="text-4xl uppercase font-bold">{{ __('Supplier') }}</p>
                    <p class="text-base-content group-hover:text-white">{{ __('To work on projects') }}</p>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
