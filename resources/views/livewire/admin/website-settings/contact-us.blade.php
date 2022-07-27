<section id="contact_us" class="py-4">
    <div class="bg-white border border-secondary rounded-lg p-4 space-y-4">
        <x-form.text-input type="tel" name="fields.phone" wire:model.lazy="fields.phone" label="Phone number" />
        <x-form.text-input type="email" name="fields.email" wire:model.lazy="fields.email" label="Email address" />
        <x-form.text-input type="tel" name="fields.toll_free" wire:model.lazy="fields.toll_free" label="Missed call number" />
        <x-form.text-input type="number" name="fields.rfq_percentage" wire:model.lazy="fields.rfq_percentage" label="RFQ Percentage" />
    </div>
</section>
