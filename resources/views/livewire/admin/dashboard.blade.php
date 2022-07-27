<div>
    <header class="flex justify-between items-center bg-primary text-primary-content shadow py-4 px-4 sm:px-6 lg:px-8">
        <div class="font-semibold text-xl">
            {{ __('Dashboard') }}
        </div>
    </header>

    <main class="p-6 space-y-6">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="stats shadow">
                <div class="stat">
                    <div class="stat-title">Total Users</div>
                    <div class="stat-value">
                        {{ \App\Models\User::query()->count() }}
                    </div>
                </div>
            </div>
            <div class="stats shadow">
                <div class="stat">
                    <div class="stat-title">Total Projects</div>
                    <div class="stat-value">
                        {{ \App\Models\Project::query()->count() }}
                    </div>
                </div>
            </div>
            <div class="stats shadow">
                <div class="stat">
                    <div class="stat-title">Total Bids</div>
                    <div class="stat-value">
                        {{ \App\Models\Bid::query()->count() }}
                    </div>
                </div>
            </div>
            <div class="stats shadow">
                <div class="stat">
                    <div class="stat-title">Only Suppliers</div>
                    <div class="stat-value">
                        {{ \App\Models\User::query()->where('role', 'supplier')->count() }}
                    </div>
                </div>
            </div>
            <div class="stats shadow">
                <div class="stat">
                    <div class="stat-title">Only Customers</div>
                    <div class="stat-value">
                        {{ \App\Models\User::query()->where('role', 'customer')->count() }}
                    </div>
                </div>
            </div>
            <div class="stats shadow">
                <div class="stat">
                    <div class="stat-title">Both Customer & Supplier</div>
                    <div class="stat-value">
                        {{ \App\Models\User::query()->where('role', 'both')->count() }}
                    </div>
                </div>
            </div>
          </div>
    </main>
</div>
