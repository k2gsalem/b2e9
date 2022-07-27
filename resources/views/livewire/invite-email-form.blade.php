<form wire:submit.prevent="submit" class="flex items-end gap-6 w-full">
    <x-form.text-input type="email" wire:model.defer="email" name="email" label="Enter email address here" class="grow" />
    <button type="submit" class="btn btn-primary">Send</button>
</form>
