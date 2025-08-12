<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Coupon;
use App\Models\Payment;
use App\Models\OrderStatusLog;
use App\Mail\OrderCancelledMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;


class OrderController extends Controller
{
    public function index(Request $request)
    {
        // Gọi command tự động cập nhật trạng thái đơn hàng
        Artisan::call('orders:auto-update-status');

        $query = Order::withTrashed()
            ->with(['user', 'payment', 'statusLogs'])
            ->orderBy('created_at', 'desc');

        // Filter theo ID đơn hàng
        if ($request->filled('order_id')) {
            $query->where('id', $request->order_id);
        }

        // Filter theo tên người dùng (quan hệ user)
        if ($request->filled('user_name')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->user_name . '%');
            });
        }

        // Filter theo số điện thoại
        if ($request->filled('phone')) {
            $query->where('shipping_phone', 'like', '%' . $request->phone . '%');
        }

        // Filter theo trạng thái đơn hàng (status chính trong bảng orders)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    public function create()
    {
        $users = User::all();
        $coupons = Coupon::all();
        return view('admin.orders.create', compact('users', 'coupons'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id'          => 'required|exists:users,id',
            'shipping_name'    => 'required|string|max:255',
            'shipping_phone'   => 'required|string|max:20',
            'shipping_address' => 'required|string|max:255',
            'total_amount'     => 'required|numeric|min:0',
            'coupon_id'        => 'nullable|exists:coupons,id',
        ]);

        $order = Order::create([
            'user_id'          => $request->user_id,
            'coupon_id'        => $request->coupon_id,
            'shipping_name'    => $request->shipping_name,
            'shipping_phone'   => $request->shipping_phone,
            'shipping_address' => $request->shipping_address,
            'total_amount'     => $request->total_amount,
            'status'           => 'pending', // ✅ Luôn khởi tạo là 'pending'
            'payment_status'   => 'unpaid',  // ✅ Nếu chưa thanh toán
        ]);

        // ✅ Ghi log trạng thái đầu tiên vào order_status_logs

        OrderStatusLog::create([
            'order_id'   => $order->id,
            'old_status'  => 'pending',
            'new_status' => 'pending',
            'changed_by' => Auth::id(),
            'changed_at' => now(),
        ]);

        // Nếu có coupon, tăng lượt sử dụng
        if ($request->coupon_id) {
            $coupon = Coupon::find($request->coupon_id);
            if ($coupon) {
                $coupon->increment('used_count');
            }
        }

        return redirect()->route('admin.orders.index')->with('success', 'Tạo đơn hàng thành công.');
    }

    public function show(Order $order)
    {
        $order->load('payment');
        return view('admin.orders.show', compact('order'));
    }

    public function editStatus(Order $order)
    {
        $order->load('payment');

        $finalStatuses = ['completed'];
        $paymentStatuses = ['unpaid', 'paid']; // hoặc lấy từ config

        // Nếu đơn hàng đã hoàn tất & thanh toán xong thì chặn
        if (in_array($order->status, $finalStatuses) && optional($order->payment)->status === 'đã thanh toán') {
            return redirect()->route('admin.orders.index')
                ->with('error', 'Đơn hàng đã được thanh toán và đang ở trạng thái cuối, không thể chỉnh sửa.');
        }

        // Xác định trạng thái khóa sửa thanh toán (dùng logic giống bên payments.edit)
        $latestStatus   = strtolower($order->status ?? 'pending');
        $paymentStatus  = strtolower(optional($order->payment)->status ?? 'unpaid');
        $isPaymentLocked = (
            (
                in_array($latestStatus, ['paid', 'shipped', 'completed']) &&
                in_array($paymentStatus, ['paid', 'success'])
            )
            || $latestStatus === 'cancelled'
        );

        return view('admin.orders.edit_status', compact('order', 'paymentStatuses', 'isPaymentLocked'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $order->load(['payment', 'user']);

        $latestStatus = $order->statusLogs()->latest()->value('new_status') ?? $order->status;
        $finalStatuses = ['completed', 'cancelled'];

        if (in_array($latestStatus, $finalStatuses) && in_array(optional($order->payment)->status, ['paid', 'success'])) {
            return redirect()->route('admin.orders.index')
                ->with('error', 'Không thể cập nhật trạng thái vì đơn hàng đã thanh toán và ở trạng thái cuối.');
        }

        $request->validate([
            'status' => 'required|in:pending,confirmed,shipping,completed,cancelled',
            'payment_status' => 'nullable|in:unpaid,paid'
        ]);

        $newStatus = $request->status;

        if ($latestStatus === $newStatus && !$request->filled('payment_status')) {
            return redirect()->route('admin.orders.index')->with('info', 'Không có thay đổi nào.');
        }

        $statusOrder = [
            'pending'   => 1,
            'confirmed' => 2,
            'shipping'  => 3,
            'completed' => 4,
            'cancelled' => 99
        ];

        // Không cho lùi trạng thái trừ khi hủy
        if (
            isset($statusOrder[$latestStatus], $statusOrder[$newStatus]) &&
            $statusOrder[$newStatus] < $statusOrder[$latestStatus] &&
            $newStatus !== 'cancelled'
        ) {
            return redirect()->route('admin.orders.index')
                ->with('error', 'Không thể chuyển trạng thái lùi lại!');
        }

        // Nếu set completed thì phải thanh toán xong
        if ($newStatus === 'completed') {
            $paymentStatus = strtolower($order->payment?->status ?? 'unpaid');
            if (!in_array($paymentStatus, ['paid', 'success'])) {
                return redirect()->route('admin.orders.index')
                    ->with('error', 'Không thể hoàn tất đơn hàng khi chưa thanh toán.');
            }
        }

        // Xử lý hủy đơn
        $cancelReason = null;
        if ($newStatus === 'cancelled') {
            $request->validate([
                'cancel_reason' => 'required|string|max:255'
            ]);

            $cancelReason = $request->cancel_reason;
            $order->cancel_reason = $cancelReason;

            $recipientEmail = $order->customer_email ?? $order->user?->email;
            if (!empty($recipientEmail)) {
                Mail::to($recipientEmail)
                    ->send(new OrderCancelledMail($order, $cancelReason));
            }
        }

        // --- Xử lý trạng thái thanh toán ---
        if ($order->payment && $request->filled('payment_status') && strtolower($order->payment->method) === 'cod') {
            $currentPayment = strtolower($order->payment->status);
            $requested = strtolower($request->payment_status);

            // Chặn đổi từ 'success' sang 'unpaid'
            if ($currentPayment === 'success' && $requested === 'unpaid') {
                // Bỏ qua
            } else {
                // Map từ form -> DB
                $order->payment->status = $requested === 'paid' ? 'success' : 'pending';
                $order->payment->save();

                // Nếu đổi thành đã thanh toán thì đơn hàng thành completed
                if (in_array($order->payment->status, ['success', 'paid'])) {
                    $order->status = 'completed'; // nhớ lưu lại order nữa
                    $order->save();
                }
            }
        }

        // Ghi log
        OrderStatusLog::create([
            'order_id'    => $order->id,
            'old_status'  => $latestStatus,
            'new_status'  => $newStatus,
            'changed_by'  => Auth::id(),
            'changed_at'  => now(),
            'note'        => $cancelReason,
        ]);

        $order->status = $newStatus;
        $order->save();

        return redirect()->route('admin.orders.index')->with('success', 'Cập nhật trạng thái thành công.');
    }



    public function destroy(Order $order)
    {
        $order->load('payment');

        // Nếu đơn hàng đã hoàn tất và thanh toán đã thanh toán, không cho xoá
        if ($order->status === 'completed' && optional($order->payment)->status === 'đã thanh toán') {
            return redirect()->route('admin.orders.index')
                ->with('error', 'Không thể xoá đơn hàng đã hoàn tất và đã thanh toán.');
        }

        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Xóa đơn hàng thành công.');
    }
    public function restore($id)
    {
        $order = Order::withTrashed()->findOrFail($id);
        $order->restore();

        return redirect()->route('admin.orders.index')->with('success', 'Khôi phục đơn hàng thành công.');
    }
}
