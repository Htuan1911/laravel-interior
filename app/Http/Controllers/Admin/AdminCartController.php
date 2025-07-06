<?php
namespace App\Http\Controllers\Admin;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        $cart = Cart::with(['user', 'items.variant.product'])->findOrFail($id);
        return view('admin.carts.show', compact('cart'));
    }

    public function destroy($id)
    {
        $cart = Cart::findOrFail($id);
        $cart->delete();
        return back()->with('success', 'Giỏ hàng đã được xoá.');
    }
}
