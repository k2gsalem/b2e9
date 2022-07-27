<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Project extends BaseModel implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    public const STATUS_CHECKOUT = 'CHECKOUT';
    public const STATUS_SCHEDULED = 'SCHEDULED';
    public const STATUS_ONGOING = 'ONGOING';
    public const STATUS_CLOSED = 'CLOSED';
    public const STATUS_OPEN = 'OPEN';
    public const STATUS_BID = 'BID';
    public const STATUS_SELECTED = 'SELECTED';

    protected $fillable = [
        'user_id',
        'manufacturing_unit_id',
        'title',
        'part_name',
        'drawing_number',
        'delivery_date',
        'location_preference',
        'raw_material_price',
        'description',
        'publish_at',
        'close_at',
        'instant_publish'
    ];

    protected $casts = [
        'delivery_date' => 'date:Y-m-d',
        'location_preference' => 'double',
        'raw_material_price' => 'double',
        'publish_at' => 'datetime',
        'close_at' => 'datetime',
        'active' => 'boolean',
        'min_bid_value' => 'double',
        'curr_bid_value' => 'double',
        'selected_bid_value' => 'double',
        'instant_publish' => 'boolean'
    ];

    protected $appends = [
        'status',
        'txn_id',
        'supplier_status',
        'min_bid_value',
        'current_bid_value',
        'selected_bid_value',
        'valid_bids_count',
        'invoice_id'
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function manufacturing_unit() : BelongsTo
    {
        return $this->belongsTo(ManufacturingUnit::class);
    }

    public function bids() : HasMany
    {
        return $this->hasMany(Bid::class);
    }

    public function current_bid() : HasOne
    {
        $min_value = $this->min_bid_value;
        return $this->hasOne(Bid::class)
            ->ofMany(['amount' => 'min'], function ($query) use ($min_value) {
                $query->where('amount', '>=', $min_value);
            });
    }

    public function selected_bid() : HasOne
    {
        return $this->hasOne(Bid::class)->whereNotNull('approved_at');
    }

    public function processes() : BelongsToMany
    {
        return $this->belongsToMany(Process::class)->withTimestamps();
    }

    public function transactions() : HasMany
    {
        return $this->hasMany(ProjectTransaction::class);
    }

    public function transaction() : HasOne
    {
        return $this->hasOne(ProjectTransaction::class)->latestOfMany();
    }

    public function eligible_users() : BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function getStatusAttribute()
    {
        $status = self::STATUS_CHECKOUT;
        $txn = $this->transaction;
        if ($txn && !is_null($txn->paid_at)) {
            $status = self::STATUS_SCHEDULED;
            if ($this->publish_at <= now()->format('Y-m-d H:i:s')) {
                $status = self::STATUS_ONGOING;
                if ($this->close_at <= now()) {
                    $status = self::STATUS_CLOSED;
                }
            }
        }
        return $status;
    }

    public function getSupplierStatusAttribute()
    {
        $status = self::STATUS_CHECKOUT;
        $txn = $this->transaction;
        if ($txn && !is_null($txn->paid_at)) {
            $status = self::STATUS_SCHEDULED;
            if ($this->publish_at <= now()->format('Y-m-d H:i:s')) {
                $status = self::STATUS_OPEN;
                if (Carbon::parse($this->close_at)->addMinutes(-30) < now()) {
                    $status = self::STATUS_BID;
                    if ($this->close_at <= now()) {
                        $status = self::STATUS_CLOSED;

                    }
                }
            }
        }
        return $status;
    }

    public function getTxnIdAttribute()
    {
        return $this->transaction ? $this->transaction->uuid : '-';
    }

    public function getInvoiceIdAttribute()
    {
        return $this->transaction ? $this->transaction->invoice_id : '-';
    }

    public function getMinBidValueAttribute()
    {
        return $this->raw_material_price + ($this->raw_material_price * (config('settings.support_rfq_percentage', 3)/ 100));
    }

    public function getCurrentBidValueAttribute()
    {
        return $this->current_bid ? $this->current_bid->amount : null;
    }

    public function getSelectedBidValueAttribute()
    {
        return $this->selected_bid ? $this->selected_bid->amount : null;
    }

    public function getValidBidsCountAttribute()
    {
        $min_value = $this->min_bid_value;
        return $this->bids()->where('amount', '>=', $min_value)->count('id');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('attachements')
            ->acceptsMimeTypes(['image/jpg', 'image/jpeg', 'image/png', 'image/gif']);
    }

    public function enableToEligibleUsers()
    {
        $location_preference = $this->location_preference;
        $mu = $this->manufacturing_unit;
        $operation_type_ids = $this->processes()->pluck('process_id');
        if ($mu && $mu->latitude && $mu->longitude) {
            $users = User::query()
                ->select('id')
                ->whereKeyNot($this->user_id)
                ->whereIn('role', ['supplier', 'both'])
//                ->whereHas('processes', function ($q) use ($operation_type_ids) {
//                    $q->whereIn('user_id', $operation_type_ids);
//                })
                ->where(function ($query) use ($operation_type_ids) {
                    $query->whereHas('processes', function ($q) use ($operation_type_ids) {
                        $q->whereIn('process_id', $operation_type_ids);
                    })
                    ->orWhereHas('machines', function ($q) use ($operation_type_ids) {
                        $q->whereIn('process_id', $operation_type_ids);
                    });
                })
                ->whereHas('manufacturing_unit', function ($query) use ($mu, $location_preference) {
                    $query->select('id')->distance($mu->toArray())
                        ->having('distance', '<', $location_preference);
                })
                ->get();
            $this->eligible_users()->saveMany($users);
        }
    }

    public function scopeSearch($query, $val, $columns = ['title'])
    {
        if ($val) {
            $query->where(function ($q) use ($val, $columns) {
                $q->whereHas('transaction', function ($qq) use ($val) {
                    $qq->where('uuid', 'like', '%' . $val . '%');
                });
                foreach ($columns as $i => $column) {
                    $q->orWhere($column, 'like', '%' . $val . '%');
                }

                $q->orWhereHas('user', function ($qq) use ($val) {
                    $qq->where('name', 'like', '%' . $val . '%')->orWhere('phone', 'like', '%' . $val . '%');
                });
            });
        }
        return $query;
    }
}
