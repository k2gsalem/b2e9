<div>
    <header class="flex justify-between items-center bg-primary text-primary-content shadow py-4 px-4 sm:px-6 lg:px-8">
        <div class="font-semibold text-xl">
            {{ __('New Process') }}
        </div>
        <button type="button" wire:click="$set('action', 'index')" class="btn btn-secondary btn-sm" >Cancel</button>
    </header>

    <main class="p-6 space-y-6">
        <div class="card compact">
            <div class="card-body space-y-6">
                @if(session()->has('info'))
                    <div class="alert alert-info">
                        <div class="flex-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="w-6 h-6 mx-2 stroke-current">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <label>{{ session()->get('info') }}</label>
                        </div>
                    </div>
                @endif
                <form wire:submit.prevent="create" class="grid grid-cols-1 md:grid-cols-12 gap-4">
                    <x-form.text-input type="text" required class="md:col-span-9"
                                       wire:model.defer="model.title" name="model.title"
                                       label="Title"  />
                    <x-form.text-input type="text" required class="md:col-span-3"
                                       wire:model.defer="model.hourly_price" name="model.hourly_price"
                                       label="Hourly Price"  />
                    <x-form.text-input type="url" required class="md:col-span-12"
                                       wire:model.defer="model.image" name="model.image"
                                       label="Image Url"  />
                    <x-form.text-input type="url" required class="md:col-span-12"
                                       wire:model.defer="model.wikipedia" name="model.wikipedia"
                                       label="Wikipedia Url"  />
                    <x-form.text-area class="md:col-span-12"
                                    wire:model.defer="model.description" name="model.description"
                                       label="Description"  />
                    <div class="md:col-span-12 text-center py-4">
                        <button type="submit" class="btn btn-primary btn-wide">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>
