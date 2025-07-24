<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

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
        ->whereNull('products.deleted_at')
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
            'products.deleted_at',
            DB::raw('SUM(product_variants.stock_quantity) as total_quantity'),
            DB::raw('GROUP_CONCAT(DISTINCT product_variants.price ORDER BY product_variants.price SEPARATOR ", ") as prices'),
            DB::raw('GROUP_CONCAT(DISTINCT product_variants.color ORDER BY product_variants.color SEPARATOR ", ") as colors'),
            DB::raw('GROUP_CONCAT(DISTINCT product_variants.material ORDER BY product_variants.material SEPARATOR ", ") as materials'),
            DB::raw('GROUP_CONCAT(DISTINCT product_variants.size ORDER BY product_variants.size SEPARATOR ", ") as sizes'),
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
            'products.deleted_at'
        )
        ->orderByDesc('products.id')
        ->get();

    return view('admin.products.index', compact('products'));
}





public function create()
{
    // Lấy danh sách danh mục sản phẩm
    $categories = DB::table('categories')
        ->join('category_translations', function ($join) {
            $join->on('categories.id', '=', 'category_translations.category_id')
                ->where('category_translations.language_code', '=', 'vi');
        })
        ->select('categories.id', 'category_translations.name')
        ->get();

    // Chưa load thuộc tính ở đây, sẽ dùng AJAX khi chọn danh mục

    return view('admin.products.create', compact('categories'));
}

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
        'variants.*.material' => 'nullable|string', // ✅ thêm
        'variants.*.size' => 'nullable|string',     // ✅ thêm
        'variants.*.image' => 'nullable|image|max:2048',
    ]);

    $newVariants = [];
    $hasNewVariant = false;
     // ✅ Kiểm tra các biến thể
    foreach ($request->variants ?? [] as $index => $variant) {
        $sku = $variant['sku'];
        $color = $variant['color'] ?? null;
        $material = $request->material;
        $dimensions = $request->dimensions;

        $exactMatch = DB::table('product_variants')
            ->join('products', 'product_variants.product_id', '=', 'products.id')
            ->join('product_translations', 'products.id', '=', 'product_translations.product_id')
            ->where('product_variants.sku', $sku)
            ->where('product_variants.color', $color)
            ->where('products.dimensions', $dimensions)
            ->where('product_translations.material', $material)
            ->select('product_variants.id')
            ->first();

        if ($exactMatch) {
                // ✅ Nếu trùng hoàn toàn → cộng số lượng
            DB::table('product_variants')
                ->where('id', $exactMatch->id)
                ->increment('stock_quantity', $variant['stock_quantity'] ?? 0);
        } else {
               // ❌ Nếu chỉ trùng SKU → lỗi
            $skuConflict = DB::table('product_variants')
                ->where('sku', $sku)
                ->first();

            if ($skuConflict) {
                // ✅ Nếu không trùng → lưu lại để insert
                return back()->withErrors(['sku' => "Mã SKU '{$sku}' đã tồn tại với thuộc tính khác."])->withInput();
            }

            $hasNewVariant = true;
            $newVariants[] = ['data' => $variant, 'index' => $index];
        }
    }

    if (!$hasNewVariant) {
        return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã được cập nhật số lượng.');
    }
    // ✅ Upload ảnh chính nếu có
    $mainImagePath = null;
    if ($request->hasFile('image')) {
        $mainImagePath = $request->file('image')->store('products', 'public');
    }
    // ✅ Tạo sản phẩm mới
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
    // ✅ Thêm bản dịch sản phẩm
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
    // ✅ Thêm các biến thể mới
    foreach ($newVariants as $variantItem) {
        $variant = $variantItem['data'];
        $index = $variantItem['index'];

        $variantImagePath = null;
        if ($request->hasFile("variants.$index.image")) {
            $variantImagePath = $request->file("variants.$index.image")->store('variant_images', 'public');
        }
        // ✅ Thêm biến thể vào bảng product_variants
        DB::table('product_variants')->insert([
            'product_id' => $productId,
            'name' => $variant['name'],
            'variant_name' => $variant['name'],
            'sku' => $variant['sku'] ?? null,
            'price' => $variant['price'] ?? 0,
            'stock_quantity' => $variant['stock_quantity'] ?? 0,
            'weight' => $variant['weight'] ?? null,
            'color' => $variant['color'] ?? null,
            'material' => $variant['material'] ?? null, // ✅ thêm
            'size' => $variant['size'] ?? null,         // ✅ thêm
            'image' => $variantImagePath,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    return redirect()->route('admin.products.index')->with('success', 'Tạo sản phẩm thành công.');
}





public function getOptionsByCategory($id)
{
    $colors = DB::table('product_option_values')
        ->join('product_options', 'product_option_values.product_option_id', '=', 'product_options.id')
        ->where('product_options.type', 'color')
        ->where('product_options.category_id', $id)
        ->select('product_option_values.id', 'product_option_values.value', 'product_option_values.color_code')
        ->get();

    $materials = DB::table('product_option_values')
        ->join('product_options', 'product_option_values.product_option_id', '=', 'product_options.id')
        ->where('product_options.type', 'material')
        ->where('product_options.category_id', $id)
        ->select('product_option_values.id', 'product_option_values.value')
        ->get();

    $sizes = DB::table('product_option_values')
        ->join('product_options', 'product_option_values.product_option_id', '=', 'product_options.id')
        ->where('product_options.type', 'size')
        ->where('product_options.category_id', $id)
        ->select('product_option_values.id', 'product_option_values.value')
        ->get();

    return response()->json([
        'colors' => $colors,
        'materials' => $materials,
        'sizes' => $sizes,
    ]);
}


public function edit($id)
{
    $product = DB::table('products')->where('id', $id)->first();
    if (!$product) {
        return redirect()->route('admin.products.index')->with('error', 'Sản phẩm không tồn tại.');
    }

    $translation = DB::table('product_translations')
        ->where('product_id', $id)
        ->where('language_code', 'vi')
        ->first();

    $categories = DB::table('categories')
        ->join('category_translations', function ($join) {
            $join->on('categories.id', '=', 'category_translations.category_id')
                 ->where('category_translations.language_code', 'vi');
        })
        ->select('categories.id', 'category_translations.name')
        ->get();

    $variants = DB::table('product_variants')
        ->where('product_id', $id)
        ->get();

    return view('admin.products.edit', compact('product', 'translation', 'categories', 'variants'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'category_id' => 'required|integer|exists:categories,id',
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
        'variants.*.material' => 'nullable|string',
        'variants.*.size' => 'nullable|string',
        'variants.*.image' => 'nullable|image|max:2048',
    ]);

    // Ảnh chính
    $mainImagePath = DB::table('products')->where('id', $id)->value('image');
    if ($request->hasFile('image')) {
        if ($mainImagePath && Storage::disk('public')->exists($mainImagePath)) {
            Storage::disk('public')->delete($mainImagePath);
        }
        $mainImagePath = $request->file('image')->store('products', 'public');
    }

    // Cập nhật sản phẩm
    DB::table('products')->where('id', $id)->update([
        'category_id' => $request->category_id,
        'dimensions' => $request->dimensions,
        'warranty_months' => $request->warranty_months,
        'image' => $mainImagePath,
        'updated_at' => now(),
    ]);

    // Translation
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

    // Xử lý biến thể
    $existingIds = DB::table('product_variants')->where('product_id', $id)->pluck('id')->toArray();
    $submittedIds = collect($request->variants ?? [])->pluck('id')->filter()->toArray();

    // Xóa biến thể không còn
    $toDelete = array_diff($existingIds, $submittedIds);
    if ($toDelete) {
        $variantImages = DB::table('product_variants')->whereIn('id', $toDelete)->pluck('image');
        foreach ($variantImages as $img) {
            if ($img && Storage::disk('public')->exists($img)) {
                Storage::disk('public')->delete($img);
            }
        }
        DB::table('product_variants')->whereIn('id', $toDelete)->delete();
    }

    // Thêm hoặc cập nhật biến thể
    if ($request->has('variants')) {
        foreach ($request->variants as $i => $variant) {
            // Log kiểm tra
            Log::info("Update variant #$i", [
                'material' => $variant['material'] ?? 'null',
                'size' => $variant['size'] ?? 'null',
            ]);

            $variantImage = $variant['id'] 
                ? DB::table('product_variants')->where('id', $variant['id'])->value('image') 
                : null;

            if ($request->hasFile("variants.$i.image")) {
                if ($variantImage && Storage::disk('public')->exists($variantImage)) {
                    Storage::disk('public')->delete($variantImage);
                }
                $variantImage = $request->file("variants.$i.image")->store('variant_images', 'public');
            }

            $variantData = [
                'name' => $variant['name'],
                'variant_name' => $variant['name'],
                'sku' => $variant['sku'] ?? null,
                'price' => $variant['price'] ?? 0,
                'stock_quantity' => $variant['stock_quantity'] ?? 0,
                'weight' => $variant['weight'] ?? null,
                'color' => $variant['color'] ?? null,
                'material' => $variant['material'] ?? null,
                'size' => $variant['size'] ?? null,
                'image' => $variantImage,
                'updated_at' => now(),
            ];

            if (!empty($variant['id'])) {
                DB::table('product_variants')->where('id', $variant['id'])->update($variantData);
            } else {
                $variantData['product_id'] = $id;
                $variantData['created_at'] = now();
                DB::table('product_variants')->insert($variantData);
            }
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
public function show($id)
{
    $languageCode = 'vi';

    // Lấy thông tin sản phẩm
    $product = DB::table('products')
        ->join('product_translations', function ($join) use ($languageCode) {
            $join->on('products.id', '=', 'product_translations.product_id')
                ->where('product_translations.language_code', '=', $languageCode);
        })
        ->join('categories', 'products.category_id', '=', 'categories.id')
        ->join('category_translations', function ($join) use ($languageCode) {
            $join->on('categories.id', '=', 'category_translations.category_id')
                ->where('category_translations.language_code', '=', $languageCode);
        })
        ->where('products.id', $id)
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
            'products.created_at'
        )
        ->first();

    if (!$product) {
        return redirect()->route('admin.products.index')->with('error', 'Sản phẩm không tồn tại.');
    }

    // Lấy danh sách biến thể
    $variants = DB::table('product_variants')
        ->where('product_variants.product_id', $id)
        ->select('id', 'name', 'sku', 'price', 'stock_quantity', 'color', 'size', 'material', 'image')
        ->get();

    return view('admin.products.show', compact('product', 'variants'));
}



}


