<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['product_id', 'name', 'content'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

