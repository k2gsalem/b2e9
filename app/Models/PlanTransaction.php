<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlanTransaction extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'plan_id',
        'user_id',
        'subscription_id',
        'amount',
        'gst_amount',
        'final_amount',
        'mode',
        'invoice_id'
    ];

    protected $casts = [
        'amount' => 'double',
        'gst_amount' => 'double',
        'final_amount' => 'double',
        'paid_at' => 'datetime',
        'invoice_id' => 'integer',
    ];

    public function plan() : BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function subscription() : BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }
}
