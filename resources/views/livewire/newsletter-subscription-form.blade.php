<form wire:submit.prevent="submit" class="flex items-end gap-6">
    <x-form.text-input type="email" wire:model.defer="model.email" name="model.email" label="Enter your email" class="grow" />
    <button type="submit" class="btn btn-primary">Subscribe</button>
</form>
