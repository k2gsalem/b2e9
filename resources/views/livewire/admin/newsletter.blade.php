<div>
    <header class="flex justify-between items-center bg-primary text-primary-content shadow py-4 px-4 sm:px-6 lg:px-8">
        <div class="font-semibold text-xl">
            {{ __('Send Newsletter') }}
        </div>
    </header>

    <main class="p-6 space-y-6">
        <div class="card compact">
            <div class="card-body space-y-6">
                <form wire:submit.prevent="submit" class="">
                    <section id="promo" class="py-4">
                        <div class="bg-white border border-secondary rounded-lg p-4 flex flex-col gap-4">
                            <div x-data class="max-w-sm mx-auto">
                                <input type="file" accept="image/*" x-ref="file" class="hidden" wire:model.defer="image" />
                                <img x-on:click.prevent="$refs.file.click()" src="{{ $image ? $image->temporaryUrl() : 'https://via.placeholder.com/300x200.png' }}" class="w-96 object-cover rounded" />
                                @error('image') <div class="text-sm text-error">{{ $message }}</div>@enderror
                            </div>
                            <x-form.ckeditor.classic wire:model="content" id="content" />
                        </div>
                    </section>
                    <div class="text-center py-4">
                        <button type="submit" class="btn btn-primary btn-wide">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>
