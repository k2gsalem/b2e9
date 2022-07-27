<div class="bg-right bg-cover bg-no-repeat lg:bg-center"
     style="background-image: url({{ asset('img/bg-auth-reg.jpg') }})" >
    <div x-data="{
        showPassword: false,
        type: 'customer',
        machinesPicker: {
            open: false,
            activeId: null,
            activeIds: @entangle('machineIds'),
            selectItem: function(id) {
                $wire.selectMachine(id)
            },
        },
        processesPicker: {
            open: false,
            activeId: null,
            activeIds: @entangle('processIds'),
            selectItem: function(id) {
                $wire.selectProcess(id)
            },
        },
        orgTypePicker: {
            open: false,
            activeId: null,
            selectedItem: @entangle('organization_type'),
            selectItem: function(id) {
                $wire.set('organization_type', id)
            },
        }
    }"
         class="min-h-screen w-full mx-auto max-w-6xl p-6 flex items-center justify-between">
        <div class="card compact w-full">
            <form method="post" action="{{ route('register') }}" class="card-body space-y-6">
                <h2 class="text-center text-2xl font-bold uppercase">Create Account</h2>

                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="flex justify-center gap-4">
                    <div class="form-control">
                        <label class="cursor-pointer label justify-start space-x-2">
                            <input type="radio" name="role" wire:model="role" value="customer" class="radio" required />
                            <span class="label-text">Customer</span>
                        </label>
                    </div>
                    <div class="form-control">
                        <label class="cursor-pointer label justify-start space-x-2">
                            <input type="radio" name="role" wire:model="role" value="supplier" class="radio" required />
                            <span class="label-text">Supplier</span>
                        </label>
                    </div>
                    <div class="form-control">
                        <label class="cursor-pointer label justify-start space-x-2">
                            <input type="radio" name="role" wire:model="role" value="both" class="radio" required />
                            <span class="label-text">Both</span>
                        </label>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-y-4 gap-x-6">
                    <x-form.text-input type="text" wire:model.lazy="name" name="name" label="Organization Name" required />
                    <x-form.text-input type="text" wire:model.lazy="contact_name" name="contact_name" label="Authorised Person Name" required />
                    <div class="pt-5">
                        <input type="hidden" name="organization_type" wire:model="organization_type" required />
                        <div @click="orgTypePicker.open = !orgTypePicker.open"
                             @click.away="orgTypePicker.open = false"
                             class="relative">
                            <button type="button" class="relative h-12 w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" >
                                <span class="flex items-center gap-2 overflow-auto h-full">
                                    <span class="ml-3 block truncate">{{ $organization_type ?: 'Select options' }}</span>
                                </span>
                                <span class="ml-3 absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                <x-ic.selector class="h-5 w-5 text-gray-400" />
                            </span>
                            </button>
                            <label class="absolute left-2 -top-3.5 text-gray-600 text-base transition-all bg-white px-2 peer-placeholder-shown:text-lg peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-2 peer-placeholder-shown:px-0 peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-base peer-focus:px-2">
                                Organization Type <span class="text-error">*</span>
                            </label>
                            @error('organization_type')<span class="text-error text-sm pl-2">{{ $message }}</span>@enderror
                            <div
                                x-show="orgTypePicker.open"
                                x-transition:leave="transition ease-in duration-100"
                                x-transition:leave-start="opacity-100"
                                x-transition:leave-end="opacity-0"
                                class="mt-2 absolute z-10 mt-1 w-full bg-white shadow-lg rounded-md " >
                                <ul class="py-1 text-base ring-1 ring-black ring-opacity-5 max-h-56 overflow-auto focus:outline-none sm:text-sm" >
                                    @foreach(['LLB', 'PVT LTD', 'Partnership', 'Proprietorship'] as $item)
                                        <li class="text-gray-900 cursor-default select-none relative py-2 pl-3 pr-9"
                                            :class="{ 'bg-primary text-primary-content' : orgTypePicker.activeId == '{{ $item }}' }"
                                            @click="orgTypePicker.selectItem('{{ $item }}')"
                                            @mouseenter="orgTypePicker.activeId = '{{ $item }}'"
                                            @mouseleave="orgTypePicker.activeId = null"
                                        >
                                            <div class="flex items-center">
                                                <span class="font-normal ml-3 block truncate" >{{ $item }}</span>
                                            </div>
                                            @if($item ==  $organization_type)
                                                <span class="text-indigo-900 absolute inset-y-0 right-0 flex items-center pr-4" >
                                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                </svg>
                                            </span>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <x-form.text-input type="email" wire:model.lazy="email" name="email" label="Email address" required />
                    <x-form.text-input type="number" wire:model.lazy="phone" name="phone" label="Phone Number" required />
                    <x-form.text-input type="text" wire:model.lazy="alternate_phone" name="alternate_phone" label="Alternate Phone Number" />
                    <x-form.text-input type="date" wire:model.lazy="incorporation_date" name="incorporation_date" label="Date of Incorporation" required />
                    <x-form.text-input type="number" step="0.01" wire:model.lazy="sales_turnover" name="sales_turnover" label="Annual Sales Turnover (in Lacs)" required />
                    <x-form.text-input type="text" wire:model.lazy="gst_number" name="gst_number" label="GST Number" required style="text-transform: uppercase;" />
                    @if(in_array($role, ['supplier', 'both']))
                        <x-form.text-input type="text" wire:model.lazy="employees_count" name="employees_count" label="No. of Employees" required />
                        <div class="pt-5">
                            <input type="hidden" name="machine_ids" value="{{ json_encode($machineIds) }}" />
                            <div @click="machinesPicker.open = true"
                                 @click.away="machinesPicker.open = false"
                                 class="relative">
                                <button type="button" class="relative h-12 w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" >
                                <span class="flex items-center gap-2 overflow-auto h-full">
                                    @if(empty($machineIds))
                                        <span class="ml-3 block truncate">Select options</span>
                                    @endif
                                    @foreach(\App\Models\Process::query()->select('id', 'title')->whereIn('id', $machineIds)->get() as $item)
                                        <span @click="machinesPicker.selectItem({{ $item->id }})" class="badge badge-sm gap-2 cursor-pointer whitespace-nowrap">
                                            {{ $item->title }}
                                        </span>
                                    @endforeach
                                </span>
                                    <span class="ml-3 absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                    <x-ic.selector class="h-5 w-5 text-gray-400" />
                                </span>
                                </button>
                                <label class="absolute left-2 -top-3.5 text-gray-600 text-base transition-all bg-white px-2 peer-placeholder-shown:text-lg peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-2 peer-placeholder-shown:px-0 peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-base peer-focus:px-2">
                                    Machines available <span class="text-error">*</span>
                                </label>
                                @error('machineIds')<span class="text-error text-sm pl-2">{{ $message }}</span>@enderror
                                <div
                                    x-show="machinesPicker.open"
                                    x-transition:leave="transition ease-in duration-100"
                                    x-transition:leave-start="opacity-100"
                                    x-transition:leave-end="opacity-0"
                                    class="mt-2 absolute z-10 mt-1 w-full bg-white shadow-lg rounded-md " >
                                    <input type="search" wire:model="machinesFilterText" placeholder="Search"
                                           class="input input-sm input-bordered ring-0 rounded-none" />
                                    <ul class="py-1 text-base ring-1 ring-black ring-opacity-5 max-h-56 overflow-auto focus:outline-none sm:text-sm" >
                                        @if(count($machines) < 1)
                                            <li class="text-gray-900 cursor-default select-none relative py-2 pl-3 pr-9" >
                                                <div class="flex items-center">
                                                    <span class="font-normal ml-3 block truncate" >No records found</span>
                                                </div>
                                            </li>
                                        @endif
                                        @foreach($machines as $item)
                                            <li class="text-gray-900 cursor-default select-none relative py-2 pl-3 pr-9"
                                                :class="{ 'bg-primary text-primary-content' : machinesPicker.activeId == {{ $item->id }} }"
                                                @click="machinesPicker.selectItem({{ $item->id }})"
                                                @mouseenter="machinesPicker.activeId = {{ $item->id }}"
                                                @mouseleave="machinesPicker.activeId = null"
                                            >
                                                <div class="flex items-center">
                                                    <span class="font-normal ml-3 block truncate" >{{ $item->title }}</span>
                                                </div>
                                                @if(array_search($item->id, $machineIds) > -1)
                                                    <span class="text-indigo-900 absolute inset-y-0 right-0 flex items-center pr-4" >
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                    </svg>
                                                </span>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="pt-5">
                            <input type="hidden" name="process_ids" value="{{ json_encode($processIds) }}" />
                            <div @click="processesPicker.open = true"
                                 @click.away="processesPicker.open = false"
                                 class="relative">
                                <button type="button" class="relative h-12 w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" >
                                <span class="flex items-center gap-2 overflow-auto h-full">
                                    @if(empty($processIds))
                                        <span class="ml-3 block truncate">Select options</span>
                                    @endif
                                    @foreach(\App\Models\Process::query()->select('id', 'title')->whereIn('id', $processIds)->get() as $item)
                                        <span @click="processesPicker.selectItem({{ $item->id }})" class="badge badge-sm gap-2 cursor-pointer whitespace-nowrap">
                                            {{ $item->title }}
                                        </span>
                                    @endforeach
                                </span>
                                    <span class="ml-3 absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                    <x-ic.selector class="h-5 w-5 text-gray-400" />
                                </span>
                                </button>
                                <label class="absolute left-2 -top-3.5 text-gray-600 text-base transition-all bg-white px-2 peer-placeholder-shown:text-lg peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-2 peer-placeholder-shown:px-0 peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-base peer-focus:px-2">
                                    Process Supported
                                </label>
                                @error('processIds')<span class="text-error text-sm pl-2">{{ $message }}</span>@enderror
                                <div
                                    x-show="processesPicker.open"
                                    x-transition:leave="transition ease-in duration-100"
                                    x-transition:leave-start="opacity-100"
                                    x-transition:leave-end="opacity-0"
                                    class="mt-2 absolute z-10 mt-1 w-full bg-white shadow-lg rounded-md " >
                                    <input type="search" wire:model="machinesFilterText" placeholder="Search"
                                           class="input input-sm input-bordered ring-0 rounded-none" />
                                    <ul class="py-1 text-base ring-1 ring-black ring-opacity-5 max-h-56 overflow-auto focus:outline-none sm:text-sm" >
                                        @if(count($processes) < 1)
                                            <li class="text-gray-900 cursor-default select-none relative py-2 pl-3 pr-9" >
                                                <div class="flex items-center">
                                                    <span class="font-normal ml-3 block truncate" >No records found</span>
                                                </div>
                                            </li>
                                        @endif
                                        @foreach($processes as $item)
                                            <li class="text-gray-900 cursor-default select-none relative py-2 pl-3 pr-9"
                                                :class="{ 'bg-primary text-primary-content' : processesPicker.activeId == {{ $item->id }} }"
                                                @click="processesPicker.selectItem({{ $item->id }})"
                                                @mouseenter="processesPicker.activeId = {{ $item->id }}"
                                                @mouseleave="processesPicker.activeId = null"
                                            >
                                                <div class="flex items-center">
                                                    <span class="font-normal ml-3 block truncate" >{{ $item->title }}</span>
                                                </div>
                                                @if(array_search($item->id, $processIds) > -1)
                                                    <span class="text-indigo-900 absolute inset-y-0 right-0 flex items-center pr-4" >
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                    </svg>
                                                </span>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-y-4 gap-x-6">
                    <div class="md:col-span-2">
                        <x-form.text-input type="text" wire:model.lazy="address1" name="address1" label="Registered Address" required />
                    </div>
                    <x-form.text-input type="text" wire:model.lazy="pincode1" name="pincode1" label="Pincode" required />
                    <div class="md:col-span-2">
                        <x-form.text-input type="text" wire:model.lazy="address2" name="address2" label="Manufacturing Unit Address" />
                    </div>
                    <x-form.text-input type="text" wire:model.lazy="pincode2" name="pincode2" label="Pincode" autocomplete="pincode" />
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-y-4 gap-x-6">
                    <div class="pt-5">
                        <div class="relative">
                            <input :type="showPassword ? 'text' : 'password'" id="password" name="password" placeholder="Password"
                                class="peer w-full h-12 pl-3 py-2 text-lg rounded-lg border border-gray-300 text-gray-500 placeholder-transparent focus:outline-none focus:ring-transparent focus:border-2 focus:border-secondary"
                            />
                            <label for="password" class="absolute left-3 -top-3.5 text-gray-600 text-base transition-all bg-white px-2 rounded-lg
                        peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3 peer-placeholder-shown:px-0
                        peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-base peer-focus:px-2">
                                Password <span class="text-error">*</span>
                            </label>
                            <span @click="showPassword = !showPassword" class="absolute right-3 top-3 cursor-pointer">
                                <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </span>
                        </div>
                        <span class="text-info text-sm pl-2">Password should contain minimum 8 characters</span>
                        @error('password')<br /><span class="text-error text-sm pl-2">{{ $message }}</span> @enderror
                    </div>
                    <div class="pt-5">
                        <div class="relative">
                            <input :type="showPassword ? 'text' : 'password'" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password"
                                   class="peer w-full h-12 pl-3 py-2 text-lg rounded-lg border border-gray-300 text-gray-500 placeholder-transparent focus:outline-none focus:ring-transparent focus:border-2 focus:border-secondary"
                            />
                            <label for="password_confirmation" class="absolute left-3 -top-3.5 text-gray-600 text-base transition-all bg-white px-2 rounded-lg
                        peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3 peer-placeholder-shown:px-0
                        peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-base peer-focus:px-2">
                                Confirm Password <span class="text-error">*</span>
                            </label>
                            <span @click="showPassword = !showPassword" class="absolute right-3 top-3 cursor-pointer">
                                <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </span>
                        </div>
                        @error('password_confirmation')<span class="text-error text-sm pl-2">{{ $message }}</span> @enderror
                    </div>
                    <x-form.text-input type="text" wire:model="referral_code" name="referral_code" label="Referral Code" />
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary font-bold">Create Account</button>
                </div>
                @csrf
                <div class="text-center">
                    Already have an account? <a href="{{ route('login') }}" class="text-secondary underline">Login</a>
                </div>
            </form>
        </div>
    </div>
</div>
