<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'value'
    ];

    public static function set($name, $value = null)
    {
        self::query()->updateOrCreate(['name' => $name], ['value' => $value]);
    }

    public static function sync()
    {
        $settings = Cache::remember('settings', 60, function () {
            return Setting::query()->pluck('value', 'name')->all();
        });
        config()->set('settings', $settings);
    }
}
