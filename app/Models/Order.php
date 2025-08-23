<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'coupon_id',
        'shipping_name',
        'shipping_phone',
        'shipping_address',
        'total_amount',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function statusLogs()
    {
        return $this->hasMany(OrderStatusLog::class);
    }
    public function latestStatus()
    {
        return $this->statusLogs()->latest('changed_at')->first()?->new_status ?? $this->status;
    }
    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'pending' => 'Chờ xử lý',
            'confirmed' => 'Đã xác nhận',
            'shipping'  => 'Đang giao hàng',
            'completed' => 'Hoàn tất',
            'cancelled' => 'Đã hủy',
            'paid' => 'đã thanh toán',
            'refunded' => 'Đã hoàn tiền',
            default => 'Không xác định',
        };
    }
}
