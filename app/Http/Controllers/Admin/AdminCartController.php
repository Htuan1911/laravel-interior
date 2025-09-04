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

    // Lấy items với variant, product, translations và phân trang
    $items = $cart->items()->with('variant.product.translations')
        ->whereNull('deleted_at')
        ->paginate(10);

    return view('admin.carts.show', compact('cart', 'items'));
}


}

