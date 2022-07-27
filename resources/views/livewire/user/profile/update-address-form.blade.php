<x-jet-form-section submit="save">
    <x-slot name="title">
        {{ __('Update Address') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update your registered address and Manufacturing Unit address') }}
    </x-slot>

    <x-slot name="form">
        <x-form.text-input type="text" wire:model.defer="registered_address.address" name="registered_address.address" label="Registered Address" class="col-span-6 sm:col-span-4" required />
        <x-form.text-input type="text" wire:model.lazy="registered_address.pincode" name="registered_address.pincode" label="Pincode" class="col-span-6 sm:col-span-2" disabled />
        <x-form.text-input type="text" wire:model.defer="manufacturing_unit.address" name="manufacturing_unit.address" label="Manufacturing Unit Address" class="col-span-6 sm:col-span-4" />
        @if($manufacturing_unit->exists)
            <x-form.text-input type="text" wire:model.lazy="manufacturing_unit.pincode" name="manufacturing_unit.pincode" label="Pincode" autocomplete="pincode" class="col-span-6 sm:col-span-2" />
        @else
            <x-form.text-input type="text" wire:model.lazy="manufacturing_unit.pincode" name="manufacturing_unit.pincode" label="Pincode" autocomplete="pincode" class="col-span-6 sm:col-span-2" />
        @endif
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
