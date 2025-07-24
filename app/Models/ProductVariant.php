<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// class ProductVariant extends Model
// {
//     use HasFactory;

//     protected $fillable = [
//         'product_id',
//         'variant_name',
//         'price',
//         'stock'
//     ];

//     public function product()
//     {
//         return $this->belongsTo(Product::class);
//     }
// }
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id',
        'sku',
        'size',
        'material',
        'price',
        'stock',
        'status',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

public function orderItems()
{
    return $this->hasMany(OrderItem::class, 'variant_id');
}

public function reviews()
{
    return $this->hasManyThrough(
        \App\Models\Review::class,        // model cuối cùng
        \App\Models\OrderItem::class,     // model trung gian
        'variant_id',                     // khóa ngoại trên order_items
        'order_item_id',                  // khóa ngoại trên reviews
        'id',                             // khóa chính của ProductVariant
        'id'                              // khóa chính của OrderItem
    );
}



}


