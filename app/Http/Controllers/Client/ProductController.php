<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

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

        // Lấy các sản phẩm cùng danh mục
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

    // ClientProductController.php
    public function category($id)
    {
        $category = Category::findOrFail($id);
        $products = $category->products()->paginate(12);

        return view('client.products.index', compact('products', 'category'));
    }
}
