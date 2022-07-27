<div>
    <header class="flex justify-between items-center bg-primary text-primary-content shadow py-4 px-4 sm:px-6 lg:px-8">
        <div class="font-semibold text-xl">
            {{ __('Projects') }}
        </div>
        <div class="space-x-4">
            @can('projects.export')
                <button type="button" wire:click="export" class="btn btn-secondary btn-sm">Export</button>
            @endcan
        </div>
    </header>

    <main class="p-6 space-y-6">
        <div class="space-y-2">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-12">
                <x-form.text-input type="search" class="md:col-span-5"
                                   wire:model="search"
                                   name="search"
                                   label="Search" />
                <x-form.text-input type="date" class="md:col-span-3"
                                   wire:model="start_date"
                                   name="start_date"
                                   label="Start Date" />
                <x-form.text-input type="date" class="md:col-span-3"
                                   wire:model="end_date"
                                   name="end_date"
                                   label="End Date" />
                <button type="button" onclick="location.reload()" class="btn btn-secondary self-end">Clear</button>
            </div>
        </div>
        <div class="bg-white shadow rounded-lg overflow-auto">
            <table class="table table-compact table-zebra">
                <thead>
                <tr>
                    <th>S.No.</th>
                    <th>Txn ID</th>
                    <th>Customer</th>
                    <th>Title</th>
                    <th>Material Price</th>
                    <th>Bids</th>
                    <th>Selected BID</th>
                    <th>Selected Supplier</th>
                    <th>Publish At</th>
                    <th>Close At</th>
                </tr>
                </thead>
                <tbody>
                @if(count($table_items) < 1)
                    <tr>
                        <td colspan="100">
                            <div class=" text-center">
                                {{ __('No records found') }}
                            </div>
                        </td>
                    </tr>
                @endif
                @foreach($table_items as $item)
                    <tr wire:key="{{ $item->id }}" @can('projects.details') wire:click="editModel({{ $item->id }})" @endcan class="group hover rounded-none cursor-pointer">
                        <td>{{ $loop->index + $table_items->firstItem() }}</td>
                        <td>
                            <div class="flex items-center space-x-3">
                                <div>
                                    <div class="font-bold">
                                        {{ $item->txn_id }}
                                    </div>
                                    <div class="text-sm opacity-50">
                                        {{ config('app.currency_symbol').optional($item->transaction)->final_amount }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="flex items-center space-x-3">
                                <div>
                                    <div class="font-bold">
                                        {{ $item->user->name }}
                                    </div>
                                    <div class="text-sm opacity-50">
                                        {{ $item->user->phone }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $item->title }}</td>
                        <td class="tabular-nums">{{ config('app.currency_symbol').$item->raw_material_price }}</td>
                        <td class="tabular-nums">
                            @if($item->transaction && !is_null($item->transaction->paid_at))
                                {{ $item->valid_bids_count .' / '. $item->transaction->bids }}
                            @endif
                        </td>
                        <td>{{ $item->selected_bid_value }}</td>
                        <td>
                            @if($item->selected_bid)
                                <div class="flex items-center space-x-3">
                                    <div>
                                        <div class="font-bold">
                                            {{ $item->selected_bid->user->name }}
                                        </div>
                                        <div class="text-sm opacity-50">
                                            {{ $item->selected_bid->user->phone }}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </td>
                        <td>{{ $item->publish_at->format('d-M-Y h:i A') }}</td>
                        <td>{{ $item->close_at->format('d-M-Y h:i A') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="md:flex gap-6">
            <div class="grow self-end">
                {{ $table_items->links() }}
            </div>
        </div>
    </main>
</div>
