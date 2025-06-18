<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductWithoutVariantsController extends Controller
{
    public function index()
{
    $products = DB::table('products')
        ->leftJoin('product_variants', 'products.id', '=', 'product_variants.product_id')
        ->join('product_translations as pt', function ($join) {
            $join->on('products.id', '=', 'pt.product_id')
                ->where('pt.language_code', 'vi');
        })
        ->leftJoin('images', function ($join) {
            $join->on('products.id', '=', 'images.product_id')
                ->where('images.is_main', 1);
        })
        ->join('categories', 'products.category_id', '=', 'categories.id')
        ->join('category_translations as ct', function ($join) {
            $join->on('categories.id', '=', 'ct.category_id')
                ->where('ct.language_code', 'vi');
        })
        ->select(
            'products.id',
            'pt.name as product_name',
            'pt.description',
            'products.base_price',
            'images.url as image_url',
            'images.alt_text as image_alt_text',
            'ct.name as category_name'
        )
        ->whereNull('product_variants.id')
        ->get();

    return view('admin.products_without_variants.index', compact('products'));
}


    public function create()
    {
        $categories = DB::table('categories')
            ->join('category_translations', function($join) {
                $join->on('categories.id', '=', 'category_translations.category_id')
                    ->where('category_translations.language_code', 'vi');
            })
            ->select('categories.id', 'category_translations.name')
            ->where('categories.status', 'active')
            ->get();

        return view('admin.products_without_variants.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'base_price' => 'required|numeric|min:0',
            'name_vi' => 'required|string|max:255',
            'description_vi' => 'nullable|string',
            'name_en' => 'required|string|max:255',
            'description_en' => 'nullable|string',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'alt_text' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            $productId = DB::table('products')->insertGetId([
                'category_id' => $request->category_id,
                'base_price' => $request->base_price,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('product_translations')->insert([
                [
                    'product_id' => $productId,
                    'language_code' => 'vi',
                    'name' => $request->name_vi,
                    'description' => $request->description_vi,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'product_id' => $productId,
                    'language_code' => 'en',
                    'name' => $request->name_en,
                    'description' => $request->description_en,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ]);

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = 'product_' . $productId . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('public/products', $filename);

                DB::table('images')->insert([
                    'product_id' => $productId,
                    'url' => Storage::url($path),
                    'alt_text' => $request->alt_text,
                    'is_main' => 1,
                    'position' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::commit();
            return redirect()->route('admin.products_without_variants.index')->with('success', 'Thêm sản phẩm thành công!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Lỗi khi thêm sản phẩm: ' . $e->getMessage()])->withInput();
        }
    }

    public function edit($id)
{
    $product = DB::table('products')
        ->where('id', $id)
        ->first();

    if (!$product) {
        return redirect()->route('admin.products_without_variants.index')->withErrors('Sản phẩm không tồn tại');
    }

    $translation_vi = DB::table('product_translations')
        ->where('product_id', $id)
        ->where('language_code', 'vi')
        ->first();

    $image = DB::table('images')
        ->where('product_id', $id)
        ->whereNull('variant_id')
        ->where('is_main', true)
        ->first();

    $categories = DB::table('categories')
        ->join('category_translations', function ($join) {
            $join->on('categories.id', '=', 'category_translations.category_id')
                ->where('category_translations.language_code', 'vi');
        })
        ->where('categories.status', 'active')
        ->select('categories.id', 'category_translations.name')
        ->get();

    return view('admin.products_without_variants.edit', compact('product', 'translation_vi', 'image', 'categories'));
}

// Cập nhật sản phẩm
public function update(Request $request, $id)
{
    $request->validate([
        'name_vi' => 'required|string|max:255',
        'description_vi' => 'nullable|string',
        'base_price' => 'required|numeric|min:0',
        'category_id' => 'required|exists:categories,id',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'alt_text' => 'nullable|string|max:255',
    ]);

    DB::beginTransaction();
    try {
        DB::table('products')->where('id', $id)->update([
            'base_price' => $request->base_price,
            'category_id' => $request->category_id,
            'updated_at' => now(),
        ]);

        DB::table('product_translations')
            ->updateOrInsert(
                ['product_id' => $id, 'language_code' => 'vi'],
                ['name' => $request->name_vi, 'description' => $request->description_vi, 'updated_at' => now()]
            );

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads/products', 'public');

            DB::table('images')->updateOrInsert(
                ['product_id' => $id, 'variant_id' => null, 'is_main' => true],
                [
                    'url' => $imagePath,
                    'alt_text' => $request->alt_text,
                    'position' => 1,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        } else {
            // Nếu chỉ cập nhật chú thích ảnh
            if ($request->alt_text) {
                DB::table('images')
                    ->where('product_id', $id)
                    ->whereNull('variant_id')
                    ->where('is_main', true)
                    ->update(['alt_text' => $request->alt_text]);
            }
        }

        DB::commit();
        return redirect()->route('admin.products_without_variants.index')->with('success', 'Cập nhật sản phẩm thành công!');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->withErrors('Lỗi khi cập nhật: ' . $e->getMessage())->withInput();
    }
}

// Xóa sản phẩm
public function destroy($id)
{
    DB::beginTransaction();
    try {
        DB::table('images')->where('product_id', $id)->delete();
        DB::table('product_translations')->where('product_id', $id)->delete();
        DB::table('products')->where('id', $id)->delete();

        DB::commit();
        return redirect()->route('admin.products_without_variants.index')->with('success', 'Xóa sản phẩm thành công!');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->withErrors('Lỗi khi xóa: ' . $e->getMessage());
    }
}
}
