<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventGallery extends Model
{
    protected $fillable = ['image', 'category', 'order', 'is_featured', 'status'];
}
