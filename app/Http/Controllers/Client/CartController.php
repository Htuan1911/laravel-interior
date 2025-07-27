<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $cart = Cart::with(['items.variant.product'])->where('user_id', $user->id)->first();

         $cartItems = $user->cartItems()->with('variant.product')->get();

        return view('client.carts.index', compact('cart', 'cartItems'));
    }

    public function add(Request $request)
    {

        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để thêm vào giỏ hàng.');
        }
        $user = auth()->user();
        $variantId = $request->variant_id;
        $quantity = max(1, (int) $request->quantity); // đảm bảo >= 1

        $variant = ProductVariant::findOrFail($variantId);

        // Kiểm tra tồn kho
        if ($variant->stock_quantity < $quantity) {
            return redirect()->back()->with('error', 'Sản phẩm không đủ tồn kho.');
        }

        // Tìm hoặc tạo giỏ hàng
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);

        // Tìm sản phẩm đã có trong giỏ
        $item = CartItem::where('cart_id', $cart->id)
            ->where('variant_id', $variantId)
            ->first();

        if ($item) {
            // Cộng thêm số lượng
            $item->quantity += $quantity;
            $item->save();
        } else {
            // Thêm mới
            CartItem::create([
                'cart_id' => $cart->id,
                'variant_id' => $variantId,
                'quantity' => $quantity,
            ]);
        }
        // ✅ Cập nhật số lượng sản phẩm trong giỏ vào session
        session(['cart_count' => $cart->items->sum('quantity')]);

        return redirect()->route('client.carts.index')->with('success', 'Đã thêm vào giỏ hàng!');
    }

    public function increaseQuantity($id)
    {
        $item = CartItem::findOrFail($id);
        $item->quantity += 1;
        $item->save();

        return back();
    }

    public function decreaseQuantity($id)
    {
        $item = CartItem::findOrFail($id);
        if ($item->quantity > 1) {
            $item->quantity -= 1;
            $item->save();
        } else {
            $item->delete();
        }

        return back();
    }

    public function removeItem($id)
    {
        $item = CartItem::findOrFail($id);
        $item->delete();

        return back();
    }
}
