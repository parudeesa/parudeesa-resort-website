<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodPackage extends Model
{
    protected $fillable = ['name', 'price', 'description', 'status'];

    protected $casts = [
        'price' => 'decimal:2',
        'status' => 'boolean',
    ];
}
