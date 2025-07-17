<?php


namespace App\Http\Controllers\Admin;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel; // Đảm bảo bạn cài package excel
use App\Exports\CartsExport;
use App\Models\CartItem;
class AdminCartController extends Controller
{
    public function index(Request $request)
    {
        $query = Cart::with('user')->latest();

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->search) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $carts = $query->paginate(10);
        return view('admin.carts.index', compact('carts'));
    }

   public function show($id)
{
    $cart = Cart::with('user')->findOrFail($id);
    $items = CartItem::with(['variant.product.translations'])
        ->where('cart_id', $id)
        ->whereNull('deleted_at') // Không lấy item đã xoá mềm
      ->paginate(10);

    return view('admin.carts.show', compact('cart', 'items'));
}

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,abandoned,ordered'
        ]);

        $cart = Cart::findOrFail($id);
        $cart->status = $request->status;
        $cart->save();

        return back()->with('success', 'Cập nhật trạng thái thành công.');
    }

    public function destroy($id)
    {
        $cart = Cart::findOrFail($id);
        $cart->delete();
        return back()->with('success', 'Giỏ hàng đã được xoá.');
    }

    public function trashed()
    {
        $carts = Cart::onlyTrashed()->with('user')->paginate(10);
        return view('admin.carts.trashed', compact('carts'));
    }

    public function restore($id)
    {
        $cart = Cart::onlyTrashed()->findOrFail($id);
        $cart->restore();
        return back()->with('success', 'Khôi phục giỏ hàng thành công.');
    }

    public function forceDelete($id)
    {
        $cart = Cart::onlyTrashed()->findOrFail($id);
        $cart->forceDelete();
        return back()->with('success', 'Giỏ hàng đã bị xoá vĩnh viễn.');
    }



}

