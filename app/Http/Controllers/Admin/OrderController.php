<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Coupon;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::withTrashed()->with('user')->get();
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
            'user_id' => 'required|exists:users,id',
            'shipping_name' => 'required|string|max:255',
            'shipping_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string|max:255',
            'total_amount' => 'required|numeric|min:0',
            'status' => 'required|string|max:50',
            'coupon_id' => 'nullable|exists:coupons,id',
        ]);

        // Tạo đơn hàng
        $order = Order::create([
            'user_id' => $request->user_id,
            'coupon_id' => $request->coupon_id,
            'shipping_name' => $request->shipping_name,
            'shipping_phone' => $request->shipping_phone,
            'shipping_address' => $request->shipping_address,
            'total_amount' => $request->total_amount,
            'status' => $request->status,
        ]);

        // ✅ Tăng lượt đã dùng của mã giảm giá nếu có áp dụng
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
        return view('admin.orders.show', compact('order'));
    }

    public function editStatus(Order $order)
    {
        return view('admin.orders.edit_status', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,shipped,completed,cancelled',
        ]);

        $order->status = $request->status;
        $order->save();

        return redirect()->route('admin.orders.index')->with('success', 'Cập nhật trạng thái thành công.');
    }

    public function destroy(Order $order)
    {
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
