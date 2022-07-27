<nav x-data="{ open: false }" class="bg-white border-b border-primary fixed inset-x-0 top-0 z-30 h-[4.25rem]">
    <!-- Primary Navigation Menu -->
    <div class="pg-container">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <x-navbar-logo class="block h-9 w-auto" />
                    </a>
                </div>
            </div>

            <div class="hidden gap-2 sm:flex sm:items-center sm:-my-px sm:ml-6">
                <a href="{{ route('home') }}" class="normal-case font-normal tracking-widest p-2 btn btn-ghost rounded-full hover:btn-primary">
                    {{ __('Home') }}
                </a>
                <a href="{{ request()->routeIs('home') ? '' : route('home') }}#about_us" class="normal-case font-normal tracking-widest p-2 btn btn-ghost rounded-full hover:btn-primary">
                    {{ __('About Us') }}
                </a>
                <a href="{{ request()->routeIs('home') ? '' : route('home') }}#how_works" class="normal-case font-normal tracking-widest p-2 btn btn-ghost rounded-full hover:btn-primary">
                    {{ __('How It Works') }}
                </a>
                <a href="{{ request()->routeIs('home') ? '' : route('home') }}#knowledge_centre" class="normal-case font-normal tracking-widest p-2 btn btn-ghost rounded-full hover:btn-primary">
                    {{ __('Knowledge Centre') }}
                </a>
                <a href="{{ route('blog') }}" class="normal-case font-normal tracking-widest p-2 btn rounded-full {{ request()->routeIs('blog') ? 'btn-primary' : 'btn-ghost hover:btn-primary' }}">
                    {{ __('Blog') }}
                </a>
                <a href="{{ route('faq') }}" class="normal-case font-normal tracking-widest p-2 btn rounded-full {{ request()->routeIs('faq') ? 'btn-primary' : 'btn-ghost hover:btn-primary' }}">
                    {{ __('FAQ') }}
                </a>
                <a href="{{ request()->routeIs('home') ? '' : route('home') }}#contact_us" class="normal-case font-normal tracking-widest p-2 btn btn-ghost rounded-full hover:btn-primary">
                    {{ __('Contact Us') }}
                </a>
                @auth
                    <a href="{{ route('dashboard') }}" class="normal-case font-normal tracking-widest p-2 btn rounded-full {{ request()->routeIs('dashboard') ? 'btn-primary' : 'btn-ghost hover:btn-primary' }}">
                        {{ __('Dashboard') }}
                    </a>

                    <!-- Settings Dropdown -->
                    <div class="ml-3 relative">
                        <x-jet-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                    <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                        <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                    </button>
                                @else
                                    <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                        {{ Auth::user()->name }}

                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </span>
                                @endif
                            </x-slot>

                            <x-slot name="content">
                                <!-- Account Management -->
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    {{ __('Manage Account') }}
                                </div>

                                <x-jet-dropdown-link href="{{ route('profile.show') }}">
                                    {{ __('Profile') }}
                                </x-jet-dropdown-link>

                                <x-jet-dropdown-link href="{{ route('invite') }}">
                                    {{ __('Refer & Earn') }}
                                </x-jet-dropdown-link>

                                @if(in_array(auth()->user()->role, ['supplier', 'both']))
                                    <x-jet-dropdown-link href="{{ route('supplier.plans.index') }}">
                                        {{ __('Membership Plans') }}
                                    </x-jet-dropdown-link>
                                @endif

                                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                    <x-jet-dropdown-link href="{{ route('api-tokens.index') }}">
                                        {{ __('API Tokens') }}
                                    </x-jet-dropdown-link>
                                @endif

                                <div class="border-t border-gray-100"></div>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <x-jet-dropdown-link href="{{ route('logout') }}"
                                                         onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-jet-dropdown-link>
                                </form>
                            </x-slot>
                        </x-jet-dropdown>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="normal-case font-normal tracking-widest p-2 btn rounded-full {{ request()->routeIs('login') ? 'btn-primary' : 'btn-ghost hover:btn-primary' }}">
                        {{ __('Login / Signup') }}
                    </a>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white">
        <div class="pt-2 pb-3 space-y-1">
            <x-jet-responsive-nav-link href="{{ route('home') }}">
                {{ __('Home') }}
            </x-jet-responsive-nav-link>
            <x-jet-responsive-nav-link href="{{ route('home') }}#about_us">
                {{ __('About Us') }}
            </x-jet-responsive-nav-link>
            <x-jet-responsive-nav-link href="{{ route('home') }}#how_works">
                {{ __('How B2E Works') }}
            </x-jet-responsive-nav-link>
            <x-jet-responsive-nav-link href="{{ route('home') }}#knowledge_centre">
                {{ __('Knowledge') }}
            </x-jet-responsive-nav-link>
            <x-jet-responsive-nav-link href="{{ route('faq') }}">
                {{ __('FAQ') }}
            </x-jet-responsive-nav-link>
            <x-jet-responsive-nav-link href="{{ route('home') }}#contact_us">
                {{ __('Contact Us') }}
            </x-jet-responsive-nav-link>
        </div>

        @auth()
            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="flex items-center px-4">
                    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                        <div class="flex-shrink-0 mr-3">
                            <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                        </div>
                    @endif

                    <div>
                        <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                </div>

                <div class="mt-3 space-y-1">
                    <!-- Account Management -->
                    <x-jet-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-jet-responsive-nav-link>
                    <x-jet-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                        {{ __('Profile') }}
                    </x-jet-responsive-nav-link>

                    @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                        <x-jet-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                            {{ __('API Tokens') }}
                        </x-jet-responsive-nav-link>
                @endif

                <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-jet-responsive-nav-link href="{{ route('logout') }}"
                                                   onclick="event.preventDefault();
                                this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-jet-responsive-nav-link>
                    </form>
                </div>
            </div>
        @else
            <x-jet-responsive-nav-link href="{{ route('login') }}">
                {{ __('Login / Signup') }}
            </x-jet-responsive-nav-link>
        @endauth
    </div>
    <div class="w-full border-b border-primary mb-px"></div>
</nav>
