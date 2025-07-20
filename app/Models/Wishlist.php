<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Product;

class Wishlist extends Model
{
    use HasFactory;
   protected $fillable = [
        'user_id',
        'product_id', // thêm các field khác nếu có
    ];
    // ✅ Đặt bên trong class
    public function user()
{
    return $this->belongsTo(\App\Models\User::class);
}

public function product()
{
    return $this->belongsTo(\App\Models\Product::class);
}

}
