<div class="card compact shadow">
    <div class="card-body">
        <div class="flex flex-col md:flex-row justify-between divide-y md:divide-none divide-primary-content/[.5]">
            <div class="grow space-y-6 pb-6 md:pb-0 md:pr-6">
                <div class="flex justify-between items-center space-x-6">
                    <h2 class="card-title font-bold">BID Details</h2>
                    <div class="text-2xl flex space-x-4">
                        <div>
                            BID Amount : {{ config('app.currency_symbol') }}
                            <span class="tabular-nums font-bold">{{ $bid->amount }}/-</span>
                        </div>
                        <span class="badge badge-primary py-4 gap-2 self-center">
                            {{ $bid->user->avg_rating }}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-secondary" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        </span>
                    </div>
                </div>
                <div class="grid grid-cols-12 gap-y-4 gap-x-6 text-base">
                    <div class="col-span-3">Name of Organization</div>
                    <div class="col-span-9 font-bold before:content-[':_']">{{ $bid->user->name }}</div>
                    <div class="col-span-3">Manufacturing Unit Address</div>
                    <div class="col-span-9 font-bold before:content-[':_']">{{ $bid->manufacturing_unit->address.', '.$bid->manufacturing_unit->pincode }}</div>
                    <div class="col-span-3">GST Number</div>
                    <div class="col-span-9 font-bold before:content-[':_']">{{ $bid->user->gst_number }}</div>
                    <div class="col-span-3">Type of Organization</div>
                    <div class="col-span-9 font-bold before:content-[':_']">{{ $bid->user->organization_type }}</div>
                    <div class="col-span-3">Date of Incorporation</div>
                    <div class="col-span-9 font-bold before:content-[':_']">{{ $bid->user->incorporation_date->format('d M, Y') }}</div>
                    <div class="col-span-3">Name of Authorized Person</div>
                    <div class="col-span-9 font-bold before:content-[':_']">{{ $bid->user->contact_name }}</div>
                    <div class="col-span-3">Email ID</div>
                    <div class="col-span-9 font-bold before:content-[':_']">{{ $bid->user->email }}</div>
                    <div class="col-span-3">Phone Number</div>
                    <div class="col-span-9 font-bold before:content-[':_']">{{ $bid->user->phone.', '.$bid->user->alternate_phone }}</div>
                    <div class="col-span-3">Machines Available</div>
                    <div class="col-span-9 font-bold before:content-[':_']">{{ implode(", ", $bid->user->machines()->pluck('title')->toArray()) }}</div>
                    <div class="col-span-3">Process Supported</div>
                    <div class="col-span-9 font-bold before:content-[':_']">{{ implode(", ", $bid->user->processes()->pluck('title')->toArray()) }}</div>
                    @if($bid->review)
                        <div class="col-span-3">Your Rating</div>
                        <div class="col-span-9 font-bold before:content-[':_']">
                            <span class="badge badge-primary py-4 gap-2 self-center">
                                {{ $bid->review->rating }}
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-secondary" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </span>
                        </div>
                        <div class="col-span-3">Your Feedback</div>
                        <div class="col-span-9 before:content-[':_']">{{ $bid->review->feedback }}</div>
                    @elseif(auth()->user()->id == $bid->project->user->id && $bid->approved_at)
                        <div class="col-span-3 print:hidden">Your Rating</div>
                        <div class="col-span-9 print:hidden text-secondary">
                            <div x-data="{max: 5, selected: @entangle('rating'), active: null}" class="flex space-x-2" @mouseleave="active = null">
                                <template x-for="i in max">
                                <span @click="selected = i" @mouseover="active = i">
                                    <svg x-show="(selected && selected >= i) || (active && active >= i)" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg x-show="(!selected || selected < i) && (!active || active < i)" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                    </svg>
                                </span>
                                </template>
                            </div>
                            @error('rating')<span class="text-error text-sm pl-2">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-span-3 print:hidden">Your Feedback</div>
                        <div class="col-span-9 print:hidden">
                            <x-form.text-area wire:model.defer="feedback" name="feedback" label="Your Feedback" />
                        </div>
                    @endif
                </div>
                @if(auth()->user()->id == $bid->project->user->id)
                    <div class="flex justify-around space-6 pt-6 print:hidden">
                        <button type="button" wire:click="$emit('closeDetails')" class="btn btn-primary btn-wide">Close</button>
                        @if(is_null($bid->project->selected_bid) && is_null($bid->approved_at))
                            <button type="button" wire:click="$emit('approve')" class="btn btn-primary btn-wide">Approve Supplier</button>
                        @endif
                        @if($bid->approved_at && is_null($bid->review))
                            <button type="button" wire:click="submitReview" class="btn btn-primary btn-wide">Submit</button>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
