<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Wishlist;
use App\Models\Product;

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
     * Danh sách sản phẩm yêu thích.
     */
    public function wishlist()
    {
        $wishlists = Wishlist::where('user_id', auth()->id())
            ->with(['product.variants']) // Load cả sản phẩm và biến thể
            ->get();

        return view('client.account.wishlist', compact('wishlists'));
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

    /**
     * Thêm hoặc xóa sản phẩm khỏi danh sách yêu thích (AJAX).
     */
    public function addToWishlist(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id']);

        Wishlist::firstOrCreate([
            'user_id' => auth()->id(),
            'product_id' => $request->product_id,
        ]);

        return response()->json(['message' => 'Đã thêm vào danh sách yêu thích']);
    }
}
