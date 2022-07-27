<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectTransaction extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'package_id',
        'bids',
        'base_amount',
        'gst_amount',
        'final_amount',
        'mode',
        'paid_at',
        'invoice_id',
    ];

    protected $casts = [
        'bids' => 'integer',
        'base_amount' => 'double',
        'gst_amount' => 'double',
        'final_amount' => 'double',
        'paid_at' => 'datetime',
        'invoice_id' => 'integer',
    ];

    public function scopeSearch($query, $val, $columns = ['uuid'])
    {
        if ($val) {
            $query->where(function ($q) use ($val, $columns) {
                foreach ($columns as $i => $column) {
                    if ($i < 1)
                        $q->where($column, 'like', '%' . $val . '%');
                    else
                        $q->orWhere($column, 'like', '%' . $val . '%');
                }
                $q->orWhereHas('project', function ($qq) use ($val) {
                    $qq->where('title', 'like', '%' . $val . '%');
                });
            })->orWhere('invoice_id', $val);
        }
        return $query;
    }

    public function project() : BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
