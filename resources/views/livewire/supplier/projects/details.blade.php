<div
    x-data="{
        manufacturingUnitPicker: {
            open: false,
            activeId: null,
            selectedItem: @entangle('my_bid.manufacturing_unit_id'),
            selectItem: function(id) {
                $wire.set('my_bid.manufacturing_unit_id', id)
            },
        },
    }"
    class="pg-container space-y-6 py-6">
    <div id="section-print" class="card compact max-w-5xl mx-auto">
        <div class="card-body">
            <div class="flex flex-col md:flex-row justify-between divide-y md:divide-none divide-primary-content/[.5]">
                <div class="grow space-y-6 pb-6 md:pb-0 md:pr-6">
                    <h2 class="card-title font-bold space-x-4 flex items-center">
                        <span>{{ __('Project Details') }}</span>
                        <span x-data @click="printSection('section-print')" class="print:hidden text-secondary cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>
                        </span>
                    </h2>
                    <div class="grid grid-cols-12 gap-y-4 gap-x-6 text-base">
                        <div class="col-span-3">Status</div>
                        <div class="col-span-9 font-bold before:content-[':_']">{{ $project->supplier_status }}</div>
                        <div class="col-span-3">Project Title</div>
                        <div class="col-span-9 font-bold before:content-[':_']">{{ $project->title }}</div>
                        <div class="col-span-3">Part Name</div>
                        <div class="col-span-9 font-bold before:content-[':_']">{{ $project->part_name }}</div>
                        <div class="col-span-3">Drawing Number</div>
                        <div class="col-span-9 font-bold before:content-[':_']">{{ $project->drawing_number }}</div>
                        <div class="col-span-3">Delivery Location</div>
                        <div class="col-span-9 font-bold before:content-[':_']">{{ $project->manufacturing_unit->pincode }}</div>
                        <div class="col-span-3">Delivery Date</div>
                        <div class="col-span-9 font-bold before:content-[':_']">{{ $project->delivery_date->format('d M, Y') }}</div>
                        <div class="col-span-3">Project Description</div>
                        <div class="col-span-9 font-bold before:content-[':_']">{{ $project->description }}</div>
                        <div class="col-span-3">Attachments</div>
                        <div class="col-span-9 font-bold gap-4 flex flex-wrap before:content-[':_']">
                            @foreach($attachments as $media)
                                <a href="{!! $media->getFullUrl() !!}" target="_blank" class="btn btn-sm btn-secondary w-auto">
                                    {{ $media->file_name }}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                </a>
                            @endforeach
                        </div>
                        @if($project->supplier_status == \App\Models\Project::STATUS_BID)
                            <form method="post" wire:submit.prevent="submitBid" class="col-span-12 self-center grid grid-cols-12 gap-y-4 gap-x-6">
                                @if(!$my_bid->exists)
                                    <div class="col-span-12 self-center print:hidden">
                                        <div class="form-control">
                                            <label class="cursor-pointer label justify-start space-x-2">
                                                <input type="checkbox" name="nda" value="1" class="checkbox" required />
                                                <span class="label-text">
                                            {!! __('I agree to the :nda', [
                                            'nda' => '<a target="_blank" href="'.route('nda').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('NDA').'</a>'
                                    ]) !!}
                                        </span>
                                            </label>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-span-3 self-center print:hidden">Your BID Value</div>
                                <div class="col-span-9 print:hidden">
                                    <div class="flex gap-4">
                                        <x-form.text-input type="text" wire:model.lazy="my_bid.amount" name="my_bid.amount" class="pt-0" />
                                        <button type="submit" class="btn btn-primary">{{ __('Submit BID') }}</button>
                                    </div>
                                </div>
                            </form>
                        @endif
                    </div>
                    @if($my_bid->approved_at)
                        <div class="text-center text-secondary font-bold text-2xl uppercase py-6">
                            Congratulations Your BID Has Been Selected
                        </div>
                    @elseif($project->selected_bid && $my_bid->amount && $my_bid->amount < $project->selected_bid->amount)
                        <div class="text-center text-secondary font-bold text-2xl uppercase py-6">
                            customer feels that your bid is Under quoted!!!
                        </div>
                    @elseif($project->selected_bid && $my_bid->amount && $my_bid->amount > $project->selected_bid->amount)
                        <div class="text-center text-secondary font-bold text-2xl uppercase py-6">
                            customer feels that your bid is Over quoted!!!
                        </div>
                    @endif
                </div>
                <div class="shrink-0 text-base flex flex-col justify-start space-y-8 pt-6 md:pt-0 md:pl-6">
                    @switch($project->supplier_status)
                        @case(\App\Models\Project::STATUS_OPEN)
                            <div class="space-y-4 print:hidden">
                                <div class="font-bold">BID starts in</div>
                                <x-timer class="text-3xl font-bold text-secondary" value="{{ \Illuminate\Support\Carbon::parse($project->close_at)->addMinutes(-30)->format('Y-m-d H:i:s') }}" />
                            </div>
                            <div class="space-y-4 hidden print:block">
                                <div class="font-bold">BID start at</div>
                                <div class="text-xl font-bold text-secondary flex flex-col gap-1">
                                    <span>{{ \Illuminate\Support\Carbon::parse($project->close_at)->addMinutes(-30)->format('d M, Y') }}</span>
                                    <span>{{ \Illuminate\Support\Carbon::parse($project->close_at)->addMinutes(-30)->format('h:i A') }}</span>
                                </div>
                            </div>
                        @break
                        @case(\App\Models\Project::STATUS_BID)
                            <div class="space-y-4">
                                <div class="font-bold">Present Auction Price</div>
                                <span class="text-3xl font-bold text-secondary">
                                    {{ config('app.currency_symbol') }}
                                    {{ $project->current_bid_value ?: '-' }}
                                </span>
                            </div>
                            <div class="space-y-4 print:hidden">
                                <div class="font-bold">BID close in</div>
                                <x-timer class="text-3xl font-bold text-secondary" value="{{ \Illuminate\Support\Carbon::parse($project->close_at)->format('Y-m-d H:i:s') }}" />
                            </div>
                            <div class="space-y-4 hidden print:block">
                                <div class="font-bold">BID close at</div>
                                <div class="text-xl font-bold text-secondary flex flex-col gap-1">
                                    <span>{{ \Illuminate\Support\Carbon::parse($project->close_at)->format('d M, Y') }}</span>
                                    <span>{{ \Illuminate\Support\Carbon::parse($project->close_at)->format('h:i A') }}</span>
                                </div>
                            </div>
                        @break
                    @endswitch
                    @if($my_bid->amount)
                        <div class="space-y-4">
                            <div class="font-bold">My Bid Price</div>
                            <span class="text-3xl font-bold text-secondary">
                                {{ config('app.currency_symbol') }}
                                {{ $my_bid->amount ?: '-' }}
                            </span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
