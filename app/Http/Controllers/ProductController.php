<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Comment;

class ProductController extends Controller
{
    public function show($id)
    {
        $product = Product::with('translation')->findOrFail($id);

        $relatedProducts = Product::with('translation')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('product_detail', [
            'product' => $product,
            'relatedProducts' => $relatedProducts
        ]);
    }

    public function storeComment(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
    if (!Auth::check()) {
        return redirect('/')->with('error', 'Bạn cần đăng nhập để bình luận');
    }

    $request->validate([
        'content' => 'required|string|max:1000',
    ]);

    Comment::create([
        'product_id' => $id,
        'name' => Auth::user()->name,
        'content' => $request->input('content'),
    ]);

    return redirect()->back()->with('success', 'Đã gửi bình luận thành công!');
}
}
