<?php

namespace App\Observers;

use App\Models\Setting;
use Illuminate\Contracts\Cache\Factory;
use Illuminate\Support\Facades\Cache;

class SettingObserver
{
    public function saved(Setting $model)
    {
        Cache::forget('settings');
        Setting::sync();
    }
}
