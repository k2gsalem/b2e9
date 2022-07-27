<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Package extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'code',
        'actual_amount',
        'sale_amount',
        'bids',
        'order_pos',
        'active'
    ];

    protected $casts = [
        'actual_amount' => 'double',
        'sale_amount' => 'double',
        'bids' => 'integer',
        'order_pos' => 'integer',
        'active' => 'boolean',
        'gst_percentage' => 'integer',
        'gst_amount' => 'decimal:2',
        'final_amount' => 'decimal:2',
    ];

    protected $appends = [
        'gst_percentage',
        'gst_amount',
        'final_amount',
    ];

    public function getGstPercentageAttribute()
    {
        return 18;
    }

    public function getGstAmountAttribute()
    {
        return $this->sale_amount * ($this->gst_percentage / 100);
    }

    public function getFinalAmountAttribute()
    {
        return round($this->gst_amount + $this->sale_amount, 2);
    }
}
