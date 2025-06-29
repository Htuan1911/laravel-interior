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
        $products = Product::latest()->take(8)->get();

        return view('client.home', compact('products'));
    }
}
