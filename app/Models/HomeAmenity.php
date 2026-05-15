<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeAmenity extends Model
{
    protected $fillable = ['title', 'image', 'order', 'status'];
}
