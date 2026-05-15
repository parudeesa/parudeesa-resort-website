<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventCard extends Model
{
    protected $fillable = ['title', 'icon', 'image', 'order', 'status'];
}
