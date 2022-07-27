<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends BaseModel
{
    use HasFactory;

    public const TYPE_STANDARD = 'STANDARD';
    public const TYPE_PREMIUM = 'PREMIUM';

    protected $fillable = [
        'code',
        'type',
        'title',
        'description',
        'actual_amount',
        'sale_amount',
        'fresh_bids',
        'additional_bids',
        'validity_days',
        'order_pos',
        'active'
    ];

    protected $casts = [
        'actual_amount' => 'double',
        'sale_amount' => 'double',
        'fresh_bids' => 'integer',
        'additional_bids' => 'integer',
        'validity_days' => 'integer',
        'order_pos' => 'integer',
        'active' => 'boolean',
    ];

    public function benefits() : HasMany
    {
        return $this->hasMany(PlanBenefit::class);
    }
}
