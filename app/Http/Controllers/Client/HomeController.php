<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Lấy 8 sản phẩm mới nhất
        $products = Product::with('category')
            ->where('status', 'active') // sản phẩm phải active
            ->whereHas('category', function ($query) {
                $query->where('status', 'active'); // danh mục cũng phải active
            })
            ->orderBy('created_at', 'desc') // sản phẩm mới nhất
            ->take(8) // giới hạn 8 sản phẩm
            ->get();

        return view('client.home', compact('products'));
    }
}
