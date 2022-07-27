<div>
    <header class="flex justify-between items-center bg-primary text-primary-content shadow py-4 px-4 sm:px-6 lg:px-8">
        <div class="font-semibold text-xl">
            {{ __('Locations') }}
        </div>
        <div class="space-x-4">
            @can('locations.create') <button type="button" wire:click="$set('action', 'create')" class="btn btn-secondary btn-sm" >Add New</button> @endcan
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
                    <th>Pincode</th>
                    <th>Latitude</th>
                    <th>Longitude</th>
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
                    <tr @can('locations.edit') wire:click="editModel({{ $item->id }})" @endcan wire:key="{{ $item->id }}" class="group hover rounded-none cursor-pointer">
                        <td>{{ $loop->index + $table_items->firstItem() }}</td>
                        <td class="tabular-nums">{{ $item->pincode }}</td>
                        <td class="tabular-nums">{{ $item->latitude }}</td>
                        <td class="tabular-nums">{{ $item->longitude }}</td>
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
