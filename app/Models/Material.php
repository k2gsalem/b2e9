<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'title',
        'price',
        'old_price',
        'density'
    ];

    protected $casts = [
        'price' => 'double',
        'old_price' => 'double',
        'density' => 'double'
    ];
}
