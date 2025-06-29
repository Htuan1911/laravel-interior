<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class ProductController extends Controller
{
public function index()
{
    $languageCode = 'vi';

    $products = DB::table('products')
        ->join('product_translations', function ($join) use ($languageCode) {
            $join->on('products.id', '=', 'product_translations.product_id')
                 ->where('product_translations.language_code', '=', $languageCode);
        })
        ->join('categories', 'products.category_id', '=', 'categories.id')
        ->join('category_translations', function ($join) use ($languageCode) {
            $join->on('categories.id', '=', 'category_translations.category_id')
                 ->where('category_translations.language_code', '=', $languageCode);
        })
        ->leftJoin('product_variants', 'products.id', '=', 'product_variants.product_id')
        ->whereNull('products.deleted_at') // ✅ Thêm điều kiện để không hiển thị sản phẩm đã xoá mềm
        ->select(
            'products.id',
            'products.image as main_image',
            'product_translations.name',
            'product_translations.description',
            'product_translations.material',
            'product_translations.style',
            'products.dimensions',
            'products.warranty_months',
            'products.status',
            'category_translations.name as category_name',
            'products.created_at',
            'products.deleted_at', // ✅ Giữ lại để có thể dùng ở view nếu cần
            DB::raw('SUM(product_variants.stock_quantity) as total_quantity'),
            DB::raw('GROUP_CONCAT(DISTINCT product_variants.price ORDER BY product_variants.price SEPARATOR ", ") as prices'),
            DB::raw('GROUP_CONCAT(DISTINCT product_variants.color ORDER BY product_variants.color SEPARATOR ", ") as colors'),
            DB::raw('GROUP_CONCAT(DISTINCT product_variants.image ORDER BY product_variants.image SEPARATOR ", ") as variant_images')
        )
        ->groupBy(
            'products.id',
            'product_translations.name',
            'product_translations.description',
            'product_translations.material',
            'product_translations.style',
            'products.dimensions',
            'products.warranty_months',
            'products.status',
            'category_translations.name',
            'products.created_at',
            'products.image',
            'products.deleted_at' // ✅ Bổ sung vào groupBy
        )
        ->orderByDesc('products.id')
        ->get();

    return view('admin.products.index', compact('products'));
}



public function create()
{
    $categories = DB::table('categories')
        ->join('category_translations', function ($join) {
            $join->on('categories.id', '=', 'category_translations.category_id')
                ->where('category_translations.language_code', '=', 'vi');
        })
        ->select('categories.id', 'category_translations.name')
        ->get();

    $colors = DB::table('product_option_values')
        ->join('product_options', 'product_option_values.product_option_id', '=', 'product_options.id')
        ->where('product_options.type', 'color')
        ->select('product_option_values.id', 'product_option_values.value', 'product_option_values.color_code')
        ->get();

    $materials = DB::table('product_option_values')
        ->join('product_options', 'product_option_values.product_option_id', '=', 'product_options.id')
        ->where('product_options.type', 'material')
        ->select('product_option_values.id', 'product_option_values.value')
        ->get();

    $sizes = DB::table('product_option_values')
        ->join('product_options', 'product_option_values.product_option_id', '=', 'product_options.id')
        ->where('product_options.type', 'size')
        ->select('product_option_values.id', 'product_option_values.value')
        ->get();

    return view('admin.products.create', compact('categories', 'colors', 'materials', 'sizes'));
}



// public function store(Request $request)
// {
//     $request->validate([
//         'name' => 'required|string',
//         'category_id' => 'required|integer',
//         'warranty_months' => 'nullable|integer',
//         'description' => 'nullable|string',
//         'material' => 'nullable|string',
//         'dimensions' => 'nullable|string',
//         'style' => 'nullable|string',
//         'variants' => 'nullable|array',
//         'variants.*.name' => 'required|string',
//         'variants.*.sku' => 'nullable|string',
//         'variants.*.price' => 'nullable|numeric',
//         'variants.*.stock_quantity' => 'nullable|integer',
//         'variants.*.weight' => 'nullable|numeric',
//         'variants.*.color' => 'nullable|string',
//     ]);

//     $productId = DB::table('products')->insertGetId([
//         'category_id' => $request->category_id,
//         'base_price' => 0,
//         'status' => 'active',
//         'dimensions' => $request->dimensions,
//         'warranty_months' => $request->warranty_months,
//         'created_at' => now(),
//         'updated_at' => now(),
//     ]);

//     DB::table('product_translations')->insert([
//         'product_id' => $productId,
//         'language_code' => 'vi',
//         'name' => $request->name,
//         'description' => $request->description,
//         'material' => $request->material,
//         'style' => $request->style,
//         'created_at' => now(),
//         'updated_at' => now(),
//     ]);

//     if ($request->has('variants')) {
//         foreach ($request->variants as $variant) {
//             DB::table('product_variants')->insert([
//                 'product_id' => $productId,
//                 'name' => $variant['name'],
//                 'variant_name' => $variant['name'],
//                 'sku' => $variant['sku'] ?? null,
//                 'price' => $variant['price'] ?? 0,
//                 'stock_quantity' => $variant['stock_quantity'] ?? 0,
//                 'weight' => $variant['weight'] ?? null,
//                 'color' => $variant['color'] ?? null,
//                 'created_at' => now(),
//                 'updated_at' => now(),
//             ]);
//         }
//     }

//     return redirect()->route('admin.products.index')->with('success', 'Tạo sản phẩm thành công.');
// }
public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string',
        'category_id' => 'required|integer',
        'warranty_months' => 'nullable|integer',
        'description' => 'nullable|string',
        'material' => 'nullable|string',
        'dimensions' => 'nullable|string',
        'style' => 'nullable|string',
        'image' => 'nullable|image|max:2048',
        'variants' => 'nullable|array',
        'variants.*.name' => 'required|string',
        'variants.*.sku' => 'nullable|string',
        'variants.*.price' => 'nullable|numeric',
        'variants.*.stock_quantity' => 'nullable|integer',
        'variants.*.weight' => 'nullable|numeric',
        'variants.*.color' => 'nullable|string',
        'variants.*.image' => 'nullable|image|max:2048',
    ]);

    // Upload ảnh chính
    $mainImagePath = null;
    if ($request->hasFile('image')) {
        $mainImagePath = $request->file('image')->store('products', 'public');
    }

    // Thêm sản phẩm
    $productId = DB::table('products')->insertGetId([
        'category_id' => $request->category_id,
        'base_price' => 0,
        'status' => 'active',
        'dimensions' => $request->dimensions,
        'warranty_months' => $request->warranty_months,
        'image' => $mainImagePath,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // Thêm bản dịch
    DB::table('product_translations')->insert([
        'product_id' => $productId,
        'language_code' => 'vi',
        'name' => $request->name,
        'description' => $request->description,
        'material' => $request->material,
        'style' => $request->style,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // Thêm biến thể
    if ($request->has('variants')) {
        foreach ($request->variants as $index => $variant) {
            $variantImagePath = null;
            if ($request->hasFile("variants.$index.image")) {
                $variantImagePath = $request->file("variants.$index.image")->store('variant_images', 'public');
            }

            DB::table('product_variants')->insert([
                'product_id' => $productId,
                'name' => $variant['name'],
                'variant_name' => $variant['name'],
                'sku' => $variant['sku'] ?? null,
                'price' => $variant['price'] ?? 0,
                'stock_quantity' => $variant['stock_quantity'] ?? 0,
                'weight' => $variant['weight'] ?? null,
                'color' => $variant['color'] ?? null,
                'image' => $variantImagePath,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    return redirect()->route('admin.products.index')->with('success', 'Tạo sản phẩm thành công.');
}

public function edit($id)
{
    $languageCode = 'vi';

    $product = DB::table('products')
        ->join('product_translations', function ($join) use ($languageCode) {
            $join->on('products.id', '=', 'product_translations.product_id')
                ->where('product_translations.language_code', '=', $languageCode);
        })
        ->where('products.id', $id)
        ->select(
            'products.*',
            'product_translations.name',
            'product_translations.description',
            'product_translations.material',
            'product_translations.style'
        )
        ->first();

    $variants = DB::table('product_variants')
        ->where('product_id', $id)
        ->get();

    $categories = DB::table('categories')
        ->join('category_translations', function ($join) {
            $join->on('categories.id', '=', 'category_translations.category_id')
                ->where('category_translations.language_code', '=', 'vi');
        })
        ->select('categories.id', 'category_translations.name')
        ->get();

    return view('admin.products.edit', compact('product', 'categories', 'variants'));
}
public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string',
        'category_id' => 'required|integer',
        'warranty_months' => 'nullable|integer',
        'description' => 'nullable|string',
        'material' => 'nullable|string',
        'dimensions' => 'nullable|string',
        'style' => 'nullable|string',
        'image' => 'nullable|image|max:2048',
        'variants' => 'nullable|array',
        'variants.*.id' => 'nullable|integer',
        'variants.*.name' => 'required|string',
        'variants.*.sku' => 'nullable|string',
        'variants.*.price' => 'nullable|numeric',
        'variants.*.stock_quantity' => 'nullable|integer',
        'variants.*.weight' => 'nullable|numeric',
        'variants.*.color' => 'nullable|string',
        'variants.*.image' => 'nullable|image|max:2048',
    ]);

    // Cập nhật ảnh chính nếu có
    $mainImagePath = DB::table('products')->where('id', $id)->value('image');
    if ($request->hasFile('image')) {
        $mainImagePath = $request->file('image')->store('products', 'public');
    }

    // Cập nhật bảng products
    DB::table('products')->where('id', $id)->update([
        'category_id' => $request->category_id,
        'dimensions' => $request->dimensions,
        'warranty_months' => $request->warranty_months,
        'image' => $mainImagePath,
        'updated_at' => now(),
    ]);

    // Cập nhật bản dịch
    DB::table('product_translations')
        ->where('product_id', $id)
        ->where('language_code', 'vi')
        ->update([
            'name' => $request->name,
            'description' => $request->description,
            'material' => $request->material,
            'style' => $request->style,
            'updated_at' => now(),
        ]);

    // Cập nhật biến thể
    if ($request->has('variants')) {
        foreach ($request->variants as $index => $variant) {
            $variantImagePath = DB::table('product_variants')->where('id', $variant['id'])->value('image') ?? null;
            if ($request->hasFile("variants.$index.image")) {
                $variantImagePath = $request->file("variants.$index.image")->store('variant_images', 'public');
            }

            DB::table('product_variants')->where('id', $variant['id'])->update([
                'name' => $variant['name'],
                'variant_name' => $variant['name'],
                'sku' => $variant['sku'] ?? null,
                'price' => $variant['price'] ?? 0,
                'stock_quantity' => $variant['stock_quantity'] ?? 0,
                'weight' => $variant['weight'] ?? null,
                'color' => $variant['color'] ?? null,
                'image' => $variantImagePath,
                'updated_at' => now(),
            ]);
        }
    }

    return redirect()->route('admin.products.index')->with('success', 'Cập nhật sản phẩm thành công.');
}

public function destroy($id)
{
    DB::table('products')
        ->where('id', $id)
        ->update(['deleted_at' => now()]);

    return redirect()->route('admin.products.index')->with('success', 'Đã xoá tạm thời sản phẩm.');
}

public function forceDelete($id)
{
    DB::table('product_variants')->where('product_id', $id)->delete();
    DB::table('product_translations')->where('product_id', $id)->delete();
    DB::table('products')->where('id', $id)->delete();

    return redirect()->route('admin.products.trashed')->with('success', 'Đã xoá vĩnh viễn sản phẩm.');
}
public function restore($id)
{
    DB::table('products')
        ->where('id', $id)
        ->update(['deleted_at' => null]);

    return redirect()->route('admin.products.index')->with('success', 'Khôi phục sản phẩm thành công.');
}

public function trashed()
{
    $languageCode = 'vi';

    $products = DB::table('products')
        ->whereNotNull('products.deleted_at')
        ->join('product_translations', function ($join) use ($languageCode) {
            $join->on('products.id', '=', 'product_translations.product_id')
                 ->where('product_translations.language_code', '=', $languageCode);
        })
        ->join('categories', 'products.category_id', '=', 'categories.id')
        ->join('category_translations', function ($join) use ($languageCode) {
            $join->on('categories.id', '=', 'category_translations.category_id')
                 ->where('category_translations.language_code', '=', $languageCode);
        })
        ->leftJoin('product_variants', 'products.id', '=', 'product_variants.product_id')
        ->select(
            'products.id',
            'products.image as main_image',
            'product_translations.name',
            'product_translations.description',
            'category_translations.name as category_name',
            'products.created_at',
            DB::raw('SUM(product_variants.stock_quantity) as total_quantity'),
            DB::raw('GROUP_CONCAT(DISTINCT product_variants.price ORDER BY product_variants.price SEPARATOR ", ") as prices')
        )
        ->groupBy(
            'products.id',
            'product_translations.name',
            'product_translations.description',
            'category_translations.name',
            'products.created_at',
            'products.image'
        )
        ->orderByDesc('products.id')
        ->get();

    return view('admin.products.trashed', compact('products'));
}


}


