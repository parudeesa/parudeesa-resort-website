<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventAmenity extends Model
{
    protected $fillable = ['title', 'description', 'icon', 'image', 'order', 'status'];
}
