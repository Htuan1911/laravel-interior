<?php
// app/Models/OrderStatusLog.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderStatusLog extends Model
{
    protected $fillable = [
        'order_id',
        'old_status',
        'new_status',
        'changed_by',
        'changed_at'
    ];

    public $timestamps = true;

    protected $dates = ['changed_at'];
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
