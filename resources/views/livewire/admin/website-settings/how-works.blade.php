<section id="how_works" class="py-4">
    <div class="bg-white border border-secondary rounded-lg p-4 space-y-4">
        <div x-data class="max-w-sm mx-auto">
            <input type="file" accept="image/*" x-ref="file" class="hidden" wire:model="how_works_image" />
            <img x-on:click.prevent="$refs.file.click()" src="{{ $how_works_image ? $how_works_image->temporaryUrl() : $how_works_image_url }}" class="h-80 max-w-sm object-cover rounded" />
            @error('about_us_image') <div class="text-sm text-error">{{ $message }}</div>@enderror
        </div>
        <x-form.ckeditor.classic wire:model="how_works_content" id="how_works_content" />
        <x-form.text-input type="url" name="how_works_video" wire:model.lazy="how_works_video" label="Video url" />
        <x-form.ckeditor.classic wire:model="how_works_video_content" id="how_works_video_content" />
        <x-form.ckeditor.classic wire:model="how_works_video2_content" id="how_works_video2_content" />
        <x-form.text-input type="url" name="how_works_video2" wire:model.lazy="how_works_video2" label="Video url" />
        <x-form.ckeditor.classic wire:model="how_works_video2_content2" id="how_works_video2_content2" />
        <x-form.ckeditor.classic wire:model="how_works_video3_content" id="how_works_video3_content" />
        <x-form.text-input type="url" name="how_works_video3" wire:model.lazy="how_works_video3" label="Video url" />
        <x-form.ckeditor.classic wire:model="how_works_video3_content2" id="how_works_video3_content2" />
    </div>
</section>
