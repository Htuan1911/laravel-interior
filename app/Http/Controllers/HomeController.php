<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller; // ✅ Thêm dòng này
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $products = Product::with('translation')->latest()->take(8)->get();

        return view('home', compact('categories', 'products'));
    }
}
