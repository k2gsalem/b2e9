<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BidReview extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'bid_id',
        'rating',
        'feedback',
    ];

    protected $casts = [
        'rating' => 'double',
    ];

    public function bid() : BelongsTo
    {
        return $this->belongsTo(Bid::class);
    }
}
