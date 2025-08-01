<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Models\OrderStatusLog;
use Carbon\Carbon;

class UpdateOrderStatus extends Command
{
    protected $signature = 'orders:auto-update-status';
    protected $description = 'Tự động cập nhật trạng thái đơn hàng sau khi đã thanh toán';

    public function handle()
    {
        $orders = Order::with(['statusLogs', 'payment'])->get();

        foreach ($orders as $order) {
            $currentStatus = strtolower($order->latestStatus());
            $paymentStatus = strtolower($order->payment?->status ?? 'unpaid');

            if (!in_array($paymentStatus, ['paid', 'success'])) {
                continue;
            }

            $lastLog = $order->statusLogs->last();

            // 👇 Đây là cách xử lý không cần sửa model hay DB
            $lastChangedAt = Carbon::parse($lastLog?->changed_at ?? $order->updated_at);

            if ($currentStatus === 'confirmed' && $lastChangedAt->diffInSeconds(now()) >= 15) {
                $this->updateStatus($order, 'shipping');
            } elseif ($currentStatus === 'shipping' && $lastChangedAt->diffInSeconds(now()) >= 15) {
                $this->updateStatus($order, 'completed');
            }
        }
    }

    private function updateStatus($order, $newStatus)
    {
        $oldStatus = $order->status;
        $order->status = $newStatus;
        $order->save();

        $order->statusLogs()->create([
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'changed_by' => null,
            'changed_at' => now(),
        ]);

        $this->info("Đơn hàng #{$order->id} cập nhật từ [$oldStatus] → [$newStatus]");
    }
}
