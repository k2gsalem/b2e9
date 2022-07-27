<div id="section-print" class="pg-container max-w-5xl space-y-6 py-6">
    <div class="card compact shadow">
        <div class="card-body">
            <div class="flex flex-col md:flex-row justify-between divide-y md:divide-none divide-primary-content/[.5]">
                <div class="grow space-y-4 pb-6 md:pb-0 md:pr-6">
                    <h2 class="card-title font-bold space-x-4 flex items-center">
                        <span>{{ __('Project Details') }}</span>
                        <span x-data @click="printSection('section-print')" class="print:hidden text-secondary cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>
                        </span>
                        @if($project->txn_id && $project->status != \App\Models\Project::STATUS_CHECKOUT)
                            <a href="{{ route('customer.projects.invoice', $project) }}" class="text-primary text-sm link">Invoice</a>
                        @endif
                    </h2>
                    <div class="grid lg:grid-cols-12 gap-x-6 text-base">
                        <div class="lg:col-span-3">Status</div>
                        <div class="lg:col-span-9 font-bold pb-4 lg:before:content-[':_']">{{ $project->status }}</div>
                        <div class="lg:col-span-3">Transaction ID</div>
                        <div class="lg:col-span-9 font-bold pb-4 lg:before:content-[':_']">{{ $project->txn_id }}</div>
                        <div class="lg:col-span-3">Project Title</div>
                        <div class="lg:col-span-9 font-bold pb-4 lg:before:content-[':_']">{{ $project->title }}</div>
                        <div class="lg:col-span-3">Part Name</div>
                        <div class="lg:col-span-9 font-bold pb-4 lg:before:content-[':_']">{{ $project->part_name }}</div>
                        <div class="lg:col-span-3">Raw Material Price</div>
                        <div class="lg:col-span-9 font-bold pb-4 lg:before:content-[':_']">{{ config('app.currency_symbol').$project->raw_material_price }}</div>
                        <div class="lg:col-span-3">Location Preference</div>
                        <div class="lg:col-span-9 font-bold pb-4 lg:before:content-[':_']">{{ $project->location_preference }}KM</div>
                        <div class="lg:col-span-3">Delivery Location</div>
                        <div class="lg:col-span-9 font-bold pb-4 lg:before:content-[':_']">{{ $project->manufacturing_unit->address.', '.$project->manufacturing_unit->pincode }}</div>
                        <div class="lg:col-span-3">Delivery Date</div>
                        <div class="lg:col-span-9 font-bold pb-4 lg:before:content-[':_']">{{ $project->delivery_date->format('d M, Y') }}</div>
                        <div class="lg:col-span-3">Operations</div>
                        <div class="lg:col-span-9 font-bold pb-4 lg:before:content-[':_']">{{ implode(', ', $project->processes()->pluck('title')->toArray()) }}</div>
                        <div class="lg:col-span-3">Project Description</div>
                        <div class="lg:col-span-9 font-bold pb-4 lg:before:content-[':_']">{{ $project->description }}</div>
                        <div class="lg:col-span-3">Attachments</div>
                        <div class="lg:col-span-9 font-bold gap-4 flex flex-wrap pb-4 lg:before:content-[':_']">
                            @foreach($attachments as $media)
                                <a href="{!! $media->getFullUrl() !!}" target="_blank" class="btn btn-sm btn-secondary w-auto">
                                    {{ $media->file_name }}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="shrink-0 text-base flex flex-col justify-between space-y-8 pt-6 md:pt-0 md:pl-6">
                    @switch($project->status)
                        @case(\App\Models\Project::STATUS_SCHEDULED)
                            <div class="space-y-4 print:hidden">
                                <div class="font-bold">Project Publish in</div>
                                <x-timer class="text-3xl font-bold text-secondary" value="{{ $project->publish_at }}" />
                            </div>
                            <div class="space-y-4 print:hidden">
                                <div class="font-bold">RFQ available in</div>
                                <x-timer class="text-3xl font-bold text-secondary" value="{{ $project->close_at }}" />
                            </div>
                            <div class="space-y-4 hidden print:block">
                                <div class="font-bold">Project Publish at</div>
                                <div class="text-xl font-bold text-secondary flex flex-col gap-1">
                                    <span>{{ \Illuminate\Support\Carbon::parse($project->publish_at)->format('d M, Y') }}</span>
                                    <span>{{ \Illuminate\Support\Carbon::parse($project->publish_at)->format('h:i A') }}</span>
                                </div>
                            </div>
                            <div class="space-y-4 hidden print:block">
                                <div class="font-bold">RFQ available at</div>
                                <div class="text-xl font-bold text-secondary flex flex-col gap-1">
                                    <span>{{ \Illuminate\Support\Carbon::parse($project->close_at)->format('d M, Y') }}</span>
                                    <span>{{ \Illuminate\Support\Carbon::parse($project->close_at)->format('h:i A') }}</span>
                                </div>
                            </div>
                        @break
                        @case(\App\Models\Project::STATUS_ONGOING)
                            <div class="space-y-4">
                                <div class="font-bold">Project Published at</div>
                                <div class="text-xl font-bold text-secondary flex flex-col gap-1">
                                    <span>{{ \Illuminate\Support\Carbon::parse($project->publish_at)->format('d M, Y') }}</span>
                                    <span>{{ \Illuminate\Support\Carbon::parse($project->publish_at)->format('h:i A') }}</span>
                                </div>
                            </div>
                            <div class="space-y-4 print:hidden">
                                <div class="font-bold">RFQ available in</div>
                                <x-timer class="text-3xl font-bold text-secondary text-center" value="{{ $project->close_at }}" />
                            </div>
                            <div class="space-y-4 hidden print:block">
                                <div class="font-bold">RFQ available at</div>
                                <div class="text-xl font-bold text-secondary flex flex-col gap-1">
                                    <span>{{ \Illuminate\Support\Carbon::parse($project->close_at)->format('d M, Y') }}</span>
                                    <span>{{ \Illuminate\Support\Carbon::parse($project->close_at)->format('h:i A') }}</span>
                                </div>
                            </div>
                        @break
                    @endswitch
                </div>
            </div>
        </div>
    </div>
    @if($project->status == \App\Models\Project::STATUS_CHECKOUT)
        <div class="card compact print:hidden">
            <div class="card-body">
                <form
                    x-data="{
                        instantPublish: @entangle('instantPublish'),
                        pub_date: @entangle('publish_date'),
                        pub_time: @entangle('publish_time'),
                        instantChanged: function() {
                            return;
                            if(this.instantPublish) {
                                this.pub_date = '{{ date('Y-m-d') }}';
                                this.pub_time = '{{ date('H:i:s') }}';
                            }
                            else {
                                this.pub_date = null;
                                this.pub_time = null;
                            }
                        }
                    }"
                    method="post"
                    wire:submit.prevent="checkout"
                    class="grid grid-cols-1 md:grid-cols-12 gap-6">

                    <div x-show="!instantPublish" class="md:col-span-12">
                        <div class="flex gap-2 items-center">
                            <input type="checkbox" name="instantPublish" value="1" x-model="instantPublish" @change="instantChanged" />
                            <span class="label-text">Instant Publish</span>
                        </div>
                    </div>
                    <div class="col-span-1 md:col-span-6" x-show="!instantPublish">
                        <x-form.text-input x-model="pub_date" type="date" wire:model.lazy="publish_date" name="publish_date" label="Publish Date" required />
                    </div>
                    <div class="md:col-span-6" x-show="!instantPublish">
                        <x-form.text-input x-model="pub_time" type="time" step="1" wire:model.lazy="publish_time" name="publish_time" label="Publish Time" required />
                    </div>
                    <div class="md:col-span-6">
                        <x-form.text-input type="date" wire:model.lazy="closing_date" name="closing_date" label="Closing Date" required />
                    </div>
                    <div class="md:col-span-6">
                        <x-form.text-input type="time" step="1" wire:model.lazy="closing_time" name="closing_time" label="Closing Time" required />
                    </div>
                    <div class="md:col-span-12 pt-6 space-y-6">
                        <div class="max-w-4xl mx-auto flex flex-wrap justify-center gap-6">
                            @foreach($packages as $item)
                                <button type="button" wire:click="selectPackage({{ $item->id }})" class="btn btn-primary px-6 {{ $package && $package->id == $item->id ? '' : 'btn-outline' }}">
                                    Top {{ $item->bids }} Bids
                                </button>
                            @endforeach
                        </div>
                        @if($package)
                            <table class="table table-zebra max-w-md mx-auto text-base">
                                <thead>
                                <tr>
                                    <th>
                                        <span class="font-bold text-2xl">Payment Details</span>
                                    </th>
                                    <th class="text-right">
                                        <span class="font-bold text-2xl">Amount</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>B2E Cost</td>
                                    <th class="text-right">{{ config('app.currency_symbol').number_format($package->sale_amount, 2) }}</th>
                                </tr>
                                <tr>
                                    <td>GST @ 18%</td>
                                    <th class="text-right">{{ config('app.currency_symbol').number_format($package->gst_amount, 2) }}</th>
                                </tr>
                                </tbody>
                            </table>
                            <div class="text-center text-2xl">
                                Final Amount : <span class="font-bold">{{ config('app.currency_symbol').number_format($package->final_amount, 2) }}</span>
                            </div>
                        @endif
                    </div>
                    @if($package)
                        <div class="md:col-span-12 py-6 text-center">
                            <button type="submit" class="btn btn-primary" {{ $package ? '' : 'disabled' }}>{{ __('Proceed to Pay') }}</button>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    @endif
    @if(in_array($project->status, [\App\Models\Project::STATUS_CLOSED]))
        @livewire('customer.bids.index', ['project' => $project])
    @endif
</div>
