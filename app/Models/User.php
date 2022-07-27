<?php

namespace App\Models;

use App\Interfaces\MustVerifyPhone as PhoneVerification;
use App\Traits\MustVerifyPhone;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends Authenticatable implements PhoneVerification, HasMedia
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use MustVerifyPhone;
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'role',
        'phone',
        'email',
        'contact_name',
        'organization_type',
        'incorporation_date',
        'alternate_phone',
        'gst_number',
        'sales_turnover',
        'employees_count',
        'referrer_id',
        'password'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $casts = [
        'phone_verified_at' => 'datetime',
        'email_verified_at' => 'datetime',
        'incorporation_date' => 'date:Y-m-d',
        'gst_number_verified_at' => 'datetime',
//        'employees_count' => 'integer',
        'active' => 'boolean',
    ];

    protected $appends = [
        'profile_photo_url',
    ];

    protected $attributes = [
        'role' => 'customer',
        'employees_count' => null
    ];

    public function scopeSearch($query, $val, $columns = ['name', 'email', 'phone', 'referral_code'])
    {
        foreach ($columns as $i => $column) {
            if ($i < 1)
                $query->where($column, 'like', '%' . $val . '%');
            else
                $query->orWhere($column, 'like', '%' . $val . '%');
        }
        $query->orWhereHas('manufacturing_unit', function ($q) use ($val) {
            $q->where('pincode', $val);
        });
        return $query;
    }

    public function referrer() : BelongsTo
    {
        return $this->belongsTo(self::class, 'referrer_id');
    }

    public function referrals() : HasMany
    {
        return $this->hasMany(self::class, 'referrer_id');
    }

    public function machines() : BelongsToMany
    {
        return $this->belongsToMany(Process::class, 'machine_user')->withTimestamps();
    }

    public function processes() : BelongsToMany
    {
        return $this->belongsToMany(Process::class)->withTimestamps();
    }

    public function manufacturing_units() : HasMany
    {
        return $this->hasMany(ManufacturingUnit::class);
    }

    public function manufacturing_unit() : HasOne
    {
        return $this->hasOne(ManufacturingUnit::class)->latestOfMany();
    }

    public function manufacturing_unit2() : ?HasOne
    {
        return $this->manufacturing_units()->count() > 1 ?
            $this->hasOne(ManufacturingUnit::class)->oldestOfMany() :
            $this->hasOne(ManufacturingUnit::class)->whereNull('id')->oldestOfMany();
    }

    public function bids() : HasMany
    {
        return $this->hasMany(Bid::class);
    }

    public function projects() : HasMany
    {
        return $this->hasMany(Project::class);
    }

    public function eligible_projects() : BelongsToMany
    {
        return $this->belongsToMany(Project::class)->withTimestamps()
            ->where('publish_at', '<', now());
    }

    public function subscriptions() : HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function subscription() : HasOne
    {
        return $this->hasOne(Subscription::class)->where('ends_at', '>', now())->latestOfMany();
    }

    public function getAvgRatingAttribute()
    {
        $user_id = $this->id;
        return number_format(BidReview::query()->whereHas('bid', function ($query) use ($user_id) {
            $query->where('user_id', $user_id);
        })->average('rating'), "1");
    }

    public function sendPhoneVerificationNotification()
    {
        $otp = OneTimePassword::create([
            'phone' => $this->getPhoneForVerification()
        ]);

        return $otp->send() ? $otp : false;
    }

    public function enableToEligibleProjects()
    {
        $mu = $this->manufacturing_unit;
        if (in_array($this->role, ['supplier', 'both']) && $mu && $mu->latitude && $mu->longitude) {
            $machine_ids = $this->machines()->pluck('process_id')->toArray();
            $process_ids = $this->processes()->pluck('process_id')->toArray();
            $operation_type_ids = array_merge($machine_ids, $process_ids);
            $projects = Project::query()
                ->select('id', 'location_preference')
                ->where('user_id', '<>', $this->id)
                ->where('close_at', '>', now()->format('Y-m-d H:i:s'))
                ->whereHas('transaction', function ($query) {
                    $query->whereNotNull('paid_at');
                })
                ->whereHas('processes', function ($q) use ($operation_type_ids) {
                    $q->whereIn('process_id', $operation_type_ids);
                })
                ->whereHas('manufacturing_unit', function ($query) use ($mu) {
                    $query->select('id')->distance($mu->toArray())
                        ->havingRaw('distance < projects.location_preference');
                })
                ->get();
            $this->eligible_projects()->saveMany($projects);
        }
    }

    public function routeNotificationForSms()
    {
        return $this->phone;
    }
}
