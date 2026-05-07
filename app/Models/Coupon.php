<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = ['code', 'type', 'value', 'is_active'];

    public function calculateDiscount($total)
    {
        if ($this->type === 'percentage') {
            return ($total * $this->value) / 100;
        }

        return min($this->value, $total);
    }
}
