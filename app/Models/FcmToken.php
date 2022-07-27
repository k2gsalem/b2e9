<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FcmToken extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'token',
        'user_id',
        'device_name'
    ];

    public function getDeviceNameAttribute()
    {
        return $this->attributes['device_name'] ?: 'Unknown device';
    }
}
