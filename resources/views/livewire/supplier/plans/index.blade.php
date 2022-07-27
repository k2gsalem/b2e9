<div class="pg-container py-6 space-y-40">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        @foreach($plans as $item)
            <div data-tip="{{ $item->description }}" class="py-5 tooltip tooltip-bottom">
                <div wire:key="{{ $item->id }}" wire:click="selectPlan({{ $item->id }})" class="h-full rounded-lg shadow bg-secondary text-secondary-content flex flex-col items-center text-base cursor-pointer hover:shadow-xl">
                    <span class="bg-primary text-primary-content font-bold text-xl rounded-lg px-8 py-2 -mt-6 mb-6">{{ $item->code }}</span>
                    <div class="text-3xl font-bold uppercase tracking-widest text-center">{{ $item->title }}</div>
                    <span class="text-xl uppercase tracking-widest">Membership</span>
                    <div class="grow border-t border-b border-gray-100 w-full text-base text-primary-content/[.85] flex flex-col items-center my-4 py-4 space-y-3">
                        @foreach($item->benefits as $benefit)
                            @if($benefit->title)
                                <span>{{ $benefit->title }}</span>
                            @endif
                        @endforeach
                    </div>
                    @if($item->actual_amount > $item->sale_amount)
                        <span class="text-primary text-xl font-bold line-through">₹{{ $item->actual_amount }}</span>
                    @endif
                    <span class="text-3xl font-bold">₹{{ $item->sale_amount }}</span>
                    @if(optional(auth()->user()->subscription)->plan_id == $item->id)
                        <span class="text-primary text-lg font-bold mt-6">Current Plan</span>
                        <span class="btn btn-primary px-6 -mb-5">Select</span>
                    @else
                        <span class="btn btn-primary px-6 -mb-5 mt-6">Select</span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
    <div class="bg-white shadow rounded-lg overflow-auto">
        <table class="table table-compact table-zebra">
            <thead>
            <tr>
                <th>S.No.</th>
                <th>Plan</th>
                <th>Txn</th>
                <th>Bids<br />(Fresh/Edit)</th>
                <th>Starts At</th>
                <th>Ends At</th>
            </tr>
            </thead>
            <tbody>
            @if(count($this->records) < 1)
                <tr>
                    <td colspan="100">
                        <div class=" text-center">
                            {{ __('No records found') }}
                        </div>
                    </td>
                </tr>
            @endif
            @foreach($this->records as $record)
                <tr wire:key="{{ $record->id }}" wire:click="recordClicked({{ $record->id }})" class="group hover rounded-none cursor-pointer">
                    <td>{{ $loop->index + 1 }}</td>
                    <td>
                        <div class="flex items-center space-x-3">
                            <div>
                                <div class="font-bold">
                                    {{ $record->plan->code }}
                                </div>
                                <div class="text-sm opacity-50">
                                    {{ $record->plan->type }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="flex items-center space-x-3">
                            <div>
                                <div class="font-bold">
                                    {{ config('app.currency_symbol').$record->amount }}
                                </div>
                                <div class="text-sm opacity-50">
                                    {{ $record->transaction ? $record->transaction->uuid : '' }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="tabular-nums">{{ $record->fresh_bids }} / {{ $record->additional_bids }}</td>
                    <td>{{ $record->starts_at->format('d-M-Y h:i A') }}</td>
                    <td>{{ $record->ends_at->format('d-M-Y h:i A') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
