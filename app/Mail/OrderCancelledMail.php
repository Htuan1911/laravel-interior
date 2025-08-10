<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderCancelledMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $cancelReason;

    public function __construct(Order $order, $cancelReason)
    {
        $this->order = $order;
        $this->cancelReason = $cancelReason;
    }
    public function build()
    {
        return $this->subject('Thông báo hủy đơn hàng #' . $this->order->id)
            ->view('emails.order_cancelled')
            ->with([
                'order'        => $this->order,
                'cancelReason' => $this->cancelReason
            ]);
    }
}
