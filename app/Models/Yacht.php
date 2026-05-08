<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Yacht extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'duration',
        'capacity',
        'image_url',
        'gallery',
        'status',
    ];

    protected $casts = [
        'gallery' => 'array',
        'status' => 'boolean',
    ];
}
