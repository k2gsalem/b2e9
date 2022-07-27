<div>
    <header class="flex justify-between items-center bg-primary text-primary-content shadow py-4 px-4 sm:px-6 lg:px-8">
        <div class="font-semibold text-xl">
            {{ __('Project Transactions') }}
        </div>
        <div class="space-x-4">
            <button type="button" wire:click="export" class="btn btn-secondary btn-sm">Export</button>
        </div>
    </header>

    <main class="p-6 space-y-6">
        <div class="space-y-2">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-12">
                <div class="pt-5 md:col-span-4" wire:ignore
                     @click="open = true"
                     @click.away="open = false"
                     x-data="{
                        open: false,
                        active: null,
                        query: '',
                        options: @entangle('filter.customer.options'),
                        selected: {
                            option: @entangle('filter.customer.option'),
                            value: @entangle('filter.customer.value')
                        },
                        select: function(value) {
                            this.selected.value = this.selected.value == value ? null : value;
                        },
                        get filtered() {
                            var parent = this;
                            return this.options.filter(function(el) {
                                return el.name.toLowerCase().includes(parent.query);
                            })
                        }
                    }"
                >
                    <div
                         class="relative">
                        <button type="button" class="relative h-12 w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-secondary focus:border-secondary sm:text-sm" >
                            <span class="flex items-center gap-2 overflow-auto h-full">
                                <span x-text="selected.option ? selected.option.name : 'Select option'" class="ml-3 block truncate"></span>
                            </span>
                            <span class="ml-3 absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none"><x-ic.selector class="h-5 w-5 text-gray-400" /></span>
                        </button>
                        <label class="absolute left-3 -top-3.5 text-gray-600 text-base transition-all bg-white px-2 rounded-lg
                        peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3 peer-placeholder-shown:px-0
                        peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-base peer-focus:px-2">
                            Customer
                        </label>
                        <div
                            x-cloak
                            x-show="open"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0"
                            class="mt-2 absolute z-10 mt-1 w-full bg-white shadow-lg rounded-md " >
                            <input type="search" x-model="query" placeholder="Search"
                                   class="input input-sm input-bordered ring-0 rounded-none" />
                            <ul class="py-1 text-base ring-1 ring-black ring-opacity-5 max-h-56 overflow-auto focus:outline-none sm:text-sm" >
                                <li x-show="options.length <= 0" class="text-gray-900 cursor-default select-none relative py-2 pl-3 pr-9" >
                                    <div class="flex items-center">
                                        <span class="font-normal ml-3 block truncate" >No records found</span>
                                    </div>
                                </li>
                                <template x-for="option in filtered" :key="option.id" >
                                    <li class="text-gray-900 cursor-default select-none relative py-2 pl-3 pr-9"
                                        :class="{ 'bg-primary text-primary-content' : active == option.id || selected.value == option.id }"
                                        @click="select(option.id)"
                                        @mouseenter="active = option.id"
                                        @mouseleave="active = null"
                                    >
                                        <div class="flex items-center flex gap-2" :class="{'font-bold': selected.value == option.id }">
                                            <span x-text="option.name" class="block truncate" ></span>
                                            <span x-text="option.phone" class="block truncate text-xs" ></span>
                                        </div>
                                        <span x-show="selected.value == option.id" class="absolute inset-y-0 right-0 flex items-center pr-4" >
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
            </div>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-12">
                <x-form.text-input type="search" class="md:col-span-5"
                                   wire:model="search"
                                   name="search"
                                   label="Search projects" />
                <x-form.text-input type="datetime-local" class="md:col-span-3"
                                   wire:model="start_date"
                                   name="start_date"
                                   label="Start Date" />
                <x-form.text-input type="datetime-local" class="md:col-span-3"
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
                    <th>Customer</th>
                    <th>Project</th>
                    <th>Bids</th>
                    <th>Amount</th>
                    <th>Mode</th>
                    <th>Paid At</th>
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
                    <tr wire:key="{{ $record->id }}" class="group hover rounded-none cursor-pointer">
                        <td>{{ $loop->index + $this->records->firstItem() }}</td>
                        <td>
                            <div class="flex items-center space-x-3">
                                <div>
                                    <div class="font-bold">
                                        {{ $record->project->user->name }}
                                    </div>
                                    <div class="text-sm opacity-50">
                                        {{ $record->project->user->phone }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="flex items-center space-x-3">
                                <div>
                                    <div class="font-bold">
                                        {{ $record->project->title }}
                                    </div>
                                    <div class="text-sm opacity-50">
                                        {{ $record->uuid }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="tabular-nums">{{ $record->bids }}</td>
                        <td class="tabular-nums">{{ config('app.currency_symbol').$record->final_amount }}</td>
                        <td>{{ $record->mode }}</td>
                        <td>{{ $record->paid_at ? $record->paid_at->format('d-M-Y h:i A') : '' }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="md:flex gap-6">
            <div class="grow self-end">
                {{ $this->records->links() }}
            </div>
        </div>
    </main>
</div>
