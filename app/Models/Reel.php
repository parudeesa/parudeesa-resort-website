<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reel extends Model
{
    protected $fillable = [
        'title',
        'thumbnail',
        'video',
        'instagram_url',
        'description',
        'order',
        'is_active'
    ];
}
