<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventPackage extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'pricing_type',
        'status',
    ];
}
