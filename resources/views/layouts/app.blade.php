<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" type="image/png" href="{{ asset("img/favicon.png") }}">

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        @stack('styles')

        @livewireStyles

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
      <!-- Global site tag (gtag.js) - Google Analytics -->
      <script async src="https://www.googletagmanager.com/gtag/js?id=G-D3B43MPKPP"></script>
      <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-D3B43MPKPP');
      </script>
    </head>
    <body class="font-sans antialiased scroll-smooth">
        <x-jet-banner />

        <div class="min-h-screen bg-gray-100">
            @livewire('navbar')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow hidden">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="mt-[4.25rem] snap-y">
                {{ $slot }}
            </main>
            <x-loading />
        </div>
        <footer class="bg-primary text-primary-content py-4">
            <div class="pg-container flex flex-col md:flex-row justify-between gap-4 items-center w-full">
                <div class="flex-1 text-center md:text-left leading-7 space-y-4 hidden">
                    <div class="font-bold text-2xl">About Us</div>
                    <p>
                        B2E Hub an Indian Enterprise is the Brain Child of the Trio???s - Kaarthik, Srinivasan and Senthilnathan who has a vast knowledge and Expertise Engineering &Technology were located at the iconic city Chennai.
                    </p>
                </div>
                <div class="text-center leading-9 flex flex-col md:flex-row gap-4">
                    <a href="{{ request()->routeIs('home') ? '' : route('home') }}" class="link link-hover">Home</a>
                    <a href="{{ request()->routeIs('home') ? '' : route('home') }}#about_us" class="link link-hover">About Us</a>
                    <a href="{{ request()->routeIs('home') ? '' : route('home') }}#knowledge_centre" class="link link-hover">Knowledge Centre</a>
                    <a href="{{ route('blog') }}" class="link link-hover">Blog</a>
                    <a href="{{ route('faq') }}" class="link link-hover">FAQ</a>
                    {{-- <a target="_blank" href="{{ route('terms.show') }}" class="link link-hover">{{ __('Terms of Service') }}</a> --}}
                    {{-- <a target="_blank" href="{{ route('policy.show') }}" class="link link-hover">{{ __('Privacy Policy') }}</a> --}}
                    <a href="{{ request()->routeIs('home') ? '' : route('home') }}#contact_us" class="link link-hover">Contact Us</a>
                </div>
                <div class="text-center md:text-right leading-8">
                    <div class="flex justify-center md:justify-end">
                        <a target="_blank" class="mx-2 hidden">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="fill-current">
                                <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"></path>
                            </svg>
                        </a>
                        <a target="_blank" class="mx-2 hidden">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="fill-current"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                        </a>
                        <a target="_blank" href="https://www.linkedin.com/in/b2e-hub-92ab39229/?trk=people_directory&originalSubdomain=in" class="mx-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="fill-current"><path d="M4.98 3.5c0 1.381-1.11 2.5-2.48 2.5s-2.48-1.119-2.48-2.5c0-1.38 1.11-2.5 2.48-2.5s2.48 1.12 2.48 2.5zm.02 4.5h-5v16h5v-16zm7.982 0h-4.968v16h4.969v-8.399c0-4.67 6.029-5.052 6.029 0v8.399h4.988v-10.131c0-7.88-8.922-7.593-11.018-3.714v-2.155z"/></svg>
                        </a>
                        <a target="_blank" href="https://www.facebook.com/HubB2E" class="mx-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="fill-current">
                                <path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"></path>
                            </svg>
                        </a>
                        <a target="_blank" href="https://www.instagram.com/b2e_hub/" class="mx-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="fill-current"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        <a target="_blank" href="https://twitter.com/HubB2e" class="mx-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="fill-current">
                                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </footer>
        <footer class="px-10 py-4 text-primary-content" style="background-color: #222222;">
            <div class="pg-container flex justify-between items-center">
                <p class="uppercase text-center md:text-left"><span class="text-xl">&#9400;</span> {{ date('Y') }} <span class="font-extrabold">{{ config('app.name') }}</span>. All Rights Reserved</p>
                <img src="{{ asset('img/logo.png') }}" class="w-24 hidden md:inline" />
            </div>
        </footer>

        @stack('modals')

        @livewireScripts

        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <x-livewire-alert::scripts />

        <script>
            function timer(expiry, reload = true) {
                return {
                    expiry: expiry,
                    remaining: null,
                    interval: null,
                    reload: reload,
                    reloaded: false,
                    ended: false,
                    init() {
                        this.setRemaining();
                    },
                    setRemaining() {
                        const diff = this.expiry - new Date().getTime();
                        if (diff < 1000) {
                            this.ended = true;
                            console.log('timer ended')
                            if (!this.reloaded && this.reload) {
                                console.log('reloading...')
                                this.reloaded = true
                                // location.reload();
                                setTimeout(function () {
                                    location.reload()
                                }, 1000)
                            }
                        }
                        else {
                            this.remaining = parseInt(diff / 1000);
                            setTimeout(() => {
                                this.setRemaining()
                            }, 1000)
                        }
                    },
                    days() {
                        return {
                            value: this.remaining / 86400,
                            remaining: this.remaining % 86400
                        };
                    },
                    hours() {
                        return {
                            value: this.days().remaining / 3600,
                            remaining: this.days().remaining % 3600
                        };
                    },
                    minutes() {
                        return {
                            value: this.hours().remaining / 60,
                            remaining: this.hours().remaining % 60
                        };
                    },
                    seconds() {
                        return {
                            value: this.minutes().remaining
                        };
                    },
                    format(value) {
                        return ("0" + parseInt(value)).slice(-2);
                    },
                    time() {
                        if (this.ended) {
                            return {
                                days: this.format(0),
                                hours: this.format(0),
                                minutes: this.format(0),
                                seconds: this.format(0)
                            }
                        }
                        return {
                            days: this.format(this.days().value),
                            hours: this.format(this.hours().value),
                            minutes: this.format(this.minutes().value),
                            seconds: this.format(this.seconds().value)
                        };
                    }
                };
            }

            function printSection(id) {
                var prtContent = document.getElementById(id);
                var WinPrint = window.open('', '', 'left=0,top=0,width=384,height=900,toolbar=0,scrollbars=0,status=0');
                WinPrint.document.write('<html><head>');
                WinPrint.document.write('<link rel="stylesheet" href="{{ mix('css/app.css') }}">');
                WinPrint.document.write('</head><body class="bg-gray-100" onload="print();close();">');
                WinPrint.document.write(prtContent.outerHTML);
                WinPrint.document.write('</body></html>');
                WinPrint.document.close();
                WinPrint.focus();
            }

            function copyToClipboard(el) {
                /* Get the text field */
                var copyText = document.getElementById(el);

                /* Select the text field */
                copyText.select();
                copyText.setSelectionRange(0, 99999); /* For mobile devices */

                /* Copy the text inside the text field */
                navigator.clipboard.writeText(copyText.value);

                /* Alert the copied text */
                alert("Copied the text: " + copyText.value);
            }
        </script>
        @stack('scripts')
    </body>
</html>
