<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Subscription extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'plan_id',
        'amount',
        'fresh_bids',
        'additional_bids',
        'starts_at',
        'ends_at',
    ];

    protected $casts = [
        'amount' => 'double',
        'fresh_bids' => 'integer',
        'additional_bids' => 'integer',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'active' => 'boolean',
    ];

    protected $appends = [
        'used_fresh_bids',
        'used_additional_bids',
        'invoice_id'
    ];

    public function scopeSearch($query, $val, $columns = [])
    {
        if ($val) {
            $query->where(function ($q) use ($val, $columns) {
                $q->whereHas('user', function ($qq) use ($val) {
                    $qq->where('name', 'like', '%' . $val . '%')
                        ->orWhere('phone', 'like', '%' . $val . '%');
                })->orWhereHas('transaction', function ($qq) use ($val) {
                    $qq->where('invoice_id', $val);
                });
            });
        }
        return $query;
    }

    public function getUsedFreshBidsAttribute()
    {
        return $this->plan->type == Plan::TYPE_PREMIUM
            ? $this->bids()->whereNull('approved_at')->count()
            : $this->bids()->count();
    }

    public function getUsedAdditionalBidsAttribute()
    {
        return $this->bids()->sum('edit_count');
    }

    public function getInvoiceIdAttribute()
    {
        return $this->transaction ? $this->transaction->invoice_id : '-';
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function plan() : BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function bids() : HasMany
    {
        return $this->hasMany(Bid::class);
    }

    public function transactions() : HasMany
    {
        return $this->hasMany(PlanTransaction::class);
    }

    public function transaction() : HasOne
    {
        return $this->hasOne(PlanTransaction::class)->latestOfMany();
    }
}
