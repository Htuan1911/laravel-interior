<?php
namespace App\Observers;

use App\Models\Payment;
use Illuminate\Support\Facades\Log;

class PaymentObserver
{
    public function updated(Payment $payment)
    {
        if ($payment->isDirty('status') && $payment->status === 'paid') {
            $order = $payment->order;

            if ($order && $order->status === 'pending') {
                // Ghi log thay đổi trạng thái nếu có bảng logs
                $order->statusLogs()->create([
                    'old_status' => $order->status,
                    'new_status' => 'paid',
                    'changed_by' => auth()->id() ?? null,
                    'changed_at' => now()
                ]);

                // Cập nhật trạng thái đơn hàng
                $order->status = 'paid';
                $order->save();
            }
        }
    }
}
