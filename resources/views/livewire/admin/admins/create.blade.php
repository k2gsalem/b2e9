<div>
    <header class="flex justify-between items-center bg-primary text-primary-content shadow py-4 px-4 sm:px-6 lg:px-8">
        <div class="font-semibold text-xl">
            {{ __('New Staff') }}
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
                <form wire:submit.prevent="create" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-form.text-input type="text" wire:model.defer="model.name" name="model.name" label="Staff Name" required />
                    <x-form.text-input type="email" wire:model.defer="model.email" name="model.email" label="Email address" required />
                    <x-form.text-input type="password" wire:model.defer="password" name="password" label="New Password" autocomplete="new-password" />
                    <x-form.text-input type="password" wire:model.defer="password_confirmation" name="password_confirmation" label="Confirm Password" autocomplete="new-password" />
                    <div class="md:col-span-2 text-center py-4">
                        <button type="submit" class="btn btn-primary btn-wide">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>
