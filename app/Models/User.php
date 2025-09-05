<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
<<<<<<< HEAD
use Illuminate\Notifications\Notifiable;
=======
>>>>>>> e7d7fb77dac056b19220de991d5e9c7691aec008
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
<<<<<<< HEAD
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
=======
    use HasFactory, SoftDeletes;

>>>>>>> e7d7fb77dac056b19220de991d5e9c7691aec008
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role_id',
        'status',
<<<<<<< HEAD
        'otp',             // Mã OTP
        'otp_expires_at',  // Thời gian hết hạn OTP
        'is_verified',
        'province',        // Tỉnh/Thành phố
        'district',        // Quận/Huyện
        'avatar',          // Ảnh đại diện
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
=======
        'otp', // Mã OTP
        'otp_expires_at', // Thời gian hết hạn của mã OTP
        'is_verified',
        'province',      // Tỉnh/Thành phố
        'district',      // Quận/Huyện
        'avatar',        // Ảnh đại diện
    ];

>>>>>>> e7d7fb77dac056b19220de991d5e9c7691aec008
    protected $hidden = [
        'password',
        'remember_token',
    ];

<<<<<<< HEAD
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'otp_expires_at'    => 'datetime',
        'is_verified'       => 'boolean',
        'password'          => 'hashed',
    ];

    // Relationships
=======
    protected $casts = [
        'email_verified_at' => 'datetime',
        'otp_expires_at' => 'datetime',
        'is_verified' => 'boolean',
    ];

>>>>>>> e7d7fb77dac056b19220de991d5e9c7691aec008
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
