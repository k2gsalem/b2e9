<div>
    <div class="bg-secondary text-secondary-content">
        <div class="pg-container space-y-6 py-6">
            <div class="flex flex-col gap-4 justify-between uppercase sm:flex-row sm:items-center sm:text-left">
                <div class="space-y-3">
                    <h2 class="hidden text-2xl font-bold sm:block sm:text-4xl">{{ auth()->user()->name }}</h2>
                    <hr class="hidden sm:block" />
                    <div class="flex flex-col gap-4 sm:flex-row sm:text-2xl">
                        <div>Total RFQ : <span class="text-primary font-bold">{{ $total_rfq }}</span></div>
                        <div class="hidden sm:block">|</div>
                        <div>Live/Open RFQ : <span class="text-primary font-bold">{{ $live_rfq }}</span></div>
                    </div>
                </div>
                <div class="flex items-center gap-4 order-first sm:flex-col sm:order-last">
                    <div class="avatar">
                        <div class="rounded-full w-12 h-12 ring ring-secondary-content ring-offset-base-100 ring-offset-1 sm:w-24 sm:h-24 sm:ring-offset-2">
                            <img src="{{ auth()->user()->profile_photo_url }}" />
                        </div>
                    </div>
                    <div class="flex flex-col gap-2 sm:items-center">
                        @if($user->subscription)
                            <div class="bg-primary text-primary-content rounded px-3 py-1 sm:py-2 sm:px-6">
                                {{ $user->subscription->plan->title }}
                            </div>
                            <div class="text-sm sm:text-md">
                                {{ __('Member since : ') }}
                                <span class="text-primary font-bold">
                                    {{ $user->created_at->format('d M, Y') }}
                                </span>
                            </div>
                            <div class="text-sm sm:text-md hidden">
                                {{ __('Valid till : ') }}
                                <span class="text-primary font-bold">
                                    {{ $user->subscription->ends_at->format('d M, Y') }}
                                </span>
                            </div>
                        @else
                            <div class="bg-primary text-primary-content rounded px-3 py-1 sm:py-2 sm:px-6">
                                {{ 'FREE MEMBER' }}
                            </div>
                            <div class="text-sm sm:text-md">
                                {{ __('Member since: ') }}
                                <span class="text-primary font-bold">
                                    {{ $user->created_at->format('d M, Y') }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pg-container space-y-8 py-6 mt-6">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-12">
            <div class="md:col-span-6">
                <x-form.text-input type="text" wire:model="search" name="search" label="Search" />
            </div>
            <div class="md:col-span-3">
                <x-form.text-input type="date" wire:model.lazy="filter.start_date" name="filter.start_date" label="Start Date" />
            </div>
            <div class="md:col-span-3">
                <x-form.text-input type="date" wire:model.lazy="filter.end_date" name="filter.end_date" label="End Date" />
            </div>
        </div>
        <div class="bg-white shadow rounded-lg">
            <table class="table table-compac table-zebra">
                <thead>
                <tr>
                    <th>S.No.</th>
                    <th>Txn ID</th>
                    <th>Project Title</th>
                    <th>Select BID ({{ config('app.currency_symbol') }})</th>
                    <th>Auction Time</th>
                    <th>Selected Supplier</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                @if(count($items) < 1)
                    <tr>
                        <td colspan="100">
                            <div class=" text-center">
                                {{ __('No records found') }}
                            </div>
                        </td>
                    </tr>
                @endif
                @foreach($items as $item)
                    <tr wire:click="itemDetails({{ $item->id }})" wire:key="{{ $item->id }}" class="group hover rounded-none cursor-pointer">
                        <td>{{ $loop->index + $items->firstItem() }}</td>
                        <td>{{ $item->txn_id }}</td>
                        <td>
                            <div class="tooltip tooltip-bottom"
                                 data-tip="{{ $item->title }}">
                                <div class="truncate max-w-[10rem]">
                                    {{ $item->title }}
                                </div>
                            </div>
                        </td>
                        <td>
                            {{ $item->selected_bid_value }}
                        </td>
                        <td>
                            @switch($item->status)
                                @case(\App\Models\Project::STATUS_SCHEDULED)
                                    <x-timer class="text-2xl font-bold text-secondary group-hover:text-primary" value="{{ $item->publish_at }}" />
                                @break
                                @case(\App\Models\Project::STATUS_ONGOING)
                                    <x-timer class="text-2xl font-bold text-secondary group-hover:text-primary" value="{{ $item->close_at }}" />
                                @break
                            @endswitch
                        </td>
                        <td>
                            @if($item->selected_bid)
                                {{ $item->selected_bid->user->name }}
                            @endif
                        </td>
                        <td>
                            <span class="badge badge-primary font-bold">
                                {{ $item->status }}
                            </span>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="flex flex-col lg:flex-row gap-4">
            <div class="lg:grow">
                {{ $items->links() }}
            </div>
            <button wire:click="showIntro" class="btn btn-primary btn-outline hidden">Show Instructions</button>
            <a href="{{ route('customer.projects.create') }}" class="btn btn-primary">Create New RFQ</a>
        </div>
    </div>

    @if($show_intro)
        <div class="modal modal-open">
            <div class="modal-box bg-primary max-w-7xl relative" style="height: 95vh;">
                <button wire:click="$refresh" class="badge badge-secondary cursor-pointer absolute top-5 right-5">X</button>
                <div class="flex h-[100%] flex-col gap-4 justify-center items-center">
                    <div class="text-xl text-center text-primary-content font-bold">Instructions</div>
                    <div class="w-full carousel flex-1">
                        <div id="item1" class="w-full carousel-item justify-center">
                            <img src="{{ asset("img/customer-intro/customer-intro-1.jpg") }}" class="h-full">
                        </div>
                        <div id="item2" class="w-full carousel-item justify-center">
                            <img src="{{ asset("img/customer-intro/customer-intro-2.jpg") }}" class="h-full">
                        </div>
                        <div id="item3" class="w-full carousel-item justify-center">
                            <img src="{{ asset("img/customer-intro/customer-intro-3.jpg") }}" class="h-full">
                        </div>
                        <div id="item4" class="w-full carousel-item justify-center">
                            <img src="{{ asset("img/customer-intro/customer-intro-4.jpg") }}" class="h-full">
                        </div>
                    </div>
                    <div class="flex justify-center w-full space-x-2">
                        <a href="#item1" class="btn btn-xs btn-circle">1</a>
                        <a href="#item2" class="btn btn-xs btn-circle">2</a>
                        <a href="#item3" class="btn btn-xs btn-circle">3</a>
                        <a href="#item4" class="btn btn-xs btn-circle">4</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
