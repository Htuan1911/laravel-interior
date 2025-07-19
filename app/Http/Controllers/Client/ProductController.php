<?php

namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Comment;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with([
            'translations' => function ($query) {
                $query->where('language_code', 'vi');
            },
            'category.translations' => function ($query) {
                $query->where('language_code', 'vi');
            },
            'variants' => function ($query) {
                $query->where('status', 'active');
            }
        ])
            ->where('status', 'active')
            ->whereNull('deleted_at')
            ->latest()
            ->get();

        return view('client.products.index', compact('products'));
    }

 public function show($id)
    {
        $product = Product::with([
            'translations' => fn($q) => $q->where('language_code', 'vi'),
            'variants',
            'category.translations' => fn($q) => $q->where('language_code', 'vi'),
        ])->findOrFail($id);

        $relatedProducts = Product::with([
            'translations' => fn($q) => $q->where('language_code', 'vi'),
            'variants',
        ])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'active')
            ->take(4)
            ->get();

        return view('client.products.show', compact('product', 'relatedProducts'));
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
    // ClientProductController.php
    public function category($id)
    {
        $category = Category::findOrFail($id);
        $products = $category->products()->paginate(12);

        return view('client.products.index', compact('products', 'category'));
    }

}
