<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ManufacturingUnit extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address',
        'pincode',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'latitude' => 'double',
        'longitude' => 'double',
        'active' => 'boolean',
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function scopeDistance(Builder $query, array $coordinates, string $as = 'distance')
    {
        $haversine = "(6371 * acos(cos(radians(".$coordinates['latitude'].")) * cos(radians(latitude)) * cos(radians(longitude) - radians(".$coordinates['longitude'].")) + sin(radians(".$coordinates['latitude'].")) * sin(radians(latitude))))";
        return $query->selectSub(function (\Illuminate\Database\Query\Builder $q) use ($haversine) {
            $q->selectRaw($haversine);
        }, $as);
    }
}
