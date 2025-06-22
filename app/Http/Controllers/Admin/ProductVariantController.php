<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class ProductVariantController extends Controller
{
    // Hiển thị danh sách biến thể
   public function index()
{
    $variants = DB::table('product_variants')
        ->join('products', 'product_variants.product_id', '=', 'products.id')
        ->join('product_translations', function($join) {
            $join->on('products.id', '=', 'product_translations.product_id')
                ->where('product_translations.language_code', 'vi');
        })
        ->leftJoin('images', function($join) {
            $join->on('product_variants.id', '=', 'images.variant_id')
                ->where('images.is_main', '=', true);
        })
        ->select(
            'product_variants.id',
            'product_variants.sku',
            'product_variants.variant_name',
            'product_variants.price',
            'product_variants.stock_quantity',
            'product_variants.status',
            'product_translations.name as product_name',
            'images.url as image_url'
        )
        ->orderBy('product_variants.id', 'desc')
        ->paginate(15);

    return view('admin.variants.index', compact('variants'));
}


    // Hiển thị form thêm biến thể
   public function create()
{
    $products = DB::table('products')
        ->join('product_translations', function ($join) {
            $join->on('products.id', '=', 'product_translations.product_id')
                ->where('product_translations.language_code', 'vi');
        })
        ->select('products.id', 'product_translations.name')
        ->get();

    return view('admin.variants.create', compact('products'));
}

public function store(Request $request)
{
    $request->validate([
        'product_id' => 'required|integer|exists:products,id',
        'sku' => 'required|string|max:100|unique:product_variants,sku',
        'variant_name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'stock_quantity' => 'required|integer|min:0',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
    ]);

    // Insert variant
    $variantId = DB::table('product_variants')->insertGetId([
        'product_id' => $request->input('product_id'),
        'sku' => $request->input('sku'),
        'variant_name' => $request->input('variant_name'),
        'price' => $request->input('price'),
        'stock_quantity' => $request->input('stock_quantity'),
        'status' => 'active',
        'created_at' => now(),
        'updated_at' => now()
    ]);

    // Handle image upload
    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('variant_images', 'public');

        DB::table('images')->insert([
            'variant_id' => $variantId,
            'url' => $path,
            'alt_text' => $request->input('variant_name'),
            'is_main' => true,
            'position' => 0,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    return redirect()->route('admin.variants.index')->with('success', 'Thêm biến thể thành công.');
}
 public function edit($id)
{
    $variant = DB::table('product_variants')->where('id', $id)->first();

    if (!$variant) {
        abort(404);
    }

    return view('admin.variants.edit', compact('variant'));
}
    // Cập nhật biến thể


public function update(Request $request, $id)
{
    $request->validate([
        'sku' => 'required|string|max:100',
        'variant_name' => 'required|string|max:255',
        'price' => 'required|numeric',
        'stock_quantity' => 'required|integer',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    // Cập nhật bản ghi product_variants
    DB::table('product_variants')->where('id', $id)->update([
        'sku' => $request->sku,
        'variant_name' => $request->variant_name,
        'price' => $request->price,
        'stock_quantity' => $request->stock_quantity,
        'updated_at' => now(),
    ]);

    // Xử lý ảnh nếu có upload mới
    if ($request->hasFile('image')) {
        // Xóa ảnh cũ (nếu có)
        $oldImage = DB::table('images')
            ->where('variant_id', $id)
            ->whereNull('product_id')
            ->first();

        if ($oldImage && Storage::disk('public')->exists($oldImage->url)) {
            Storage::disk('public')->delete($oldImage->url);
        }

        // Lưu ảnh mới
        $file = $request->file('image');
        $path = $file->store('variants', 'public');

        if ($oldImage) {
            // Cập nhật ảnh cũ
            DB::table('images')->where('id', $oldImage->id)->update([
                'url' => $path,
                'updated_at' => now(),
            ]);
        } else {
            // Chèn mới ảnh
            DB::table('images')->insert([
                'variant_id' => $id,
                'url' => $path,
                'is_main' => true,
                'position' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    return redirect()->route('admin.variants.index')->with('success', 'Cập nhật biến thể thành công.');
}


    // Xóa biến thể
    public function destroy($id)
    {
        $variant = DB::table('product_variants')->where('id', $id)->first();

        if (!$variant) {
            return redirect()->route('admin.variants.index')->withErrors('Không tìm thấy biến thể này!');
        }

        DB::table('product_variants')->where('id', $id)->delete();

        return redirect()->route('admin.variants.index')->with('success', 'Xóa biến thể thành công!');
    }
}

