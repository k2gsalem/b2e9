<div x-data="calculatorData({!! \Illuminate\Support\Js::from($materials) !!})" class="pg-container space-y-6 py-6">
    <div class="text-center py-6">
        <span class="bg-secondary text-secondary-content rounded-full py-4 px-6 text-4xl font-bold uppercase">{{ __('New Project') }}</span>
    </div>
    @if (session('flash'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ session('flash') }}
        </div>
    @endif
    <div x-data="{
        instantPublish: @entangle('instantPublish'),
        operationTypesPicker: {
            open: false,
            activeId: null,
            activeIds: @entangle('operationTypeIds'),
            selectItem: function(id) {
                $wire.selectOperationType(id)
            },
        },
        manufacturingUnitPicker: {
            open: false,
            activeId: null,
            selectedItem: @entangle('project.manufacturing_unit_id'),
            selectItem: function(id) {
                $wire.set('project.manufacturing_unit_id', id)
            },
        },
        pub_date: @entangle('publish_date'),
        pub_time: @entangle('publish_time'),
        instantChanged: function() {
            return;
            if(this.instantPublish) {
                this.pub_date = '{{ date('Y-m-d') }}';
                this.pub_time = '{{ date('H:i:s') }}';
            }
            else {
                this.pub_date = null;
                this.pub_time = null;
            }
        }
    }" class="card compact lg:px-4">
        <div class="card-body">
            <form method="post" wire:submit.prevent="create" class="grid grid-cols-1 md:grid-cols-2 md:gap-x-6 gap-y-6">
                <div class="md:col-span-2">
                    <x-form.text-input type="text" wire:model.lazy="project.title" name="project.title" label="Project Title" required />
                </div>
                <x-form.text-input type="text" wire:model.lazy="project.part_name" name="project.part_name" label="Part Name" required />
                <x-form.text-input type="text" wire:model.lazy="project.drawing_number" name="project.drawing_number" label="Drawing Number" required />
                <x-form.text-input type="date" wire:model.lazy="project.delivery_date" name="project.delivery_date" label="Delivery Date" required />
                <div class="pt-5">
                    <div @click="operationTypesPicker.open = true"
                         @click.away="operationTypesPicker.open = false"
                         class="relative">
                        <button type="button" class="relative h-12 w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-secondary focus:border-secondary sm:text-sm" >
                                <span class="flex items-center gap-2 overflow-auto h-full">
                                    @if(empty($operationTypeIds))
                                        <span class="ml-3 block truncate">Select options</span>
                                    @endif
                                    @foreach(\App\Models\Process::query()->select('id', 'title')->whereIn('id', $operationTypeIds)->get() as $item)
                                        <span @click="operationTypesPicker.selectItem({{ $item->id }})" class="badge badge-sm gap-2 cursor-pointer whitespace-nowrap">
                                            {{ $item->title }}
                                        </span>
                                    @endforeach
                                </span>
                            <span class="ml-3 absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                    <x-ic.selector class="h-5 w-5 text-gray-400" />
                                </span>
                        </button>
                        <label class="absolute left-2 -top-3.5 text-gray-600 text-base transition-all bg-white px-2 peer-placeholder-shown:text-lg peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-2 peer-placeholder-shown:px-0 peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-base peer-focus:px-2">
                            Type of Operations <span class="text-error">*</span>
                        </label>
                        @error('operationTypeIds')<span class="text-error text-sm pl-2">{{ $message }}</span>@enderror
                        <div
                            x-show="operationTypesPicker.open"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0"
                            class="mt-2 absolute z-10 mt-1 w-full bg-white shadow-lg rounded-md " >
                            <input type="search" wire:model="operationTypesFilter" placeholder="Search"
                                   class="input input-sm input-bordered ring-0 rounded-none" />
                            <ul class="py-1 text-base ring-1 ring-black ring-opacity-5 max-h-56 overflow-auto focus:outline-none sm:text-sm" >
                                @if(count($operationTypes) < 1)
                                    <li class="text-gray-900 cursor-default select-none relative py-2 pl-3 pr-9" >
                                        <div class="flex items-center">
                                            <span class="font-normal ml-3 block truncate" >No records found</span>
                                        </div>
                                    </li>
                                @endif
                                @foreach($operationTypes as $item)
                                    <li class="text-gray-900 cursor-default select-none relative py-2 pl-3 pr-9"
                                        :class="{ 'bg-primary text-primary-content' : operationTypesPicker.activeId == {{ $item->id }} }"
                                        @click="operationTypesPicker.selectItem({{ $item->id }})"
                                        @mouseenter="operationTypesPicker.activeId = {{ $item->id }}"
                                        @mouseleave="operationTypesPicker.activeId = null"
                                    >
                                        <div class="flex items-center">
                                            <span class="font-normal ml-3 block truncate" >{{ $item->title }}</span>
                                        </div>
                                        @if(array_search($item->id, $operationTypeIds) > -1)
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
                <div class="pt-5 hidden">
                    <div @click="manufacturingUnitPicker.open = !manufacturingUnitPicker.open"
                         @click.away="manufacturingUnitPicker.open = false"
                         class="relative">
                        <button type="button" class="relative h-12 w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-secondary focus:border-secondary" >
                                <span class="flex items-center gap-2 overflow-auto h-full">
                                    @if($project->manufacturing_unit)
                                        <span class="block truncate text-base">{{ $project->manufacturing_unit->address }}</span>
                                        <span class="block truncate text-gray-400 text-xs">{{ $project->manufacturing_unit->pincode }}</span>
                                    @else
                                        <span class="block truncate">Select option</span>
                                    @endif
                                </span>
                            <span class="ml-3 absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                    <x-ic.selector class="h-5 w-5 text-gray-400" />
                                </span>
                        </button>
                        <label class="absolute left-2 -top-3.5 text-gray-600 text-base transition-all bg-white px-2 peer-placeholder-shown:text-lg peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-2 peer-placeholder-shown:px-0 peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-base peer-focus:px-2">
                            Manufacturing Unit <span class="text-error">*</span>
                        </label>
                        @error('project.manufacturing_unit_id')<span class="text-error text-sm pl-2">{{ $message }}</span>@enderror
                        <div
                            x-show="manufacturingUnitPicker.open"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0"
                            class="mt-2 absolute z-10 mt-1 w-full bg-white shadow-lg rounded-md " >
                            <input type="search" wire:model="manufacturingUnitsFilter" placeholder="Search"
                                   class="input input-sm input-bordered ring-0 rounded-none" />
                            <ul class="py-1 text-base ring-1 ring-black ring-opacity-5 max-h-56 overflow-auto focus:outline-none sm:text-sm" >
                                @if(count($manufacturingUnits) < 1)
                                    <li class="text-gray-900 cursor-default select-none relative py-2 pl-3 pr-9" >
                                        <div class="flex items-center">
                                            <span class="font-normal ml-3 block truncate" >No records found</span>
                                        </div>
                                    </li>
                                @endif
                                @foreach($manufacturingUnits as $item)
                                    <li class="text-gray-900 cursor-default select-none relative py-2 pl-3 pr-9"
                                        :class="{ 'bg-primary text-primary-content' : manufacturingUnitPicker.activeId == {{ $item->id }} }"
                                        @click="manufacturingUnitPicker.selectItem({{ $item->id }})"
                                        @mouseenter="manufacturingUnitPicker.activeId = {{ $item->id }}"
                                        @mouseleave="manufacturingUnitPicker.activeId = null"
                                    >
                                        <div class="flex items-center">
                                            <span class="font-normal ml-3 block truncate" >{{ $item->address }}</span>
                                        </div>
                                        @if($item->id == $project->manufacturing_unit_id)
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
                <div class="space-y-2">
                    <div class="flex items-center gap-4">
                        <div class="grow">
                            <x-form.text-input type="text" wire:model.lazy="project.location_preference" name="project.location_preference" label="Location Preference (in KM)" required />
                        </div>
                        <div data-tip="Eligible suppliers available within selected range" class="tooltip tooltip-left cursor-pointer">
                            <span class="badge badge-primary badge-lg py-4 shrink">{{ $eligibleSuppliers }}</span>
                        </div>
                    </div>
                    <div class="text-sm text-info">{{ $eligibleSuppliers }} Suppliers available within selected range</div>
                </div>
                <div class="space-y-2">
                    <div class="flex flex-col lg:flex-row gap-4">
                        <x-form.text-input type="number" step="0.01" wire:model.lazy="project.raw_material_price" name="project.raw_material_price" label="Raw Material Price" required readonly class="grow" />
                        <label for="modal-calculator" class="btn btn-secondary modal-button lg:mt-5">
                            <span>Calculate</span>
                        </label>
                    </div>
                    <div class="text-sm text-info">This price is for calculative purpose only. It may differ according to supplier process</div>
                </div>
                <div class="md:col-span-2">
                    <div class="flex gap-2 items-center">
                        <input type="checkbox" name="instantPublish" value="1" x-model="instantPublish" @change="instantChanged" />
                        <span class="label-text">Instant Publish</span>
                    </div>
                </div>
                <div x-show="!instantPublish">
                    <x-form.text-input x-model="pub_date" type="date" name="publish_date" label="Publish Date" required />
                </div>
                <div x-show="!instantPublish">
                    <x-form.text-input x-model="pub_time" type="time" step="1" name="publish_time" label="Publish Time" required />
                </div>
                <x-form.text-input type="date" wire:model.lazy="closing_date" name="closing_date" label="Closing Date" required />
                <x-form.text-input type="time" step="1" wire:model.lazy="closing_time" name="closing_time" label="Closing Time" required />
                <div class="md:col-span-2">
                    <x-form.text-area wire:model.lazy="project.description" name="project.description" label="Description" required />
                </div>
                <div class="md:col-span-2">
                    <x-form.filepond wire:model="attachments"
                                     imagePreviewHeight="250"
                                     multiple
                                     allowFileTypeValidationn
                                     acceptedFileTypess="{{ \Illuminate\Support\Js::from($mime_types) }}"
                                     allowFileSizeValidation
                                     maxFileSize="15mb"
                                     maxTotalFileSize="15mb"
                    />
                    @error('attachments.*')<span class="text-error text-sm pl-2">{{ $message }}</span> @enderror
                </div>
                <div class="md:col-span-2 flex justify-center">
                    <div class="form-control">
                        <label class="cursor-pointer label justify-start space-x-2">
                            <input type="checkbox" name="terms" value="1" class="checkbox" required />
                            <span class="label-text">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Terms of Service').'</a>',
                                'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Privacy Policy').'</a>',
                        ]) !!}
                            </span>
                        </label>
                    </div>
                </div>
                <div class="md:col-span-2 text-center">
                    @if ($errors->any())
                        <div class="mb-4 font-medium text-sm text-error">
                            Kindly verify Red highlighted fields
                        </div>
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                    <button type="submit" class="btn btn-primary">Request for RFQ</button>
                </div>
            </form>
        </div>
    </div>
    <input type="checkbox" id="modal-calculator" class="modal-toggle" />
    <div class="modal">
        <div class="modal-box max-w-4xl relative max-h-screen overflow-y-auto">
            <label for="modal-calculator" class="badge badge-primary text-2xl font-bold cursor-pointer absolute top-3 right-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </label>
            <div class="flex flex-col-reverse lg:flex-col">
                <div class="bg-primary text-primary-content rounded-lg space-y-4 py-6 px-4">
                    <div class="flex flex-col lg:flex-row gap-6 w-full justify-between items-center lg:items-start">
                        <div class="text-3xl text-center">Total Base Amount <span x-text="baseAmount" class="font-bold"></span></div>
                        <div x-show="parts.length > 0" class="flex gap-4">
                            <button type="button" x-on:click="useBaseAmount" class="btn btn-sm btn-secondary">Use this Base Amount</button>
                        </div>
                    </div>
                    <template x-for="(part, index) in parts">
                        <div class="flex w-full justify-between">
                            <div class="flex gap-4">
                                <div x-text="part.material.title" class="uppercase"></div>
                                <div x-text="parseFloat(part.finalWeight).toFixed(2) + 'kg'" class="uppercase font-bold"></div>
                            </div>
                            <div class="flex gap-4">
                                <div x-html="currencySymbol + part.finalCost" class="uppercase font-bold"></div>
                                <span @click="parts.splice(index, 1)" class="cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </template>
                    <div x-show="!showCalculator && parts.length > 0" class="text-right">
                        <button type="button" x-on:click="showCalculator = true" class="btn btn-sm btn-secondary">Add Another Part</button>
                    </div>
                </div>
                <div x-show="showCalculator || parts.length < 1" class="space-y-4 py-4">
                    <h2 class="text-2xl font-bold uppercase text-center">
                        Raw Material Calculation
                    </h2>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Raw Material</span>
                            </label>
                            <select x-model="selectedMaterial" class="select select-bordered w-full" >
                                <option value="">Select an option</option>
                                <template x-for="(item, index) in materials">
                                    <option x-bind:value="index" x-text="item.title"></option>
                                </template>
                            </select>
                        </div>
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Shape</span>
                            </label>
                            <select x-model="selectedShape" class="select select-bordered w-full" >
                                <option value="">Select an option</option>
                                <template x-for="(item, index) in shapes">
                                    <option x-bind:value="index" x-text="item"></option>
                                </template>
                            </select>
                        </div>
                    </div>
                    <div class="flex flex-col lg:flex-row items-center gap-4 lg:gap-6">
                        <div class="w-full lg:w-1/3 flex justify-center items-center">
                            <img x-bind:src="shapeImg" />
                        </div>
                        <div class="w-full lg:w-2/3 grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div x-show="showDiameter">
                                <x-form.text-input type="number"
                                                   onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                                   name="diameter" x-model="diameter" label="Diameter (mm)" />
                            </div>
                            <div x-show="showBeamHeight">
                                <x-form.text-input type="number"
                                                   onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                                   name="beamHeight" x-model="beamHeight" label="Beam Height (mm)" />
                            </div>
                            <div x-show="showWidth">
                                <x-form.text-input type="number"
                                                   onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                                   name="width" x-model="width" label="Width (mm)" />
                            </div>
                            <div x-show="showBreadth">
                                <x-form.text-input type="number"
                                                   onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                                   name="breadth" x-model="breadth" label="Breadth (mm)" />
                            </div>
                            <div x-show="showSide">
                                <x-form.text-input type="number"
                                                   onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                                   name="side" x-model="side" label="Side (mm)" />
                            </div>
                            <div x-show="showAcrossFlat">
                                <x-form.text-input type="number"
                                                   onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                                   name="acrossFlat" x-model="acrossFlat" label="Across Flat (mm)" />
                            </div>
                            <div x-show="showThickness">
                                <x-form.text-input type="number"
                                                   onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                                   name="thickness" x-model="thickness" label="Thickness (mm)" />
                            </div>
                            <div x-show="showFlangeThickness">
                                <x-form.text-input type="number"
                                                   onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                                   name="flangeThickness" x-model="flangeThickness" label="Flange Thickness (mm)" />
                            </div>
                            <div x-show="showWebThickness">
                                <x-form.text-input type="number"
                                                   onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                                   name="webThickness" x-model="webThickness" label="Web Thickness (mm)" />
                            </div>
                            <div x-show="showLength">
                                <x-form.text-input type="number" step="0.01"
                                                   onkeypress="return !(event.charCode == 69)"
                                                   name="length" x-model="length" label="Length (M)" />
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col lg:flex-row lg:items-end gap-4">
                        <div class="flex-1">
                            <x-form.text-input type="number" name="cutWeight" x-bind:value="cutWeight" label="Raw Material Weight (KG)" disabled />
                        </div>
                        <div class="flex-1">
                            <x-form.text-input type="number" step="1" min="1"
                                               onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                               name="qty" x-model="qty" label="Quantity" />
                        </div>
                        <div class="flex-1">
                            <x-form.text-input type="number" name="finalCost" x-bind:value="finalCost" label="Raw material Cost (Rs)" disabled />
                        </div>
                        <div x-show="finalCost && finalCost > 0">
                            <button type="button" x-on:click="addPart" class="btn btn-primary uppercase">Add this Part</button>
                        </div>
                    </div>
                    <div class="text-sm text-info">This price is for calculative purpose only. It may differ according to supplier process</div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            function calculatorData(materials) {
                return {
                    currencySymbol: '₹',
                    parts: [],
                    baseAmount: 0,
                    showCalculator: true,
                    selectedMaterial: null,
                    selectedShape: null,
                    diameter: null,
                    beamHeight: null,
                    width: null,
                    breadth: null,
                    side: null,
                    acrossFlat: null,
                    thickness: null,
                    flangeThickness: null,
                    webThickness: null,
                    length: null,
                    qty: 1,
                    materials: materials,
                    shapes: {
                        'round' : 'Round',
                        'square' : 'Square',
                        'rectangle' : 'Rectangle',
                        'hexagonal' : 'Hexagonal',
                        'octagonal' : 'Octagonal',
                        'round_pipe' : 'Round Pipe',
                        'square_pipe' : 'Square Pipe',
                        'rectangular_pipe' : 'Rectangular Pipe',
                        'sheet' : 'Sheet',
                        'angle' : 'Angle',
                        'c_channel' : 'C-Channel',
                        'i_beam' : 'I Beam'
                    },
                    get shapeImg () {
                        return this.selectedShape ? '{{ \Illuminate\Support\Facades\Storage::url("shapes/") }}'+this.selectedShape+'.jpeg'
                            : 'https://via.placeholder.com/200'
                    },
                    get showDiameter() {
                        return this.selectedShape && ['round', 'round_pipe'].indexOf(this.selectedShape) >= 0
                    },
                    get showBeamHeight() {
                        return this.selectedShape && ['i_beam'].indexOf(this.selectedShape) >= 0
                    },
                    get showWidth() {
                        return this.selectedShape && ['square', 'rectangle', 'square_pipe', 'rectangular_pipe', 'sheet', 'angle', 'c_channel', 'i_beam'].indexOf(this.selectedShape) >= 0
                    },
                    get showBreadth() {
                        return this.selectedShape && ['rectangle', 'rectangular_pipe', 'sheet', 'angle', 'c_channel'].indexOf(this.selectedShape) >= 0
                    },
                    get showSide() {
                        return this.selectedShape && ['hexagonal'].indexOf(this.selectedShape) >= 0
                    },
                    get showAcrossFlat() {
                        return this.selectedShape && ['octagonal'].indexOf(this.selectedShape) >= 0
                    },
                    get showThickness() {
                        return this.selectedShape && ['round_pipe', 'square_pipe', 'rectangular_pipe', 'angle', 'c_channel'].indexOf(this.selectedShape) >= 0
                    },
                    get showFlangeThickness() {
                        return this.selectedShape && ['i_beam'].indexOf(this.selectedShape) >= 0
                    },
                    get showWebThickness() {
                        return this.selectedShape && ['i_beam'].indexOf(this.selectedShape) >= 0
                    },
                    get showLength() {
                        return this.selectedShape && ['round', 'square', 'rectangle', 'hexagonal', 'octagonal', 'round_pipe', 'square_pipe', 'rectangular_pipe', 'sheet', 'angle', 'c_channel', 'i_beam'].indexOf(this.selectedShape) >= 0
                    },
                    get cutWeight() {
                        var weight = null;
                        if (this.selectedMaterial && this.materials[this.selectedMaterial]) {
                            var density = this.materials[this.selectedMaterial].density;

                            switch (this.selectedShape) {
                                case 'round':
                                    weight = 0.7857 * this.diameter * this.diameter * this.length / 1000000;
                                    break;
                                case 'square':
                                    weight = this.width * this.width * this.length / 1000000;
                                    break;
                                case 'rectangle':
                                    weight = this.width * this.breadth * this.length / 1000000;
                                    break;
                                case 'hexagonal':
                                    weight = (0.866 * this.side * this.side * this.length) / 1000000;
                                    break;
                                case 'octagonal':
                                    weight = (4.828 * this.acrossFlat * this.acrossFlat * this.length) / 1000000;
                                    break;
                                case 'round_pipe':
                                    weight = 0.7857 * ((this.diameter * this.diameter) - ((this.diameter - (2 * this.thickness)) * (this.diameter - (2 * this.thickness)))) * this.length / 1000000;
                                    break;
                                case 'square_pipe':
                                    weight = ((this.width * this.width) - ((this.width - (2 * this.thickness)) * (this.width - (2 * this.thickness)))) * this.length / 1000000;
                                    break;
                                case 'rectangular_pipe':
                                    weight = ((this.width * this.breadth) - ((this.width - (2 * this.thickness)) * (this.breadth - (2 * this.thickness)))) * this.length / 1000000;
                                    break;
                                case 'sheet':
                                    weight = (this.width * this.breadth * this.length) / 1000000;
                                    break;
                                case 'angle':
                                    weight = ((this.width * this.thickness * this.length) + ((this.breadth - this.thickness) * this.thickness * this.length)) / 1000000;
                                    break;
                                case 'c_channel':
                                    weight = (((2 * this.breadth) + (this.width - (2 * this.thickness))) * this.thickness * this.length) / 1000000;
                                    break;
                                case 'i_beam':
                                    weight = ((2 *(this.width * this.flangeThickness)) + ((this.beamHeight - (2 * this.flangeThickness)) * this.webThickness)) * this.length / 1000000;
                                    break;
                            }
                            if (this.selectedShape)
                                weight *= density;
                        }
                        return weight ? weight.toFixed(3) : weight;
                    },
                    get finalWeight() {
                        return this.cutWeight ? parseFloat(this.cutWeight * this.qty).toFixed(3) : null;
                    },
                    get finalCost() {
                        return this.finalWeight ? parseFloat(this.finalWeight * this.materials[this.selectedMaterial].price).toFixed(2) : null;
                    },
                    get baseAmount() {
                        var amount = 0;
                        this.parts.forEach(function (part) {
                            amount = amount + parseFloat(part.finalCost);
                        });
                        return parseFloat(amount).toFixed(2);
                    },
                    reset: function () {
                        this.selectedMaterial = null;
                        this.selectedShape = null;
                        this.diameter = null;
                        this.beamHeight = null;
                        this.width = null;
                        this.breadth = null;
                        this.side = null;
                        this.acrossFlat = null;
                        this.thickness = null;
                        this.flangeThickness = null;
                        this.webThickness = null;
                        this.length = null;
                        this.qty = 1;
                    },
                    addPart: function() {
                        if (
                            this.selectedMaterial && this.materials[this.selectedMaterial]
                            && this.selectedShape && this.shapes[this.selectedShape]
                            && this.finalCost && this.finalCost > 0
                        ) {
                            var data = {
                                material: this.materials[this.selectedMaterial],
                                cutWeight: this.cutWeight,
                                qty: this.qty,
                                finalWeight: this.finalWeight,
                                finalCost: this.finalCost
                            };
                            console.log(data);
                            this.parts.push(data);
                            this.showCalculator = false;
                            this.reset();
                        }
                    },
                    useBaseAmount: function () {
                        this.baseValue = this.baseAmount;
                        @this.set('project.raw_material_price', this.baseAmount);
                        document.getElementById("modal-calculator").checked = false;
                    }
                };
            }
        </script>
    @endpush
</div>
