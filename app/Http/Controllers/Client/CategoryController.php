<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show($id)
    {
        $category = Category::findOrFail($id);

        // Lấy sản phẩm thuộc danh mục
        $products = $category->products()
            ->with(['translations', 'variants'])
            ->where('status', 'active')
            ->get();

        return view('client.categories.show', compact('category', 'products'));
    }
}
