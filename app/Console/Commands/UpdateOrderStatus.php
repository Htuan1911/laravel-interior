<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use Carbon\Carbon;

class UpdateOrderStatus extends Command
{
    protected $signature = 'orders:auto-update-status';
    protected $description = 'Tự động cập nhật trạng thái đơn hàng sau khi đã thanh toán';

    public function handle()
    {
        $orders = Order::with('payment')
            ->where('status', 'paid')
            ->get();

        foreach ($orders as $order) {
            if (
                $order->payment &&
                strtolower($order->payment->status) === 'đã thanh toán'
            ) {
                // Kiểm tra nếu đơn hàng đã có log trạng thái shipped
                $hasShipped = $order->statusLogs()->where('new_status', 'shipped')->exists();
                $hasCompleted = $order->statusLogs()->where('new_status', 'completed')->exists();

                if (!$hasShipped) {
                    $this->updateStatus($order, 'shipped');
                } elseif (!$hasCompleted) {
                    $this->updateStatus($order, 'completed');
                }
            }
        }

        $this->info('Tự động cập nhật trạng thái đơn hàng hoàn tất.');
    }

    private function updateStatus($order, $newStatus)
    {
        $oldStatus = $order->status;
        $order->status = $newStatus;
        $order->save();

        $order->statusLogs()->create([
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'changed_by' => null, // hệ thống tự thay đổi
            'changed_at' => now(),
        ]);

        $this->info("Đơn hàng #{$order->id} cập nhật từ [$oldStatus] → [$newStatus]");
        $this->info("Đang xử lý đơn hàng #{$order->id} - payment = {$order->payment->status}");

    }
}
