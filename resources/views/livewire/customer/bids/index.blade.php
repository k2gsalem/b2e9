<div class="space-y-8">
    @if($this->bid)
        @livewire('customer.bids.profile', ['bid' => $this->bid], key('profile'.now()))
    @else
        <div class="bg-white shadow rounded-lg overflow-auto">
            <table class="table table-compact table-zebra">
                <thead>
                <tr>
                    <th>S.No.</th>
                    <th>Supplier</th>
                    <th>Location</th>
                    <th>Ratings</th>
                    <th>BID Value ({{ config('app.currency_symbol') }})</th>
                    <th class="print:hidden">Profile</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @if(count($this->bids) < 1)
                    <tr>
                        <td colspan="100">
                            <div class=" text-center">
                                {{ __('No records found') }}
                            </div>
                        </td>
                    </tr>
                @endif
                @foreach($this->bids as $item)
                    <tr :key="$item->id" class="group hover rounded-none cursor-pointer">
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $item->user->name }}</td>
                        <td>{{ $item->manufacturing_unit->address.', '.$item->manufacturing_unit->pincode }}</td>
                        <td>
                            <span class="badge badge-primary py-4 gap-2 self-center">
                                {{ $item->user->avg_rating }}
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-secondary" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </span>
                        </td>
                        <td class="tabular-nums">{{ $item->amount }}</td>
                        <td class="print:hidden">
                            <button type="button" wire:click="$set('bid_id', {{ $item->id }})" class="btn btn-sm btn-link">View Profile</button>
                        </td>
                        <td>
                            @if($item->approved_at)
                                <span class="badge badge-primary font-bold">SELECTED</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
