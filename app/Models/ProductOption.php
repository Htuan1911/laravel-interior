<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOption extends Model
{
//     protected $fillable = ['product_id', 'name', 'status'];

//     public function values()
//     {
//         return $this->hasMany(ProductOptionValue::class);
//     }
//     public function category()
// {
//     return $this->belongsTo(Category::class);
// }
public function values()
{
    return $this->hasMany(ProductOptionValue::class);

  

}
}
