<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductOption extends Model
{

     use SoftDeletes;

    protected $table = 'product_options';

    protected $dates = ['deleted_at']; 
    protected $casts = [
        'deleted_at' => 'datetime',
];
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
