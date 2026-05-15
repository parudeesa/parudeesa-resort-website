<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventService extends Model
{
    protected $fillable = ['name', 'price', 'icon', 'description', 'status'];

    protected $casts = [
        'price' => 'decimal:2',
        'status' => 'boolean',
    ];
}
