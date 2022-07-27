<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;

class Bid extends BaseModel
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'project_id',
        'user_id',
        'subscription_id',
        'manufacturing_unit_id',
        'amount',
        'edit_count',
        'edit_history'
    ];

    protected $casts = [
        'amount' => 'double',
        'approved_at' => 'datetime',
        'edit_count' => 'integer',
        'edit_history' => 'array'
    ];

    public function scopeApproved(Builder $query)
    {
        return $query->whereNotNull('approved_at');
    }

    public function scopeValid(Builder $query)
    {
        return $query->where('valid',1);
    }

    public function project() : BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function subscription() : BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }

    public function manufacturing_unit() : BelongsTo
    {
        return $this->belongsTo(ManufacturingUnit::class);
    }

    public function reviews() : HasMany
    {
        return $this->hasMany(BidReview::class);
    }

    public function review() : HasOne
    {
        return $this->hasOne(BidReview::class)->latestOfMany();
    }
}
