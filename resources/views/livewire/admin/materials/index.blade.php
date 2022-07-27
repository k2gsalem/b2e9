<div>
    <header class="flex justify-between items-center bg-primary text-primary-content shadow py-4 px-4 sm:px-6 lg:px-8">
        <div class="font-semibold text-xl">
            {{ __('Materials') }}
        </div>
        <div class="space-x-4">
            @can('materials.export') <button type="button" wire:click="export" class="btn btn-secondary btn-sm" >Export</button> @endcan
            @can('materials.import') <button type="button" wire:click="$set('action', 'import')" class="btn btn-secondary btn-sm" >Import</button> @endcan
            @can('materials.create') <button type="button" wire:click="$set('action', 'create')" class="btn btn-secondary btn-sm" >Add New</button> @endcan
        </div>
    </header>

    <main class="p-6 space-y-6">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-12">
            <div class="md:col-span-6">
                <x-form.text-input type="text" wire:model="search" name="search" label="Search" />
            </div>
        </div>
        <div class="bg-white shadow rounded-lg overflow-auto">
            <table class="table table-compact table-zebra">
                <thead>
                <tr>
                    <th>S.No.</th>
                    <th>Title</th>
                    <th>Current Price</th>
                    <th>Old Price</th>
                    <th>Density</th>
                    <th>Updated At</th>
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
                    <tr @can('materials.edit') wire:click="editModel({{ $item->id }})" @endcan wire:key="{{ $item->id }}" class="group hover rounded-none cursor-pointer">
                        <td>{{ $loop->index + $table_items->firstItem() }}</td>
                        <td>{{ $item->title }}</td>
                        <td class="tabular-nums flex">
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
                        </td>
                        <td class="tabular-nums">{{ config('app.currency_symbol').$item->old_price }}</td>
                        <td class="tabular-nums">{{ $item->density }}</td>
                        <td>{{ $item->updated_at->format('d-M-Y h:i A') }}</td>
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
