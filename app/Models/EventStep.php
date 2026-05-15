<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventStep extends Model
{
    protected $fillable = ['title', 'description', 'icon', 'step_number', 'order', 'status'];
}
