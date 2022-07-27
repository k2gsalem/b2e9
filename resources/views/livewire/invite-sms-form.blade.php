<form wire:submit.prevent="submit" class="flex items-end gap-6 w-full">
    <x-form.text-input type="tel" wire:model.defer="phone" name="phone" label="Enter mobile number here" class="grow" />
    <button type="submit" class="btn btn-primary">Send</button>
</form>
