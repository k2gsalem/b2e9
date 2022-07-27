<section id="how_works" class="py-4">
    <div class="bg-white border border-secondary rounded-lg p-4 space-y-4">
        <x-form.text-input type="number" min="0" name="visitors" wire:model.lazy="visitors" label="Visitors" />
        <x-form.text-input type="number" min="0" name="projects" wire:model.lazy="projects" label="Projects" />
        <x-form.text-input type="number" min="0" name="clients" wire:model.lazy="clients" label="Customers" />
        <x-form.text-input type="number" min="0" name="customers" wire:model.lazy="customers" label="Suppliers" />
    </div>
</section>
