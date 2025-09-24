<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Models\OrderStatusLog;

class UpdateOrderStatus extends Command
{
    /**
     * Tên command (dùng khi gọi artisan).
     */
    protected $signature = 'orders:update-status';

    /**
     * Mô tả command.
     */
    protected $description = 'Tự động cập nhật đơn hàng từ shipping sang completed sau 2 ngày';

    public function handle()
    {
        $orders = Order::where('status', 'shipping')
            // ->where('payment_status', 'paid')
            ->whereNotNull('shipping_at')
            ->where('shipping_at', '<=', now()->subDays(2)) // đã giao hàng ít nhất 2 ngày --subSeconds(10)-- subDays(2)
            ->get();

        foreach ($orders as $order) {
            $order->status = 'completed';
            $order->save();

            OrderStatusLog::create([
                'order_id'   => $order->id,
                'old_status' => 'shipping',
                'new_status' => 'completed',
                'changed_by' => null, // hệ thống tự động
                'changed_at' => now(),
                'note'       => 'Tự động cập nhật trạng thái sau 2 ngày giao hàng',
            ]);
        }

        $this->info("Đã cập nhật {$orders->count()} đơn hàng sang completed.");
    }
}
