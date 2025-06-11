<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
 public function index()
{
    $products = DB::table('products as p')
        ->join('product_translations as pt', function ($join) {
            $join->on('p.id', '=', 'pt.product_id')
                 ->where('pt.language_code', 'vi');
        })
        ->join('categories as c', 'p.category_id', '=', 'c.id')
        ->join('category_translations as ct', function ($join) {
            $join->on('c.id', '=', 'ct.category_id')
                 ->where('ct.language_code', 'vi');
        })
        ->join('product_variants as pv', 'p.id', '=', 'pv.product_id')
        ->leftJoin('images as img', function ($join) {
            $join->on('p.id', '=', 'img.product_id')
                 ->where('img.is_main', 1);
        })
        ->select(
            'p.id as product_id',
    'pt.name as product_name',
    'p.base_price',
    'ct.name as category_name',
    'pv.sku',
    'pv.variant_name',
    'pv.price as variant_price',
    'pv.stock_quantity',
    'pv.image as variant_image',     // Ảnh biến thể
    'img.url as image_url',          // Ảnh sản phẩm
    'img.alt_text'
        )
        ->orderBy('p.id', 'desc')
        ->get();

    return view('admin.products.index', compact('products'));
}

public function create()
    {
        $products = DB::table('products')
            ->join('product_translations', 'products.id', '=', 'product_translations.product_id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('category_translations', 'categories.id', '=', 'category_translations.category_id')
            ->where('product_translations.language_code', 'vi')
            ->where('category_translations.language_code', 'vi')
            ->select('products.id', 'product_translations.name', 'products.base_price', 'category_translations.name as category')
            ->get();

        $skus = DB::table('product_variants')
            ->select('sku', 'variant_name', 'price', 'stock_quantity')
            ->get();

        return view('admin.products.create', compact('products', 'skus'));
    }

   public function getProductInfo($id)
{
    $product = DB::table('products as p')
        ->join('product_translations as pt', function ($join) {
            $join->on('p.id', '=', 'pt.product_id')
                ->where('pt.language_code', 'vi');
        })
        ->join('categories as c', 'p.category_id', '=', 'c.id')
        ->join('category_translations as ct', function ($join) {
            $join->on('c.id', '=', 'ct.category_id')
                ->where('ct.language_code', 'vi');
        })
        ->where('p.id', $id)
        ->select('pt.name as product_name', 'ct.name as category_name', 'p.base_price')
        ->first();

    return response()->json($product);
}

public function getVariantInfo($sku)
{
    $variant = DB::table('product_variants')
        ->where('sku', $sku)
        ->select('variant_name', 'price', 'stock_quantity')
        ->first();

    return response()->json($variant);
}



public function store(Request $request)
{
    // Validate cơ bản, bỏ unique vì xử lý riêng bên dưới
    $request->validate([
        'product_id' => 'required|integer|exists:products,id',
        'sku' => 'required|string',
        'variant_name' => 'required|string',
        'variant_price' => 'required|numeric',
        'variant_stock' => 'required|integer|min:1',
        'variant_image' => 'nullable|image|max:2048',
    ]);

    // Kiểm tra SKU đã tồn tại chưa
    $existingVariant = DB::table('product_variants')->where('sku', $request->sku)->first();

    // Nếu đã có SKU → cập nhật số lượng + ảnh nếu có
    if ($existingVariant) {
        $newStock = $existingVariant->stock_quantity + $request->variant_stock;

        $updateData = [
            'stock_quantity' => $newStock,
            'updated_at' => now(),
        ];

        // Nếu có ảnh mới → cập nhật ảnh
        if ($request->hasFile('variant_image')) {
            $imagePath = $request->file('variant_image')->store('public/variants');
            $imagePath = str_replace('public/', '', $imagePath);
            $updateData['image'] = $imagePath;
        }

        DB::table('product_variants')
            ->where('id', $existingVariant->id)
            ->update($updateData);

        return redirect()->route('admin.products.index')
            ->with('success', 'SKU đã tồn tại. Số lượng tồn kho đã được cập nhật.');
    }

    // Nếu chưa có SKU → thêm mới
    $imagePath = null;
    if ($request->hasFile('variant_image')) {
        $imagePath = $request->file('variant_image')->store('public/variants');
        $imagePath = str_replace('public/', '', $imagePath);
    }

    DB::table('product_variants')->insert([
        'product_id' => $request->product_id,
        'sku' => $request->sku,
        'variant_name' => $request->variant_name,
        'price' => $request->variant_price,
        'stock_quantity' => $request->variant_stock,
        'image' => $imagePath,
        'status' => 'active',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect()->route('admin.products.index')
        ->with('success', 'Thêm biến thể vào sản phẩm thành công.');
}



public function destroy($id)
{
    // Lấy các ảnh biến thể để xoá
    $variants = DB::table('product_variants')->where('product_id', $id)->get();

    foreach ($variants as $variant) {
        if ($variant->image && Storage::exists('public/' . $variant->image)) {
            Storage::delete('public/' . $variant->image);
        }
    }

    // Xoá biến thể trước
    DB::table('product_variants')->where('product_id', $id)->delete();

    // Xoá ảnh chính nếu có
    $images = DB::table('images')->where('product_id', $id)->get();
    foreach ($images as $img) {
        if ($img->url && Storage::exists('public/' . $img->url)) {
            Storage::delete('public/' . $img->url);
        }
    }

    DB::table('images')->where('product_id', $id)->delete();

    // Xoá sản phẩm và translation
    DB::table('product_translations')->where('product_id', $id)->delete();
    DB::table('products')->where('id', $id)->delete();

    return redirect()->route('admin.products.index')->with('success', 'Xoá sản phẩm và các biến thể thành công.');
}

public function edit($id)
{
    $variant = DB::table('product_variants')->where('id', $id)->first();

    // Kiểm tra nếu không tìm thấy biến thể
    if (!$variant) {
        abort(404, 'Không tìm thấy biến thể.');
    }

    $products = DB::table('products')
        ->join('product_translations', 'products.id', '=', 'product_translations.product_id')
        ->where('product_translations.language_code', 'vi')
        ->select('products.id', 'product_translations.name')
        ->get();

    $skus = DB::table('product_variants')
        ->select('sku')
        ->get();

    $productInfo = DB::table('products as p')
        ->join('product_translations as pt', 'p.id', '=', 'pt.product_id')
        ->join('categories as c', 'p.category_id', '=', 'c.id')
        ->join('category_translations as ct', 'c.id', '=', 'ct.category_id')
        ->where('pt.language_code', 'vi')
        ->where('ct.language_code', 'vi')
        ->where('p.id', $variant->product_id)
        ->select('pt.name as product_name', 'ct.name as category_name', 'p.base_price')
        ->first();

    return view('admin.products.edit', compact('variant', 'products', 'skus', 'productInfo'));
}


public function update(Request $request, $id)
{
    $request->validate([
        'product_id' => 'required|integer|exists:products,id',
        'sku' => 'required|string',
        'variant_name' => 'required|string',
        'variant_price' => 'required|numeric',
        'variant_stock' => 'required|integer|min:1',
        'variant_image' => 'nullable|image|max:2048',
    ]);

    $variant = DB::table('product_variants')->where('id', $id)->first();
    if (!$variant) {
        return redirect()->back()->withErrors(['Không tìm thấy biến thể.']);
    }

    // Kiểm tra trùng SKU trên sản phẩm khác
    $duplicate = DB::table('product_variants')
        ->where('sku', $request->sku)
        ->where('id', '!=', $id)
        ->first();

    if ($duplicate) {
        return redirect()->back()->withErrors(['SKU đã được dùng cho biến thể khác.']);
    }

    $updateData = [
        'product_id' => $request->product_id,
        'sku' => $request->sku,
        'variant_name' => $request->variant_name,
        'price' => $request->variant_price,
        'stock_quantity' => $request->variant_stock,
        'updated_at' => now(),
    ];

    // Nếu có ảnh mới thì cập nhật
    if ($request->hasFile('variant_image')) {
        if ($variant->image && Storage::exists('public/' . $variant->image)) {
            Storage::delete('public/' . $variant->image);
        }

        $path = $request->file('variant_image')->store('public/variants');
        $updateData['image'] = str_replace('public/', '', $path);
    }

    DB::table('product_variants')->where('id', $id)->update($updateData);

    return redirect()->route('admin.products.index')->with('success', 'Cập nhật biến thể thành công.');
}


}
