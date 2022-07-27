<x-jet-form-section submit="save">
    <x-slot name="title">
        {{ __('Machines & Processes Supported') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update your available Machines & other supported Processes') }}
    </x-slot>

    <x-slot name="form">
        <div class="pt-5 col-span-6" wire:ignore
             x-data="{
                open: false,
                active: null,
                query: '',
                options: @entangle('filter.machines.options'),
                selected: {
                    options: @entangle('filter.machines.selected.options'),
                    values: @entangle('filter.machines.selected.values')
                },
                select: function(value) {
                    var index = this.selected.values.indexOf(value);
                    if(index > -1) {
                        this.selected.values.splice(index, 1);
                    }
                    else
                        this.selected.values.push(value);
                },
                get filtered() {
                    var parent = this;
                    return this.options.filter(function(el) {
                        return el.title.toLowerCase().includes(parent.query);
                    })
                }
             }"
        >
            <div @click="open = true"
                 @click.away="open = false"
                 class="relative">
                <button type="button" class="relative h-12 w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-secondary focus:border-secondary sm:text-sm" >
                    <span class="flex items-center gap-2 overflow-auto h-full">
                        <span x-show="selected.values.length <= 0" class="ml-3 block truncate">Select options</span>
                        <template x-for="option in selected.options" :key="option.id" >
                            <span x-text="option.title"
                                  @click="select(option.id)"
                                  class="badge badge-sm gap-2 cursor-pointer whitespace-nowrap"></span>
                        </template>
                    </span>
                    <span class="ml-3 absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none"><x-ic.selector class="h-5 w-5 text-gray-400" /></span>
                </button>
                <label class="absolute left-2 -top-3.5 text-gray-600 text-base transition-all bg-white px-2 peer-placeholder-shown:text-lg peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-2 peer-placeholder-shown:px-0 peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-base peer-focus:px-2">
                    Machines available <span class="text-error">*</span>
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
                                :class="{ 'bg-primary text-primary-content' : active == option.id || selected.values.indexOf(option.id) > -1 }"
                                @click="select(option.id)"
                                @mouseenter="active = option.id"
                                @mouseleave="active = null"
                            >
                                <div class="flex items-center">
                                    <span x-text="option.title" class="font-normal ml-3 block truncate" ></span>
                                </div>
                                <span x-show="selected.values.indexOf(option.id) > -1" class="absolute inset-y-0 right-0 flex items-center pr-4" >
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
        <div class="pt-5 col-span-6" wire:ignore
             x-data="{
                open: false,
                active: null,
                query: '',
                options: @entangle('filter.processes.options'),
                selected: {
                    options: @entangle('filter.processes.selected.options'),
                    values: @entangle('filter.processes.selected.values')
                },
                select: function(value) {
                    var index = this.selected.values.indexOf(value);
                    if(index > -1) {
                        this.selected.values.splice(index, 1);
                    }
                    else
                        this.selected.values.push(value);
                },
                get filtered() {
                    var parent = this;
                    return this.options.filter(function(el) {
                        return el.title.toLowerCase().includes(parent.query);
                    })
                }
             }"
        >
            <div @click="open = true"
                 @click.away="open = false"
                 class="relative">
                <button type="button" class="relative h-12 w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-secondary focus:border-secondary sm:text-sm" >
                    <span class="flex items-center gap-2 overflow-auto h-full">
                        <span x-show="selected.values.length <= 0" class="ml-3 block truncate">Select options</span>
                        <template x-for="option in selected.options" :key="option.id" >
                            <span x-text="option.title"
                                  @click="select(option.id)"
                                  class="badge badge-sm gap-2 cursor-pointer whitespace-nowrap"></span>
                        </template>
                    </span>
                    <span class="ml-3 absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none"><x-ic.selector class="h-5 w-5 text-gray-400" /></span>
                </button>
                <label class="absolute left-2 -top-3.5 text-gray-600 text-base transition-all bg-white px-2 peer-placeholder-shown:text-lg peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-2 peer-placeholder-shown:px-0 peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-base peer-focus:px-2">
                    Processes supported
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
                                :class="{ 'bg-primary text-primary-content' : active == option.id || selected.values.indexOf(option.id) > -1 }"
                                @click="select(option.id)"
                                @mouseenter="active = option.id"
                                @mouseleave="active = null"
                            >
                                <div class="flex items-center">
                                    <span x-text="option.title" class="font-normal ml-3 block truncate" ></span>
                                </div>
                                <span x-show="selected.values.indexOf(option.id) > -1" class="absolute inset-y-0 right-0 flex items-center pr-4" >
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
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <button type="submit" class="btn btn-sm btn-primary">
            {{ __('Save') }}
        </button>
    </x-slot>
</x-jet-form-section>
