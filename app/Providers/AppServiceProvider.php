<?php

namespace App\Providers;
use App\Models\Bid;
use App\Models\ManufacturingUnit;
use App\Models\Material;
use App\Models\OneTimePassword;
use App\Models\PlanTransaction;
use App\Models\ProjectTransaction;
use App\Models\Setting;
use App\Models\Subscription;
use App\Models\User;
use App\Observers\BidObserver;
use App\Observers\ManufacturingUnitObserver;
use App\Observers\MaterialObserver;
use App\Observers\OneTimePasswordObserver;
use App\Observers\PlanTransactionObserver;
use App\Observers\ProjectTransactionObserver;
use App\Observers\SettingObserver;
use App\Observers\SubscriptionObserver;
use App\Observers\UserObserver;
use Illuminate\Contracts\Cache\Factory;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind('path.public', function() {
            return base_path().'/public';
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Setting::sync();

        Bid::observe(BidObserver::class);
        ManufacturingUnit::observe(ManufacturingUnitObserver::class);
        Material::observe(MaterialObserver::class);
        OneTimePassword::observe(OneTimePasswordObserver::class);
        PlanTransaction::observe(PlanTransactionObserver::class);
        ProjectTransaction::observe(ProjectTransactionObserver::class);
        Setting::observe(SettingObserver::class);
        Subscription::observe(SubscriptionObserver::class);
        User::observe(UserObserver::class);
    }
}
