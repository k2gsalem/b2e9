<?php

namespace App\Models;

use App\Traits\HasImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Process extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'title',
        'hourly_price',
        'description',
        'wikipedia',
        'image',
        'active'
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function users() : BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function projects() : BelongsToMany
    {
        return $this->belongsToMany(Project::class)->withTimestamps();
    }
}
