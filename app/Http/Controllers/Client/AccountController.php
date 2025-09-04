<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Wishlist;
use App\Models\Coupon;
use Illuminate\Support\Facades\Storage;

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
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255',
            'phone'    => 'nullable|string|max:20',
            'province' => 'nullable|string|max:100',
            'district' => 'nullable|string|max:100',
            'avatar'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = auth()->user();
        $user->name     = $request->name;
        $user->email    = $request->email;
        $user->phone    = $request->phone;
        $user->province = $request->province;
        $user->district = $request->district;

        // ✅ Upload avatar nếu có
        if ($request->hasFile('avatar')) {
            // Xoá ảnh cũ nếu có
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        $user->save();

        return redirect()->back()->with('success', 'Cập nhật thông tin thành công.');
    }

    /**
     * Lịch sử đơn hàng.
     */
    public function orders()
    {
        $orders = Auth::user()->orders()->latest()->get();
        return view('client.account.orders', compact('orders'));
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
        $wishlists = Wishlist::where('user_id', auth()->id())
            ->with(['product.variants'])
            ->get();

        return view('client.account.wishlist', compact('wishlists'));
    }

    public function removeFromWishlist($id)
    {
        $item = Wishlist::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $item->delete();

        return back()->with('success', 'Đã xoá khỏi danh sách yêu thích.');
    }

    public function addToWishlist(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id']);

        Wishlist::firstOrCreate([
            'user_id'    => auth()->id(),
            'product_id' => $request->product_id,
        ]);

        return response()->json(['message' => 'Đã thêm vào danh sách yêu thích']);
    }
}
