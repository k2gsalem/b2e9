<div>
    <div class="flex flex-col gap-4">
        <section class="grid grid-cols-1 md:grid-cols-4 gap-4 py-2">
            <div x-data>
                <input type="file" accept="image/*" x-ref="file" class="hidden" wire:model="home_banner1" />
                <img x-on:click.prevent="$refs.file.click()" src="{{ $home_banner1 ? $home_banner1->temporaryUrl() : $home_banner1_url }}" alt="Banner 1" class="w-full h-52 object-cover rounded shadow" />
                @error('home_banner1') <div class="text-sm text-error">{{ $message }}</div>@enderror
            </div>
            <div x-data class="lg:col-span-2">
                <input type="file" accept="image/*" x-ref="file" class="hidden" wire:model="home_banner2" />
                <img x-on:click.prevent="$refs.file.click()" src="{{ $home_banner2 ? $home_banner2->temporaryUrl() : $home_banner2_url }}" alt="Banner 1" class="w-full h-52 object-cover rounded shadow" />
                @error('home_banner2') <div class="text-sm text-error">{{ $message }}</div>@enderror
            </div>
            <div x-data>
                <input type="file" accept="image/*" x-ref="file" class="hidden" wire:model="home_banner3" />
                <img x-on:click.prevent="$refs.file.click()" src="{{ $home_banner3 ? $home_banner3->temporaryUrl() : $home_banner3_url }}" alt="Banner 1" class="w-full h-52 object-cover rounded shadow" />
                @error('home_banner3') <div class="text-sm text-error">{{ $message }}</div>@enderror
            </div>
        </section>
    </form>
</div>
