<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = [
        'type',
        'url',
        'title',
        'category',
        'layout',
        'sort_order',
    ];
}
