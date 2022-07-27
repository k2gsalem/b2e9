<div>
    <header class="flex justify-between items-center bg-primary text-primary-content shadow py-4 px-4 sm:px-6 lg:px-8">
        <div class="font-semibold text-xl">
            {{ __('Support Page') }}
        </div>
    </header>

    <main class="p-6 space-y-6">
        <div class="flex justify-center items-center gap-4 border-b-2 border-dotted pb-8">
            <label class="text-xl">User ID / Mobile / email ID</label>
            <input type="text" wire:keydown.enter="search" wire:model.defer="search" placeholder="Search here" class="input rounded w-full max-w-xs" />
            <button type="button" wire:click="search" class="btn btn-primary" >Submit</button>
            <button type="button" wire:click="clear" class="btn btn-secondary">Clear</button>
        </div>
        @if($model && $model->exists)
            <div class="grid grid-cols-2 gap-2 text-lg border-b-2 border-dotted pb-8">
                <div class="flex gap-10">
                    <div class="flex gap-4">
                        <span>User ID: </span>
                        <span class="text-primary">{{ $model->id }}</span>
                    </div>
                </div>
                <div class="flex gap-4">
                    <span>Organization Type: </span>
                    <span class="text-primary">{{ $model->organization_type }}</span>
                </div>
                <div class="col-span-2 flex gap-4">
                    <span>Name of the Organization: </span>
                    <span class="text-primary">{{ $model->name }}</span>
                </div>
                <div class="col-span-2 flex gap-4">
                    <span>Address of the Manufacturing Unit I: </span>
                    <span class="text-primary">{{ $model->manufacturing_unit->address }}</span>
                </div>
                <div class="flex gap-4">
                    <span>Pincode: </span>
                    <span class="text-primary">{{ $model->manufacturing_unit->pincode }}</span>
                </div>
                <div class="flex gap-4">
                    <span>GST Number: </span>
                    <span class="text-primary">{{ $model->gst_number }}</span>
                </div>
                <div class="col-span-2 flex gap-4">
                    <span>Address of the Manufacturing Unit II: </span>
                    <span class="text-primary">{{ optional($model->manufacturing_unit2)->address }}</span>
                </div>
                <div class="flex gap-4">
                    <span>Pincode: </span>
                    <span class="text-primary">{{ optional($model->manufacturing_unit2)->pincode }}</span>
                </div>
                <div class="flex gap-4">
                    <span>Name of Authorized Person: </span>
                    <span class="text-primary">{{ $model->contact_name }}</span>
                </div>
                <div class="space-y-2">
                    <div class="flex gap-4">
                        <span>Date of Incorporation: </span>
                        <span class="text-primary">{{ optional($model->incorporation_date)->format('d M, Y') }}</span>
                    </div>
                    <div class="flex gap-4">
                        <span>Number of Employees: </span>
                        <span class="text-primary">{{ $model->employees_count }}</span>
                    </div>
                    <div class="flex gap-4">
                        <span>Sales Turn Over: </span>
                        <span class="text-primary">{{ $model->sales_turnover }}</span>
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="flex gap-4">
                        <span>Primary Mobile Number: </span>
                        <span class="text-primary">{{ $model->phone }}</span>
                    </div>
                    <div class="flex gap-4">
                        <span>Secondary Mobile Number: </span>
                        <span class="text-primary">{{ $model->alternate_phone }}</span>
                    </div>
                    <div class="flex gap-4">
                        <span>Email ID: </span>
                        <span class="text-primary">{{ $model->email }}</span>
                    </div>
                </div>
                <div class="col-span-2 flex gap-4">
                    <span>Machines Available: </span>
                    <span class="text-primary">{{ implode(", ", $model->machines()->pluck('title')->toArray()) }}</span>
                </div>
                <div class="col-span-2 flex gap-4">
                    <span>Processes Available: </span>
                    <span class="text-primary">{{ implode(", ", $model->processes()->pluck('title')->toArray()) }}</span>
                </div>
            </div>

            @if(in_array($model->role, ['both', 'supplier']))
                <h4 class="text-2xl font-bold">As Supplier</h4>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-12">
                    <x-form.text-input type="search" class="md:col-span-5"
                                       wire:model="sub_search"
                                       name="search"
                                       label="Search" />
                    <x-form.text-input type="datetime-local" class="md:col-span-3"
                                       wire:model="sub_start_date"
                                       name="start_date"
                                       label="Start Date" />
                    <x-form.text-input type="datetime-local" class="md:col-span-3"
                                       wire:model="sub_end_date"
                                       name="end_date"
                                       label="End Date" />
                </div>
                <div class="bg-white shadow rounded-lg overflow-auto">
                    <table class="table table-compact table-zebra">
                        <thead>
                        <tr>
                            <th>S.No.</th>
                            <th>Plan</th>
                            <th>Txn</th>
                            <th>Bids<br />(Fresh/Edit)</th>
                            <th>Starts At</th>
                            <th>Ends At</th>
                            <th>Paid At</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($this->sub_records) < 1)
                            <tr>
                                <td colspan="100">
                                    <div class=" text-center">
                                        {{ __('No records found') }}
                                    </div>
                                </td>
                            </tr>
                        @endif
                        @foreach($this->sub_records as $record)
                            <tr wire:key="{{ $record->id }}" class="group hover rounded-none cursor-pointer">
                                <td>{{ $loop->index + $this->sub_records->firstItem() }}</td>
                                <td>
                                    <div class="flex items-center space-x-3">
                                        <div>
                                            <div class="font-bold">
                                                {{ $record->plan->code }}
                                            </div>
                                            <div class="text-sm opacity-50">
                                                {{ $record->plan->type }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="flex items-center space-x-3">
                                        <div>
                                            <div class="font-bold hidden">
                                                {{ config('app.currency_symbol').$record->amount }}
                                            </div>
                                            <div class="text-sm opacity-50">
                                                {{ $record->transaction ? $record->transaction->uuid : '' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="tabular-nums">{{ $record->fresh_bids }} / {{ $record->additional_bids }}</td>
                                <td>{{ $record->starts_at->format('d-M-Y h:i A') }}</td>
                                <td>{{ $record->ends_at->format('d-M-Y h:i A') }}</td>
                                <td>{{ optional($record->transaction->paid_at)->format('d-M-Y h:i A') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="md:flex gap-6">
                    <div class="grow self-end">
                        {{ $this->sub_records->links() }}
                    </div>
                </div>
            @endif

            @if(in_array($model->role, ['both', 'customer']))
                <h4 class="text-2xl font-bold">As Customer</h4>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-12">
                    <x-form.text-input type="search" class="md:col-span-5"
                                       wire:model="proj_search"
                                       name="search"
                                       label="Search" />
                    <x-form.text-input type="datetime-local" class="md:col-span-3"
                                       wire:model="proj_start_date"
                                       name="start_date"
                                       label="Start Date" />
                    <x-form.text-input type="datetime-local" class="md:col-span-3"
                                       wire:model="proj_end_date"
                                       name="end_date"
                                       label="End Date" />
                </div>
                <div class="bg-white shadow rounded-lg overflow-auto">
                    <table class="table table-compact table-zebra">
                        <thead>
                        <tr>
                            <th>S.No.</th>
                            <th>Project</th>
                            <th>Bids</th>
                            <th class="hidden">Amount</th>
                            <th>Mode</th>
                            <th>Paid At</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($this->proj_records) < 1)
                            <tr>
                                <td colspan="100">
                                    <div class=" text-center">
                                        {{ __('No records found') }}
                                    </div>
                                </td>
                            </tr>
                        @endif
                        @foreach($this->proj_records as $record)
                            <tr wire:key="{{ $record->id }}" class="group hover rounded-none cursor-pointer">
                                <td>{{ $loop->index + $this->proj_records->firstItem() }}</td>
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
                                <td class="tabular-nums hidden">{{ config('app.currency_symbol').$record->final_amount }}</td>
                                <td>{{ $record->mode }}</td>
                                <td>{{ $record->paid_at ? $record->paid_at->format('d-M-Y h:i A') : '' }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="md:flex gap-6">
                    <div class="grow self-end">
                        {{ $this->proj_records->links() }}
                    </div>
                </div>
            @endif
        @else
            No data found
        @endif
    </main>
</div>
