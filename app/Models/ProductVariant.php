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
}


