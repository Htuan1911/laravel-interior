<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = Wishlist::with('user', 'product')->get();
        return view('admin.wishlists.index', compact('wishlists'));
    }

    public function create()
    {
        $users = User::all();
        $products = Product::all();
        return view('admin.wishlists.create', compact('users', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
        ]);

        Wishlist::create($request->only('user_id', 'product_id'));
        return redirect()->route('admin.wishlists.index')->with('success', 'Đã thêm vào danh sách yêu thích.');
    }

    public function edit($id)
    {
        $wishlist = Wishlist::findOrFail($id);
        $users = User::all();
        $products = Product::all();
        return view('admin.wishlists.edit', compact('wishlist', 'users', 'products'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
        ]);

        $wishlist = Wishlist::findOrFail($id);
        $wishlist->update($request->only('user_id', 'product_id'));
        return redirect()->route('admin.wishlists.index')->with('success', 'Cập nhật thành công.');
    }

    public function destroy($id)
    {
        $wishlist = Wishlist::findOrFail($id);
        $wishlist->delete();
        return redirect()->route('admin.wishlists.index')->with('success', 'Đã xóa khỏi danh sách yêu thích.');
    }
}
