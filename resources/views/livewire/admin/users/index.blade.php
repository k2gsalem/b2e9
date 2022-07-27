<div>
    <header class="flex justify-between items-center bg-primary text-primary-content shadow py-4 px-4 sm:px-6 lg:px-8">
        <div class="font-semibold text-xl">
            {{ __('Users') }}
        </div>
        <div class="space-x-4">
            <button type="button" wire:click="export" class="btn btn-secondary btn-sm">Export</button>
        </div>
    </header>

    <main class="p-6 space-y-6">
        <div class="space-y-2">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-12">
                <div class="pt-5 md:col-span-4" wire:ignore
                     x-data="{
                    open: false,
                    options: ['Customer', 'Supplier', 'Both'],
                    selectedOption: @entangle('filter.role'),
                    activeOption: null,
                    selectOption: function(option) {
                        this.selectedOption = this.selectedOption == option ? null : option;
                    }
                }"
                >
                    <div @click="open = !open"
                         @click.away="open = false"
                         class="relative">
                        <button type="button" class="relative h-12 w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-secondary focus:border-secondary sm:text-sm" >
                    <span class="flex items-center gap-2 overflow-auto h-full">
                        <span x-text="selectedOption ?? 'Select option'" class="ml-3 block truncate"></span>
                    </span>
                            <span class="ml-3 absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none"><x-ic.selector class="h-5 w-5 text-gray-400" /></span>
                        </button>
                        <label class="absolute left-3 -top-3.5 text-gray-600 text-base transition-all bg-white px-2 rounded-lg
                        peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3 peer-placeholder-shown:px-0
                        peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-base peer-focus:px-2">
                            Account Type <span class="text-error">*</span>
                        </label>
                        <div
                            x-show="open" x-cloak
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0"
                            class="mt-2 absolute z-40 mt-1 w-full bg-white shadow-lg rounded-md " >
                            <ul class="py-1 text-base ring-1 ring-black ring-opacity-5 max-h-56 overflow-auto focus:outline-none sm:text-sm" >
                                <template x-for="option in options">
                                    <li class="text-gray-900 cursor-default select-none relative py-2 pl-3 pr-9"
                                        :class="{ 'bg-primary text-primary-content' : activeOption == option || selectedOption == option }"
                                        @click="selectOption(option)"
                                        @mouseenter="activeOption = option"
                                        @mouseleave="activeOption = null"
                                    >
                                        <div class="flex items-center">
                                            <span x-text="option" class="font-normal ml-3 block truncate" ></span>
                                        </div>
                                        <span x-show="option == selectedOption" class="absolute inset-y-0 right-0 flex items-center pr-4" >
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="pt-5 md:col-span-4" wire:ignore
                     x-data="{
                            open: false,
                            selectedOption: @entangle('filter.active'),
                            activeOption: null
                        }"
                >
                    <div @click="open = !open"
                         @click.away="open = false"
                         class="relative">
                        <button type="button" class="relative h-12 w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-secondary focus:border-secondary sm:text-sm" >
                                <span class="flex items-center gap-2 overflow-auto h-full">
                                    <span x-text="selectedOption ? 'Active' : 'Inactive'" class="ml-3 block truncate"></span>
                                </span>
                            <span class="ml-3 absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none"><x-ic.selector class="h-5 w-5 text-gray-400" /></span>
                        </button>
                        <label class="absolute left-2 -top-3.5 text-gray-600 text-base transition-all bg-white px-2 peer-placeholder-shown:text-lg peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-2 peer-placeholder-shown:px-0 peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-base peer-focus:px-2">
                            Status <span class="text-error">*</span>
                        </label>
                        <div
                            x-show="open"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0"
                            class="mt-2 absolute z-10 mt-1 w-full bg-white shadow-lg rounded-md " >
                            <ul class="py-1 text-base ring-1 ring-black ring-opacity-5 max-h-56 overflow-auto focus:outline-none sm:text-sm" >
                                <li class="text-gray-900 cursor-default select-none relative py-2 pl-3 pr-9"
                                    :class="{ 'bg-primary text-primary-content' : selectedOption }"
                                    @click="selectedOption = true"
                                >
                                    <div class="flex items-center">
                                        <span class="font-normal ml-3 block truncate">Active</span>
                                    </div>
                                    <span x-show="selectedOption" class="absolute inset-y-0 right-0 flex items-center pr-4" >
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                </li>
                                <li class="text-gray-900 cursor-default select-none relative py-2 pl-3 pr-9"
                                    :class="{ 'bg-primary text-primary-content' : !selectedOption }"
                                    @click="selectedOption = false"
                                >
                                    <div class="flex items-center">
                                        <span class="font-normal ml-3 block truncate">Inactive</span>
                                    </div>
                                    <span x-show="!selectedOption" class="absolute inset-y-0 right-0 flex items-center pr-4" >
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
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
                    <th>Name</th>
                    <th>Role</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Pincode</th>
                    <th>Status</th>
                    <th>Referral Code</th>
                    <th>Referred By</th>
                    <th>Joined At</th>
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
                    <tr @can('users.edit') wire:click="editModel({{ $item->id }})" @endcan wire:key="{{ $item->id }}" class="group hover rounded-none cursor-pointer">
                        <td>{{ $loop->index + $table_items->firstItem() }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->role }}</td>
                        <td>{{ $item->phone }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ optional($item->manufacturing_unit)->pincode }}</td>
                        <td>{{ $item->active ? 'Active' : 'Inactive' }}</td>
                        <td>{{ $item->referral_code }}</td>
                        <td>
                            @if($item->referrer)
                                {{ $item->referrer->referral_code }}
                            @endif
                        </td>
                        <td>{{ $item->created_at->format('d-M-Y h:i A') }}</td>
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
