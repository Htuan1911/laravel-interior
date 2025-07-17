<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_id',
        'base_price',
        'status',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function translations()
    {
        return $this->hasMany(ProductTranslation::class);
    }



////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// public function reviews()
// {
//     return $this->hasManyThrough(
//         \App\Models\Review::class,
//         \App\Models\OrderItem::class,
//         'product_id',     // FK trong order_items → products
//         'order_item_id',  // FK trong reviews → order_items
//         'id',             // khóa chính trong products
//         'id'              // khóa chính trong order_items
//     );
// }


}
