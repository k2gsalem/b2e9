<div>
    <div class="pg-container">

        <div class="hidden">{{ print_r(request()->cookies) }}</div>
        <section class="grid grid-cols-4 gap-1 md:gap-4 py-2">
            <img src="{{ $banners['banner1'] }}" class="w-full h-24 md:h-72 object-cover rounded shadow">
            <img src="{{ $banners['banner2'] }}" class="w-full h-24 md:h-72 object-cover rounded shadow col-span-2">
            <img src="{{ $banners['banner3'] }}" class="w-full h-24 md:h-72 object-cover rounded shadow">
        </section>

        <section class="relative flex overflow-x-hidden my-4">
            <div class="flex gap-4 animate-marquee whitespace-nowrap">
                @foreach($materials as $item)
                    <span class="flex flex-col items-center justify-center shadow rounded p-2 bg-white">
                        <span class="font-bold text-gray-500 whitespace-nowrap">{{ $item->title }}</span>
                        <span class="font-bold flex">
                            {{ config('app.currency_symbol').$item->price }}
                            @if($item->price > $item->old_price)
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#ff0000]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                            @elseif($item->price < $item->old_price)
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#008000]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                                </svg>
                            @endif
                        </span>
                    </span>
                @endforeach
            </div>

            <div class="absolute top-0 flex gap-4 animate-marquee2 whitespace-nowrap ml-4">
                @foreach($materials as $item)
                    <span class="flex flex-col items-center justify-center shadow rounded p-2 bg-white">
                        <span class="font-bold text-gray-500 whitespace-nowrap">{{ $item->title }}</span>
                        <span class="font-bold flex">
                            {{ config('app.currency_symbol').$item->price }}
                            @if($item->price > $item->old_price)
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#ff0000]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                            @elseif($item->price < $item->old_price)
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#008000]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                                </svg>
                            @endif
                        </span>
                    </span>
                @endforeach
            </div>
        </section>
        <section class="py-4 hidden">
            <div id="materials-carousel-sm" class="md:hidden">
                @foreach($materials as $item)
                    <div class="px-2">
                        <div class="text-center shadow rounded p-2 bg-white">
                            <div class="font-bold text-gray-500">{{ $item->title }}</div>
                            <div class="font-bold inline-flex">
                                {{ config('app.currency_symbol').$item->price }}
                                @if($item->price > $item->old_price)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-error" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                    </svg>
                                @elseif($item->price < $item->old_price)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-success" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                                    </svg>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div id="materials-carousel" class="hidden md:block">
                @foreach($materials as $item)
                    <div class="px-1">
                        <div class="text-center shadow rounded p-2 bg-white">
                            <div class="font-bold text-sm text-gray-500 whitespace-normal">{{ $item->title }}</div>
                            <div class="font-bold text-sm inline-flex">
                                {{ config('app.currency_symbol').$item->price }}
                                @if($item->price > $item->old_price)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-error" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                    </svg>
                                @elseif($item->price < $item->old_price)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-success" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                                    </svg>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @push('scripts')
                <script src="{{ asset('js/MultiCarousel.js') }}"></script>
                <script>
                    const container = document.getElementById('materials-carousel');
                    const carousel = new MultiCarousel({
                        target: container,
                        props: {
                            items: [...container.children],
                            // The rest of these are optional. Here are the defaults.
                            delay: 1600, // Delay between slides.
                            transition: 1500, // Duration of slide transition.
                            count: 9, // How many items to show at once.
                            controls: [ // Which controls are visible.
                                'previous',
                                'next',
                            ]
                        }
                    });
                    const container2 = document.getElementById('materials-carousel-sm');
                    const carousel2 = new MultiCarousel({
                        target: container2,
                        props: {
                            items: [...container2.children],
                            // The rest of these are optional. Here are the defaults.
                            delay: 3000, // Delay between slides.
                            transition: 1500, // Duration of slide transition.
                            count: 1, // How many items to show at once.
                            controls: [ // Which controls are visible.
                                'previous',
                                'next',
                            ]
                        }
                    });
                </script>
            @endpush
        </section>

        <section id="about_us" class="py-4 scroll-mt-[4.25rem]">
            <div class="bg-white border-2 border-secondary rounded-lg p-4 flex flex-col md:flex-row gap-4">
                <div x-data="{ open: false }" class="grow">
                    <div class="text-2xl font-bold mb-4">About US</div>
                    <div class="text-justify" :class="open ? '' : 'line-clamp-5'" style="-webkit-line-clamp: 12!important;">
                        {!! config('settings.home_about_us_content') !!}
                    </div>
                    <a @click="open = true" x-show="! open" href="javascript:void(0)" class="link link-primary">Show more</a>
                    <a @click="open = false" x-show="open" href="javascript:void(0)" class="link link-primary">Show less</a>
                </div>
                @if(config('settings.home_about_us_image'))
                    <img src="{{ config('settings.home_about_us_image') }}" class="h-80 w-[20rem] object-cover rounded">
                @endif
            </div>
        </section>

        <section class="py-4">
            <div class="flex mr-auto gap-4" style="max-width: 75%;">
                <div class="grow bg-primary p-1 rounded"></div>
                <div class="bg-primary p-1 rounded"></div>
                <div class="bg-primary p-1 rounded"></div>
                <div class="bg-primary p-1 rounded"></div>
            </div>
        </section>

        <section id="nda" class="py-4 scroll-mt-[4.25rem] hidden">
            <div class="bg-white border-2 border-secondary rounded-lg p-4 flex flex-col md:flex-row gap-4">
                @if(config('settings.home_nda_image'))
                    <img src="{{ config('settings.home_nda_image') }}" class="h-80 max-w-sm object-cover rounded">
                @endif
                <div class="grow">
                    <div class="text-2xl font-bold mb-4">Non-Disclosure Agreement</div>
                    <p class="text-justify">{!! config('settings.home_nda_content') !!}</p>
                </div>
            </div>
        </section>

        <section class="py-4 hidden">
            <div class="flex flex-row-reverse ml-auto gap-4" style="max-width: 75%;">
                <div class="grow bg-primary p-1 rounded"></div>
                <div class="bg-primary p-1 rounded"></div>
                <div class="bg-primary p-1 rounded"></div>
                <div class="bg-primary p-1 rounded"></div>
            </div>
        </section>

        <section id="how_works" class="py-4 scroll-mt-[4.25rem]">
            <div class="bg-white border-2 border-secondary rounded-lg p-4 space-y-4">
                <div class="flex flex-col md:flex-row gap-4">
                    @if(config('settings.home_how_works_image'))
                        <img src="{{ config('settings.home_how_works_image') }}" class="h-80 max-w-sm object-cover rounded">
                    @endif
                    <div class="grow">
                        <div class="text-2xl font-bold mb-4">How It Works?</div>
                        <p class="text-justify">{!! config('settings.home_how_works_content') !!}</p>
                    </div>
                </div>
                @if(config('settings.home_how_works_video'))
                    <div class="max-w-md mx-auto">
                        <div class="aspect-w-16 aspect-h-9">
                            <iframe src="{{ config('settings.home_how_works_video') }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    </div>
                @endif
                <div class="grow">
                    <p class="text-justify">{!! config('settings.home_how_works_video_content') !!}</p>
                </div>
                <div class="grow">
                    <p class="text-justify">{!! config('settings.home_how_works_video2_content') !!}</p>
                </div>
                @if(config('settings.home_how_works_video2'))
                    <div class="max-w-md mx-auto">
                        <div class="aspect-w-16 aspect-h-9">
                            <iframe src="{{ config('settings.home_how_works_video2') }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    </div>
                @endif
                <div class="grow">
                    <p class="text-justify">{!! config('settings.home_how_works_video2_content2') !!}</p>
                </div>
                <div class="grow">
                    <p class="text-justify">{!! config('settings.home_how_works_video3_content') !!}</p>
                </div>
                @if(config('settings.home_how_works_video3'))
                    <div class="max-w-md mx-auto">
                        <div class="aspect-w-16 aspect-h-9">
                            <iframe src="{{ config('settings.home_how_works_video3') }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    </div>
                @endif
                <div class="grow">
                    <p class="text-justify">{!! config('settings.home_how_works_video3_content2') !!}</p>
                </div>
            </div>
        </section>

        <section class="py-4">
            <div class="flex mr-auto gap-4" style="max-width: 75%;">
                <div class="grow bg-primary p-1 rounded"></div>
                <div class="bg-primary p-1 rounded"></div>
                <div class="bg-primary p-1 rounded"></div>
                <div class="bg-primary p-1 rounded"></div>
            </div>
        </section>

        <section id="knowledge_centre" class="py-4 scroll-mt-[4.25rem]">
            <div class="bg-white border-2 border-secondary rounded-lg p-4">
                <div class="text-2xl font-bold mb-4 text-center">Knowledge Centre</div>
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="shrink-0 w-full max-w-sm h-[30rem] overflow-y-auto flex flex-col gap-4">
                        @foreach($processes as $item)
                            <button wire:click="$set('processId', {{ $item->id }})" class="btn btn-secondary btn-block {{ $processId && $processId == $item->id ? '' : 'opacity-50' }}">
                                {{ $item->title }}
                            </button>
                        @endforeach
                    </div>
                    @if($this->process)
                        <div wire:loading.remove class="grow space-y-4">
                            <img src="{{ $this->process->image }}" class="w-full max-h-80 object-contain object-center rounded">
                            <div class="flex flex-col md:flex-row gap-4">
                                <div class="grow">
                                    <div class="text-2xl font-bold uppercase mb-4">{{ $this->process->title }}</div>
                                    <p class="text-justify">{!! $this->process->description !!}</p>
                                    <a target="_blank" href="{{ $this->process->wikipedia }}" class="link link-primary">Read more...</a>
                                </div>
                                <div class="shrink-0 self-center bg-secondary text-secondary-content p-2 flex flex-col gap-2 items-center rounded shadow">
                                    <div class="uppercase">Approximate Cost</div>
                                    <div class="text-3xl font-bold">
                                        {{ $this->process->hourly_price }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>

        <section class="pt-4 pb-8">
            <div class="flex flex-row-reverse ml-auto gap-4" style="max-width: 75%;">
                <div class="grow bg-primary p-1 rounded"></div>
                <div class="bg-primary p-1 rounded"></div>
                <div class="bg-primary p-1 rounded"></div>
                <div class="bg-primary p-1 rounded"></div>
            </div>
        </section>
    </div>
    <div class="bg-secondary">
        <section id="stats" class="bg-white">
            <div class="py-10" style="background-image: url({{ asset('img/bg-counter.jpeg') }})">
                <div class="pg-container flex flex-col md:flex-row justify-between gap-4 text-white">
                    <div class="flex flex-col items-center justify-center gap-4">
                        <div class="uppercase font-bold">Page Visitors</div>
                        <div class="bg-primary px-4 py-3 rounded-2xl font-extrabold text-4xl counter">
                            {{ config('settings.home_stats_visitors') }}
                        </div>
                    </div>
                    <div class="flex flex-col items-center justify-center gap-4">
                        <div class="uppercase font-bold">Projects</div>
                        <div class="bg-primary px-4 py-3 rounded-2xl font-extrabold text-4xl counter">
                            {{ config('settings.home_stats_projects') }}
                        </div>
                    </div>
                    <div class="flex flex-col items-center justify-center gap-4">
                        <div class="uppercase font-bold">Customers</div>
                        <div class="bg-primary px-4 py-3 rounded-2xl font-extrabold text-4xl counter">
                            {{ config('settings.home_stats_clients') }}
                        </div>
                    </div>
                    <div class="flex flex-col items-center justify-center gap-4">
                        <div class="uppercase font-bold">Suppliers</div>
                        <div class="bg-primary px-4 py-3 rounded-2xl font-extrabold text-4xl counter">
                            {{ config('settings.home_stats_customers') }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="blog" class="bg-white">
            <div class="py-10 pg-container">
                <div class="text-4xl font-bold mb-4 uppercase">Latest Post</div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($latest_posts as $post)
                        <a href="{{ route('post', $post) }}" class="flex gap-2">
                            <img src="{{ \Illuminate\Support\Facades\Storage::url($post->image) }}" class="w-[25%] h-24 object-cover" />
                            <div class="">
                                <div class="text-md font-bold line-clamp-1">{{ $post->title }}</div>
                                <div>{{ $post->publish_date->format('d M, Y') }}</div>
                                <div class="text-xs line-clamp-5">{{ $post->summary }}</div>
                            </div>
                        </a>
                    @endforeach
                </div>
                <div class="text-right pt-2">
                    <a href="{{ route('blog') }}" target="_blank" class="text-lg uppercase font-bold">View More...</a>
                </div>
            </div>
        </section>
        <section id="contact_us" class="pt-4 pb-2 bg-primary text-primary-content rounded-b-[25%] scroll-mt-[4.25rem]">
            <div class="pg-container flex justify-between flex-col md:flex-row gap-4 py-6">
                <div class="py-4 space-y-4">
                    <h2 class="text-5xl font-bold text-center md:text-left">Let's do great</h2>
                    <h2 class="text-5xl font-bold text-center md:text-left">Work together</h2>
                    <div class="flex flex-row gap-8 py-4">
                        <div class="space-y-1 flex-1">
                            <div class="text-gray-300 font-bold uppercase">Speak with us</div>
                            <a href="tel://{{ config('settings.support_phone') }}" class="font-bold text-xl">{{ config('settings.support_phone') }}</a>
                        </div>
                        <div class="space-y-1 flex-1">
                            <div class="text-gray-300 font-bold uppercase">Write to us</div>
                            <a href="mailto://{{ config('settings.support_email') }}" class="font-bold text-xl">{{ config('settings.support_email') }}</a>
                        </div>
                    </div>
                    <div class="flex flex-row gap-8 pb-4 hidden">
                        <div class="space-y-1 flex-1">
                            <div class="text-gray-300 font-bold uppercase">Address </div>
                            <div class="font-bold text-xl">
                                NO 87, S3, II FLOOR,<br />SREE ANANTHA LAKSHMI COMPLEX,<br />MTH ROAD, AMBATTUR INDUSTRIAL ESTATE,<br />CHENNAI - 600058, TAMILNADU
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-2 md:gap-8 py-2 md:py-4">
                        <a href="tel://{{ config('settings.support_toll_free') }}" class="bg-secondary text-primary rounded flex items-center gap-2 md:gap-4 p-2 md:p-4">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 md:h-16 w-12 md:w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                            </span>
                            <div>
                                <div class="uppercase text-sm md:text-md text-gray-600">Give a missed call</div>
                                <div class="font-bold text-xl md:text-3xl">{{ config('settings.support_toll_free') }}</div>
                            </div>
                        </a>
                        <div>
                            <div class="text-white">Would you like to talk to<br /> someone in person?</div>
                            <img src="{{ asset('img/contact-us-arrow.png') }}" width="100" />
                        </div>
                    </div>
                </div>
                <div class="max-w-md min-w-sm w-full pt-6 -mb-10">
                    @livewire('contact-form')
                </div>
            </div>
        </section>
        <section class="py-8 text-secondary-content">
            <div class="pg-container">
                @livewire('newsletter-subscription-form')
            </div>
        </section>
    </div>
    <script src="{{ asset('js/waypoints.min.js') }}"></script>
    <script src="https://unpkg.com/counterup2@2.0.2/dist/index.js">	</script>
    <script>
        const counterUp = window.counterUp.default;
        var elements = document.querySelectorAll('.counter')
        elements.forEach(function(element) {
            new Waypoint({
                element: element,
                handler: function(direction) {
                    counterUp( this.element )
                },
                offset: 'bottom-in-view'
            })
        })
    </script>
</div>
