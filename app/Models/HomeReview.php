<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeReview extends Model
{
    protected $fillable = ['name', 'text', 'stars', 'image', 'order', 'status'];
}
