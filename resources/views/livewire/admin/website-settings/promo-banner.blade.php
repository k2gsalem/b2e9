<section id="promo" class="py-4">
    <div class="bg-white border border-secondary rounded-lg p-4 flex flex-col gap-4">
        <div x-data class="max-w-sm mx-auto">
            <input type="file" accept="image/*" x-ref="file" class="hidden" wire:model="promo_banner" />
            <img x-on:click.prevent="$refs.file.click()" src="{{ $promo_banner ? $promo_banner->temporaryUrl() : $promo_banner_url }}" class="w-96 object-cover rounded" />
            @error('promo_banner') <div class="text-sm text-error">{{ $message }}</div>@enderror
        </div>
        <x-form.text-area name="promo_content" wire:model.lazy="promo_content" label="Content" />
    </div>
</section>
