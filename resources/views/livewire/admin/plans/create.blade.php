<div>
    <header class="flex justify-between items-center bg-primary text-primary-content shadow py-4 px-4 sm:px-6 lg:px-8">
        <div class="font-semibold text-xl">
            {{ __('New Plan') }}
        </div>
        <button type="button" wire:click="$set('action', 'index')" class="btn btn-secondary btn-sm" >Cancel</button>
    </header>

    <main class="p-6 space-y-6">
        <div class="card compact">
            <div class="card-body space-y-6">
                @if(session()->has('info'))
                    <div class="alert alert-info">
                        <div class="flex-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="w-6 h-6 mx-2 stroke-current">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <label>{{ session()->get('info') }}</label>
                        </div>
                    </div>
                @endif
                <form wire:submit.prevent="create" class="grid grid-cols-1 md:grid-cols-12 gap-4">
                    <x-form.text-input type="text" required class="md:col-span-6"
                                       wire:model.defer="model.code" name="model.code"
                                       label="Plan Code"  />
                    <div class="md:col-span-6">
                        <div x-data="{ open: false, activeId: null, selected: @entangle('model.type') }" class="pt-5">
                            <div @click="open = !open"
                                 @click.away="open = false"
                                 class="relative">
                                <button type="button" class="relative h-12 w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" >
                                    <span class="flex items-center gap-2 overflow-auto h-full">
                                        <span class="ml-3 block truncate" x-text="selected ? selected : 'Select Option'"></span>
                                    </span>
                                    <span class="ml-3 absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                        <x-ic.selector class="h-5 w-5 text-gray-400" />
                                    </span>
                                </button>
                                <label class="absolute left-2 -top-3.5 text-gray-600 text-base transition-all bg-white px-2 peer-placeholder-shown:text-lg peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-2 peer-placeholder-shown:px-0 peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-base peer-focus:px-2">
                                    Plan Type <span class="text-error">*</span>
                                </label>
                                @error('model.type')<span class="text-error text-sm pl-2">{{ $message }}</span>@enderror
                                <div
                                    x-show="open"
                                    x-transition:leave="transition ease-in duration-100"
                                    x-transition:leave-start="opacity-100"
                                    x-transition:leave-end="opacity-0"
                                    class="mt-2 absolute z-10 mt-1 w-full bg-white shadow-lg rounded-md " >
                                    <ul class="py-1 text-base ring-1 ring-black ring-opacity-5 max-h-56 overflow-auto focus:outline-none sm:text-sm" >
                                        @foreach([\App\Models\Plan::TYPE_PREMIUM, \App\Models\Plan::TYPE_STANDARD] as $item)
                                            <li class="text-gray-900 cursor-default select-none relative py-2 pl-3 pr-9"
                                                :class="{ 'bg-primary text-primary-content' : activeId == '{{ $item }}' }"
                                                @click="selected = '{{ $item }}'"
                                                @mouseenter="activeId = '{{ $item }}'"
                                                @mouseleave="activeId = null"
                                            >
                                                <div class="flex items-center">
                                                    <span class="font-normal ml-3 block truncate" >{{ $item }}</span>
                                                </div>
                                                <span x-show="selected == '{{ $item }}'" class="text-indigo-900 absolute inset-y-0 right-0 flex items-center pr-4" >
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                    </svg>
                                                </span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <x-form.text-input type="text" required class="md:col-span-12"
                                       wire:model.defer="model.title" name="model.title"
                                       label="Title"  />
                    <x-form.text-input type="number" required class="md:col-span-6"
                                       wire:model.defer="model.actual_amount" name="model.actual_amount"
                                       label="Actual Amount"  />
                    <x-form.text-input type="number" required class="md:col-span-6"
                                       wire:model.defer="model.sale_amount" name="model.sale_amount"
                                       label="Sale Amount"  />
                    <x-form.text-input type="number" required class="md:col-span-6"
                                       wire:model.defer="model.fresh_bids" name="model.fresh_bids"
                                       label="Fresh Bids"  />
                    <x-form.text-input type="number" required class="md:col-span-6"
                                       wire:model.defer="model.additional_bids" name="model.additional_bids"
                                       label="Additional Bids"  />
                    <x-form.text-input type="number" required class="md:col-span-6"
                                       wire:model.defer="model.validity_days" name="model.validity_days"
                                       label="Validity days"  />
                    <x-form.text-input type="number" required class="md:col-span-3"
                                       wire:model.defer="model.order_pos" name="model.order_pos"
                                       label="Order No."  />
                    <div class="pt-5 md:col-span-3" wire:ignore
                         x-data="{
                            open: false,
                            selectedOption: @entangle('model.active'),
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
                            @error('status')<span class="text-error text-sm pl-2">{{ $message }}</span>@enderror
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
                    <x-form.text-area class="md:col-span-12" required
                                    wire:model.defer="model.description" name="model.description"
                                       label="Description" />
                    <div class="md:col-span-12 text-center py-4">
                        <button type="submit" class="btn btn-primary btn-wide">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>
