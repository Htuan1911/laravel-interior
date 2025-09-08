<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role_id',
        'status',
        'otp', // Mã OTP
        'otp_expires_at', // Thời gian hết hạn của mã OTP
        'is_verified',
        'province',      // Tỉnh/Thành phố
        'district',      // Quận/Huyện
        'avatar',        // Ảnh đại diện
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'otp_expires_at' => 'datetime',
        'is_verified' => 'boolean',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function cart()
    {
        return $this->hasOne(Cart::class); // giả sử mỗi user có 1 giỏ hàng
    }

    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }
}
