<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlanBenefit extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'plan_id',
        'title'
    ];

    public function plan() : BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }
}
