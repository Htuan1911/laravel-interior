<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Coupon;
use App\Models\Payment;
use App\Models\OrderStatusLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        // Gọi command tự động cập nhật trạng thái đơn hàng
        Artisan::call('orders:auto-update-status');

        $orders = Order::withTrashed()
            ->with(['user', 'payment', 'statusLogs'])
            ->get();

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

        if (in_array($order->status, $finalStatuses) && optional($order->payment)->status === 'đã thanh toán') {
            return redirect()->route('admin.orders.index')
                ->with('error', 'Đơn hàng đã được thanh toán và đang ở trạng thái cuối, không thể chỉnh sửa.');
        }

        return view('admin.orders.edit_status', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $order->load('payment');

        $latestStatus = $order->statusLogs()->latest()->value('new_status') ?? $order->status;

        $finalStatuses = ['completed', 'cancelled'];

        if (in_array($latestStatus, $finalStatuses) && optional($order->payment)->status === 'paid') {
            return redirect()->route('admin.orders.index')
                ->with('error', 'Không thể cập nhật trạng thái vì đơn hàng đã thanh toán và ở trạng thái cuối.');
        }

        $request->validate([
            'status' => 'required|in:pending,confirmed,shipping,completed,cancelled',
        ]);

        $newStatus = $request->status;

        // Nếu trạng thái không đổi, bỏ qua
        if ($latestStatus === $newStatus) {
            return redirect()->route('admin.orders.index')->with('info', 'Trạng thái không thay đổi.');
        }

        // ❗ NGĂN cập nhật sang completed nếu chưa thanh toán
        if ($newStatus === 'completed') {
            $paymentStatus = strtolower($order->payment?->status ?? 'unpaid');

            if (!in_array($paymentStatus, ['paid', 'success'])) {
                return redirect()->route('admin.orders.index')
                    ->with('error', 'Không thể hoàn tất đơn hàng khi chưa thanh toán.');
            }
        }

        // Ghi vào bảng logs
        OrderStatusLog::create([
            'order_id'   => $order->id,
            'old_status' => $latestStatus,
            'new_status' => $newStatus,
            'changed_by' => Auth::id(),
            'changed_at' => now(),
        ]);

        // Nếu muốn cập nhật cột `status` của bảng orders, có thể:
        $order->update(['status' => $newStatus]); // Chỉ để hiển thị nhanh hơn (optional)

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
