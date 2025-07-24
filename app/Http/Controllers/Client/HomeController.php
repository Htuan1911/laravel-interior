<?php

namespace App\Http\Controllers\Client;

use App\Models\Category;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class HomeController extends Controller


{
    public function index()
    {
        // Lấy danh mục đang hoạt động với bản dịch tiếng Việt
        $categories = Category::where('status', 'active')
            ->with(['translations' => function ($query) {
                $query->where('language_code', 'vi');
            }])
            ->get()
            ->map(function ($category) {
                $category->name = $category->translations->first()->name ?? 'Không có tên';
                return $category;
            });

        // Lấy tất cả sản phẩm đang hoạt động với bản dịch tiếng Việt
        $products = Product::where('status', 'active')
            ->with(['translations' => function ($query) {
                $query->where('language_code', 'vi');
            }, 'variants'])
            ->take(12)
            ->get()
            ->map(function ($product) {
                $product->name = $product->translations->first()->name ?? 'Không có tên';
                // Lấy giá thấp nhất từ các biến thể
                $product->base_price = $product->variants->min('price') ?? 0;
                return $product;
            });


        // Lấy sản phẩm bán chạy dựa trên tổng số lượng trong order_items
     $bestSellers = Product::where('products.status', 'active')
    ->with(['translations' => function ($query) {
        $query->where('language_code', 'vi');
    }, 'variants'])
    ->join('product_variants', 'products.id', '=', 'product_variants.product_id')
    ->join('order_items', 'product_variants.id', '=', 'order_items.variant_id')
    ->select(
        'products.id',
        'products.category_id',
        'products.status',
        'products.image',
        'products.created_at',
        'products.updated_at',
        DB::raw('SUM(order_items.quantity) as total_sold')
    )
    ->groupBy(
        'products.id',
        'products.category_id',
        'products.status',
        'products.image',
        'products.created_at',
        'products.updated_at'
    )
    ->orderByDesc('total_sold')
    ->limit(4)
    ->get()
    ->map(function ($product) {
        $product->name = $product->translations->first()->name ?? 'Không có tên';
        $product->base_price = $product->variants->min('price') ?? 0;
        return $product;
    });


        $latestProducts = Product::where('status', 'active')
            ->with(['translations' => function ($q) {
                $q->where('language_code', 'vi');
            }, 'variants'])
            ->orderByDesc('created_at')
            ->limit(5)
            ->get()
            ->map(function ($product) {
                $product->name = $product->translations->first()?->name ?? 'Không có tên';
                $product->base_price = $product->variants->min('price') ?? 0;
                $product->original_price = $product->variants->max('price') ?? 0;
                $product->discount_percent = $product->original_price > 0
                    ? round((1 - $product->base_price / $product->original_price) * 100)
                    : 0;
                $product->image = $product->image ?? 'img/product/default.jpg';
                return $product;
            });



        return view('client.home', compact('products', 'categories', 'latestProducts', 'bestSellers'));
    }
}
