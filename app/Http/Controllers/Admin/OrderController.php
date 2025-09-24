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
        // Kiểm tra quyền truy cập
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

        $latestStatus   = strtolower($order->status ?? 'pending');
        $paymentStatus  = strtolower(optional($order->payment)->status ?? 'unpaid');

        // Nếu đơn hàng đã hoàn tất hoặc hủy → chặn
        if (in_array($latestStatus, ['completed', 'cancelled'])) {
            return redirect()->route('admin.orders.index')
                ->with('error', 'Đơn hàng đã kết thúc (hoàn tất hoặc hủy), không thể chỉnh sửa.');
        }

        // Nếu thanh toán thất bại hoặc chưa thanh toán → chặn
        // if (in_array($paymentStatus, ['failed', 'unpaid'])) {
        //     return redirect()->route('admin.orders.index')
        //         ->with('error', 'Chỉ có thể cập nhật trạng thái khi đơn hàng đã được thanh toán thành công.');
        // }

        // Các trạng thái thanh toán được phép (hiện tại chỉ cho sửa khi đã thanh toán)
        $paymentStatuses = ['paid', 'success'];

        // Xác định có khóa sửa thanh toán không (bổ sung cho view nếu cần)
        $isPaymentLocked = (
            (
                in_array($latestStatus, ['shipping', 'completed']) &&
                in_array($paymentStatus, ['paid', 'success'])
            )
        );

        return view('admin.orders.edit_status', compact('order', 'paymentStatuses', 'isPaymentLocked'));
    }


    public function updateStatus(Request $request, Order $order)
    {
        $order->load(['payment', 'user']);

        $latestStatus   = $order->statusLogs()->latest()->value('new_status') ?? $order->status;
        $finalStatuses  = ['completed', 'cancelled'];
        $paymentStatus  = strtolower(optional($order->payment)->status ?? 'unpaid');
        $paymentMethod  = strtolower(optional($order->payment)->method ?? '');

        // 🚫 Chặn luôn nếu thanh toán chưa thành công (failed hoặc unpaid)
        if ($paymentMethod != 'cod' && in_array($paymentStatus, ['failed', 'unpaid'])) {
            return redirect()->route('admin.orders.index')
                ->with('error', 'Không thể cập nhật vì đơn hàng chưa được thanh toán thành công.');
        }

        // 1. Chặn update nếu đơn ở trạng thái cuối & đã thanh toán
        if (in_array($latestStatus, $finalStatuses) && in_array($paymentStatus, ['paid', 'success'])) {
            return redirect()->route('admin.orders.index')
                ->with('error', 'Không thể cập nhật trạng thái vì đơn hàng đã thanh toán và ở trạng thái cuối.');
        }

        // 2. Validate dữ liệu gửi lên
        $request->validate([
            'status'         => 'required|in:pending,confirmed,shipping,completed,cancelled',
            'payment_status' => 'nullable|in:unpaid,paid'
        ]);

        $newStatus = $request->status;

        // 🚫 2.1. Chặn TH Admin chọn "cancelled" và đồng thời "payment_status = paid"
        if ($newStatus === 'cancelled' && $request->payment_status === 'paid') {
            return redirect()->route('admin.orders.index')
                ->with('error', 'Không thể vừa hủy đơn vừa để trạng thái thanh toán là Đã thanh toán.');
        }

        // 3. Không thay đổi nếu status và payment_status đều không đổi
        if ($latestStatus === $newStatus && !$request->filled('payment_status')) {
            return redirect()->route('admin.orders.index')->with('info', 'Không có thay đổi nào.');
        }

        // 4. Không cho lùi trạng thái trừ khi hủy
        $statusOrder = [
            'pending'   => 1,
            'confirmed' => 2,
            'shipping'  => 3,
            'completed' => 4,
            'cancelled' => 99
        ];
        if (
            isset($statusOrder[$latestStatus], $statusOrder[$newStatus]) &&
            $statusOrder[$newStatus] < $statusOrder[$latestStatus] &&
            $newStatus !== 'cancelled'
        ) {
            return redirect()->route('admin.orders.index')
                ->with('error', 'Không thể chuyển trạng thái lùi lại!');
        }

        // 5. Không cho nhảy quá 1 bước (trừ khi hủy)
        if (
            isset($statusOrder[$latestStatus], $statusOrder[$newStatus]) &&
            $statusOrder[$newStatus] > $statusOrder[$latestStatus] + 1 &&
            $newStatus !== 'cancelled'
        ) {
            return redirect()->route('admin.orders.index')
                ->with('error', 'Bạn phải cập nhật trạng thái đơn hàng theo tuần tự không được bỏ qua bước nào.');
        }

        // 6. Chặn Admin set trực tiếp completed
        if ($newStatus === 'completed') {
            return redirect()->route('admin.orders.index')
                ->with('error', 'Đơn hàng chỉ được chuyển sang trạng thái "Hoàn tất" khi khách đã xác nhận nhận hàng thành công.');
        }

        // 7. Xử lý hủy đơn
        $cancelReason = null;
        if ($newStatus === 'cancelled') {

            // Chặn nếu đơn đã thanh toán (mọi phương thức)
            if (in_array($paymentStatus, ['paid', 'success'])) {
                return redirect()->route('admin.orders.index')
                    ->with('error', 'Không thể hủy đơn hàng đã được thanh toán.');
            }

            $request->validate([
                'cancel_reason' => 'required|string|max:255'
            ]);

            $cancelReason = $request->cancel_reason;
            $order->cancel_reason = $cancelReason;

            $recipientEmail = $order->customer_email ?? $order->user?->email;
            if (!empty($recipientEmail)) {
                Mail::to($recipientEmail)->send(new OrderCancelledMail($order, $cancelReason));
            }
        }

        // 8. Xử lý trạng thái thanh toán (COD & chưa success)
        if (
            $order->payment &&
            $request->filled('payment_status') &&
            $paymentMethod === 'cod' &&
            $paymentStatus !== 'success'
        ) {
            $requested = strtolower($request->payment_status);
            $order->payment->status = $requested === 'paid' ? 'paid' : 'unpaid';
            $order->payment->save();
        }

        // 9. Ghi log trạng thái
        OrderStatusLog::create([
            'order_id'    => $order->id,
            'old_status'  => $latestStatus,
            'new_status'  => $newStatus,
            'changed_by'  => Auth::id(),
            'changed_at'  => now(),
            'note'        => $cancelReason,
        ]);

        // 10. Cập nhật đơn hàng
        $order->status = $newStatus;

        // 👉 Nếu chuyển sang shipping thì lưu lại thời gian bắt đầu giao hàng
        if ($newStatus === 'shipping' && !$order->shipping_at) {
            $order->shipping_at = now();
        }

        // 👉 Nếu đơn hàng hoàn tất => ép thanh toán luôn là 'paid'
        if ($newStatus === 'completed') {
            if ($order->payment) {
                $order->payment->status = 'paid';
                $order->payment->save();
            } else {
                Payment::create([
                    'order_id' => $order->id,
                    'method'   => 'unknown',
                    'status'   => 'paid',
                ]);
            }
        }

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
