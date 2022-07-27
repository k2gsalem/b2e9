<section id="about_us" class="py-4">
    <div class="bg-white border border-secondary rounded-lg p-4 flex flex-col gap-4">
        <div x-data class="max-w-sm mx-auto">
            <input type="file" accept="image/*" x-ref="file" class="hidden" wire:model="about_us_image" />
            <img x-on:click.prevent="$refs.file.click()" src="{{ $about_us_image ? $about_us_image->temporaryUrl() : $about_us_image_url }}" class="h-80 max-w-sm object-cover rounded" />
            @error('about_us_image') <div class="text-sm text-error">{{ $message }}</div>@enderror
        </div>
        <x-form.ckeditor.classic wire:model="about_us_content" id="about_us_content" />
    </div>
</section>
