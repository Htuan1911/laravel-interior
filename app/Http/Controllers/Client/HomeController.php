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
            ->get()
            ->map(function ($product) {
                $product->name = $product->translations->first()->name ?? 'Không có tên';
                // Lấy giá thấp nhất từ các biến thể
                $product->base_price = $product->variants->min('price') ?? 0;
                return $product;
            });

        // Lấy sản phẩm khuyến mãi (giả sử dựa trên coupon hoặc chọn ngẫu nhiên)
        $promotions = Product::where('status', 'active')
            ->with(['translations' => function ($query) {
                $query->where('language_code', 'vi');
            }, 'variants'])
            ->inRandomOrder()
            ->limit(4)
            ->get()
            ->map(function ($product) {
                $product->name = $product->translations->first()->name ?? 'Không có tên';
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
            ->groupBy('products.id')
            ->select('products.*', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->orderByDesc('total_sold')
            ->limit(4)
            ->get()
            ->map(function ($product) {
                $product->name = $product->translations->first()->name ?? 'Không có tên';
                $product->base_price = $product->variants->min('price') ?? 0;
                return $product;
            });

        return view('client.home', compact('products', 'categories', 'promotions', 'bestSellers'));

    }
}