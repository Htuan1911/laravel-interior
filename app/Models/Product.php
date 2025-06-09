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
}
