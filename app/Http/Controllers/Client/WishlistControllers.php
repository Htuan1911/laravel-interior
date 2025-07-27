<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Wishlist;

class WishlistControllers extends Controller
{
   public function index()
{
    $wishlists = auth()->user()
        ->wishlists()
        ->with(['product.translations', 'product.variants'])
        ->get();

    return view('wishlist.index', compact('wishlists'));
}


    public function toggle(Product $product)
    {
        $user = Auth::user();

        $wishlist = Wishlist::where('user_id', $user->id)
                            ->where('product_id', $product->id)
                            ->first();

        if ($wishlist) {
            $wishlist->delete();
            return redirect()->back()->with('success', 'Đã xoá khỏi danh sách yêu thích.');
        } else {
            Wishlist::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
            ]);
            return redirect()->back()->with('success', 'Đã thêm vào danh sách yêu thích.');
        }
    }

    public function remove($id)
    {
        $wishlist = Wishlist::findOrFail($id);
        $wishlist->delete();

        return redirect()->back()->with('success', 'Đã xoá khỏi danh sách yêu thích.');
    }
}
