<section id="nda" class="py-4">
    <div class="bg-white border border-secondary rounded-lg p-4 flex flex-col gap-4">
        <div x-data class="max-w-sm mx-auto">
            <input type="file" accept="image/*" x-ref="file" class="hidden" wire:model="nda_image" />
            <img x-on:click.prevent="$refs.file.click()" src="{{ $nda_image ? $nda_image->temporaryUrl() : $nda_image_url }}" class="h-80 max-w-sm object-cover rounded" />
            @error('nda_image') <div class="text-sm text-error">{{ $message }}</div>@enderror
        </div>
        <x-form.ckeditor.classic wire:model="nda_content" id="nda_content" />
    </div>
</section>
