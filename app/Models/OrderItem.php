<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'variant_id',
        'quantity',
        'unit_price',
        'total_price',
        'variant_name',
        'base_price_snapshot',
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
