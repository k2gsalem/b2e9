<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'title',
        'summary',
        'content',
        'publish_date',
        'image'
    ];

    protected $casts = [
        'publish_date' => 'date:Y-m-d'
    ];
}
