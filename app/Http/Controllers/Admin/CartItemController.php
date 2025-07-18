<?php

namespace App\Http\Controllers\Admin;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartItemController extends Controller
{
    // Xoá mềm item khỏi giỏ
    public function destroy($id)
    {
        $item = CartItem::findOrFail($id);
        $item->delete();

        return back()->with('success', 'Đã xoá sản phẩm khỏi giỏ (xoá mềm)');
    }

    // Hiển thị danh sách item đã xoá mềm trong 1 giỏ hàng cụ thể
    public function trashed($cartId)
    {
        // Lấy giỏ hàng, kể cả nếu đã bị xoá mềm
        $cart = Cart::withTrashed()->with('user')->findOrFail($cartId);

        // Lấy danh sách item đã xoá mềm theo cart_id
        $items = CartItem::onlyTrashed()
            ->where('cart_id', $cartId)
            ->with(['variant.product.translations', 'cart.user']) // load liên quan
            ->paginate(10);

        return view('admin.cart_items.trashed', [
            'items' => $items,
            'cart' => $cart,
        ]);
    }

    // Khôi phục sản phẩm đã xoá mềm
    public function restore($id)
    {
        $item = CartItem::onlyTrashed()->findOrFail($id);
        $item->restore();

        return back()->with('success', 'Khôi phục thành công');
    }

    // Xoá vĩnh viễn sản phẩm khỏi giỏ
    public function forceDelete($id)
    {
        $item = CartItem::onlyTrashed()->findOrFail($id);
        $item->forceDelete();

        return back()->with('success', 'Đã xoá vĩnh viễn');
    }
}
