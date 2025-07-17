<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\Wishlist;

class AccountController extends Controller
{
    /**
     * Hiển thị form cập nhật thông tin cá nhân.
     */
    public function info()
    {
        return view('client.account.info', [
            'user' => auth()->user()
        ]);
    }

    /**
     * Xử lý cập nhật thông tin cá nhân.
     */
    public function updateInfo(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $user = auth()->user();
        $user->name  = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->save();
        return redirect()->back()->with('success', 'Cập nhật thông tin thành công.');
    }

    /**
     * Lịch sử đơn hàng.
     */
    public function orders()
    {
        $orders = Auth::user()->orders()->latest()->get(); // lấy đơn hàng của user đang đăng nhập

        return view('client.account.orders', compact('orders')); // ✅ trả về view
    }

    /**
     * Danh sách mã giảm giá (voucher).
     */
    public function vouchers()
    {
        $coupons = Coupon::where('is_active', 1)
            ->where(function ($query) {
                $query->whereNull('expires_at')
                      ->orWhere('expires_at', '>', now());
            })
            ->orderBy('expires_at', 'asc')
            ->get();

        return view('client.account.vouchers', compact('coupons'));
    }



    /**
     * Danh sách sản phẩm yêu thích.
     */
    public function wishlist()
    {
        $wishlist = Auth::user()->wishlist()->with('product')->get();

        return view('client.account.wishlist', compact('wishlist'));
    }

    /**
     * Xoá sản phẩm khỏi danh sách yêu thích.
     */
    public function removeFromWishlist($id)
    {
        $item = Wishlist::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $item->delete();

        return back()->with('success', 'Đã xoá khỏi danh sách yêu thích.');
    }
}
