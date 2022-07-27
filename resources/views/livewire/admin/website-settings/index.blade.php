<div>
    <header class="bg-primary text-primary-content shadow">
        <div class="flex justify-between items-center py-4 px-4 sm:px-6 lg:px-8">
            <div class="font-semibold text-xl">
                {{ __('Website Settings') }}
            </div>
        </div>
    </header>

    <main class="p-6 space-y-6">
        <div class="card compact">
            <div class="card-body">
                <div class="flex gap-4">
                    <ul class="menu text-base border-r min-w-[12rem] shrink-0">
                        <li class="hover:bordered font-bold {{ $section == 'banners' ? 'active bordered' : '' }}">
                            <a wire:click="$set('section', 'banners')">Banners</a>
                        </li>
                        <li class="hover:bordered font-bold {{ $section == 'about_us' ? 'active bordered' : '' }}">
                            <a wire:click="$set('section', 'about_us')">About Us</a>
                        </li>
                        <li class="hover:bordered font-bold {{ $section == 'nda' ? 'active bordered' : '' }}">
                            <a wire:click="$set('section', 'nda')">NDA</a>
                        </li>
                        <li class="hover:bordered font-bold {{ $section == 'how_works' ? 'active bordered' : '' }}">
                            <a wire:click="$set('section', 'how_works')">How It Works?</a>
                        </li>
                        <li class="hover:bordered font-bold {{ $section == 'stats' ? 'active bordered' : '' }}">
                            <a wire:click="$set('section', 'stats')">Stats</a>
                        </li>
                        <li class="hover:bordered font-bold {{ $section == 'contact_us' ? 'active bordered' : '' }}">
                            <a wire:click="$set('section', 'contact_us')">Contact Us</a>
                        </li>
                        <li class="hover:bordered font-bold hidden {{ $section == 'footer' ? 'active bordered' : '' }}">
                            <a wire:click="$set('section', 'footer')">Footer</a>
                        </li>
                        <li class="hover:bordered font-bold {{ $section == 'promo' ? 'active bordered' : '' }}">
                            <a wire:click="$set('section', 'promo')">Promo Ad</a>
                        </li>
                    </ul>
                    <div class="grow">
                        @switch($section)
                            @case('banners')
                                @livewire('admin.website-settings.banners')
                            @break
                            @case('about_us')
                                @livewire('admin.website-settings.about-us')
                            @break
                            @case('nda')
                            @livewire('admin.website-settings.nda')
                            @break
                            @case('how_works')
                                @livewire('admin.website-settings.how-works')
                            @break
                            @case('stats')
                                @livewire('admin.website-settings.stats')
                            @break
                            @case('contact_us')
                                @livewire('admin.website-settings.contact-us')
                            @break
                            @case('promo')
                                @livewire('admin.website-settings.promo-banner')
                            @break
                        @endswitch
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
