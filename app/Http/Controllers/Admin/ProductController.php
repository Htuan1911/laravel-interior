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
use App\Models\ProductOption;



class ProductController extends Controller
{
    public function index(Request $request)
    {
        $languageCode = 'vi';
        $keyword = $request->keyword;
        $categoryId = $request->category_id; // ✳️ lấy category_id từ request

        $query = DB::table('products')
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
            ->orderByDesc('products.id');

        // ✳️ Tìm theo từ khóa
        if (!empty($keyword)) {
            $query->where('product_translations.name', 'like', '%' . $keyword . '%');
        }

        // ✳️ Tìm theo danh mục
        if (!empty($categoryId)) {
            $query->where('products.category_id', $categoryId);
        }

        // ✳️ Phân trang
        $products = $query->paginate(10)->withQueryString();

        // ✳️ Lấy danh mục con để hiển thị trong select box
        $categories = DB::table('categories')
            ->join('category_translations', function ($join) use ($languageCode) {
                $join->on('categories.id', '=', 'category_translations.category_id')
                    ->where('category_translations.language_code', '=', $languageCode);
            })
            ->whereNotNull('categories.parent_id') // chỉ lấy danh mục con
            ->select('categories.id', 'category_translations.name')
            ->get();

        return view('admin.products.index', compact('products', 'categories'));
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
            'warranty_months' => 'required|integer',
            'description' => 'required|string',
            'status' => 'required|in:active,inactive',
            'material' => 'required|string',
            'dimensions' => 'required|string',
            'style' => 'required|string',
            'image' => 'required|image|max:2048',
            'variants' => 'required|array|min:1',
            'variants.*.name' => 'required|string',
            'variants.*.sku' => 'required|string',  // Bắt buộc nhập
            'variants.*.price' => 'required|numeric|max:2000000000',  // Bắt buộc nhập
            'variants.*.stock_quantity' => 'required|integer',  // Bắt buộc nhập
            'variants.*.weight' => 'nullable|numeric',
            'variants.*.color' => 'nullable|string',
            'variants.*.material' => 'nullable|string',
            'variants.*.size' => 'nullable|string',
            'variants.*.image' => 'nullable|image|max:2048',
        ]);


        $newVariants = [];
        $material = $request->material;
        $dimensions = $request->dimensions;

        // Lấy danh sách tất cả SKU đang tồn tại trong hệ thống
        $existingVariants = DB::table('product_variants')->get();
        $existingSkus = $existingVariants->pluck('sku')->filter()->toArray();

        $combinationMap = [];

        foreach ($request->variants ?? [] as $index => $variant) {
            $sku = trim($variant['sku'] ?? '');
            $color = strtolower(trim($variant['color'] ?? ''));
            $variantMaterial = strtolower(trim($variant['material'] ?? ''));
            $size = strtolower(trim($variant['size'] ?? ''));
            $price = $variant['price'] ?? null;
            $weight = $variant['weight'] ?? null;
            $quantity = $variant['stock_quantity'] ?? 0;

            $key = "$color|$variantMaterial|$size";

            // ❌ Nếu SKU trùng với hệ thống → kiểm tra tiếp
            if (!empty($sku) && in_array($sku, $existingSkus)) {
                $conflict = $existingVariants->first(function ($v) use ($sku) {
                    return $v->sku === $sku;
                });

                // Nếu SKU trùng nhưng khác thuộc tính → báo lỗi
                if (
                    $conflict->color !== $color ||
                    $conflict->material !== $variantMaterial ||
                    $conflict->size !== $size ||
                    $conflict->price != $price ||
                    $conflict->weight != $weight
                ) {
                    return back()->withErrors([
                        "variants.$index.sku" => "Mã SKU '$sku' đã tồn tại với thuộc tính khác."
                    ])->withInput();
                }

                // Nếu trùng SKU và toàn bộ thuộc tính → cộng số lượng
                DB::table('product_variants')
                    ->where('id', $conflict->id)
                    ->increment('stock_quantity', $quantity);

                continue; // bỏ qua thêm mới
            }

            // ❌ Nếu biến thể đã có trong danh sách thêm nhưng khác SKU → lỗi
            if (isset($combinationMap[$key])) {
                $existing = $combinationMap[$key];

                if ($existing['sku'] === $sku) {
                    // Nếu mọi thuộc tính đều trùng → cộng số lượng
                    $combinationMap[$key]['stock_quantity'] += $quantity;
                    continue;
                } else {
                    return back()->withErrors([
                        "variants.$index.sku" => "Biến thể '$key' đã tồn tại với SKU khác ('{$existing['sku']}')."
                    ])->withInput();
                }
            }

            $combinationMap[$key] = [
                'variant' => $variant,
                'sku' => $sku,
                'price' => $price,
                'weight' => $weight,
                'stock_quantity' => $quantity,
                'index' => $index
            ];
        }

        // Nếu không có biến thể mới → thoát
        if (empty($combinationMap)) {
            return redirect()->route('admin.products.index')->with('success', 'Không có biến thể mới để tạo.');
        }

        // Upload ảnh sản phẩm
        $mainImagePath = null;
        if ($request->hasFile('image')) {
            $mainImagePath = $request->file('image')->store('products', 'public');
        }

        // Tạo sản phẩm
        $productId = DB::table('products')->insertGetId([
            'category_id' => $request->category_id,
            'attribute_id' => $request->attribute_id,
            'base_price' => 0,
            'status' => $request->status,
            'dimensions' => $dimensions,
            'warranty_months' => $request->warranty_months,
            'image' => $mainImagePath,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('product_translations')->insert([
            'product_id' => $productId,
            'language_code' => 'vi',
            'name' => $request->name,
            'description' => $request->description,
            'material' => $material,
            'style' => $request->style,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Thêm biến thể mới
        foreach ($combinationMap as $entry) {
            $variant = $entry['variant'];
            $index = $entry['index'];

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
                'stock_quantity' => $entry['stock_quantity'],
                'weight' => $variant['weight'] ?? null,
                'color' => $variant['color'] ?? null,
                'material' => $variant['material'] ?? null,
                'size' => $variant['size'] ?? null,
                'image' => $variantImagePath,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('admin.products.index')->with('success', 'Tạo sản phẩm thành công.');
    }

    // Lấy danh sách tên thuộc tính theo category
    public function getAttributeNamesByCategory($categoryId)
    {
        $attributeNames = DB::table('product_options')
            ->where('category_id', $categoryId)
            ->where('status', 'active')
            ->select('id', 'name') // hoặc thêm type nếu cần
            ->get();

        return response()->json($attributeNames);
    }
    // Lấy các giá trị (values) theo id thuộc tính
    public function getOptionValuesByAttribute($id)
    {
        // Lấy tất cả giá trị của thuộc tính
        $option = ProductOption::findOrFail($id);
        $values = $option->values; // hoặc $option->productOptionValues nếu dùng quan hệ

        // Phân loại
        $result = [
            'color' => [],
            'size' => [],
            'material' => [],
        ];

        foreach ($values as $v) {
            if ($v->type === 'color') {
                $result['color'][] = $v->value;
            } elseif ($v->type === 'size') {
                $result['size'][] = $v->value;
            } elseif ($v->type === 'material') {
                $result['material'][] = $v->value;
            }
        }

        return response()->json($result);
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

        // Lấy danh sách tên thuộc tính theo category_id của sản phẩm
        $attributeOptions = DB::table('product_options')
            ->where('category_id', $product->category_id)
            ->select('id', 'name')
            ->get();

        $selectedAttributeId = $product->attribute_id ?? null;

        return view('admin.products.edit', compact(
            'product',
            'translation',
            'categories',
            'variants',
            'attributeOptions',
            'selectedAttributeId'
        ));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'category_id' => 'required|integer',
            'warranty_months' => 'required|integer',
           'description' => 'required|string',
            'status' => 'required|in:active,inactive',
            'material' => 'required|string',
            'dimensions' => 'required|string',
            'style' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'variants' => 'required|array|min:1',
            'variants.*.name' => 'required|string',
            'variants.*.sku' => 'required|string',  // Bắt buộc nhập
            'variants.*.price' => 'required|numeric|max:2000000000',  // Bắt buộc nhập
            'variants.*.stock_quantity' => 'required|integer',  // Bắt buộc nhập
            'variants.*.weight' => 'required|numeric',
            'variants.*.color' => 'nullable|string',
            'variants.*.material' => 'nullable|string',
            'variants.*.size' => 'nullable|string',
           'variants.*.image' => 'nullable|image|max:2048',
        ]);

        // Cập nhật ảnh sản phẩm
        $mainImagePath = DB::table('products')->where('id', $id)->value('image');
        if ($request->hasFile('image')) {
            if ($mainImagePath && Storage::disk('public')->exists($mainImagePath)) {
                Storage::disk('public')->delete($mainImagePath);
            }
            $mainImagePath = $request->file('image')->store('products', 'public');
        }

        DB::table('products')->where('id', $id)->update([
            'category_id' => $request->category_id,
            'attribute_id' => $request->attribute_id,
            'dimensions' => $request->dimensions,
            'status' => $request->status,
            'warranty_months' => $request->warranty_months,
            'image' => $mainImagePath,
            'updated_at' => now(),
        ]);

        DB::table('product_translations')
            ->updateOrInsert([
                'product_id' => $id,
                'language_code' => 'vi'
            ], [
                'name' => $request->name,
                'description' => $request->description,
                'material' => $request->material,
                'style' => $request->style,
                'updated_at' => now(),
            ]);

        // Xử lý biến thể
        $existingVariants = DB::table('product_variants')->where('product_id', $id)->get();
        $existingIds = $existingVariants->pluck('id')->toArray();
        $submittedIds = collect($request->variants ?? [])->pluck('id')->filter()->toArray();

        // Xoá các biến thể không còn
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

        // Lấy tất cả SKU khác sản phẩm hiện tại
        $otherSkus = DB::table('product_variants')
            ->where('product_id', '!=', $id)
            ->pluck('sku')
            ->filter()
            ->toArray();

        $combinationMap = [];
        $skuMap = [];

        foreach ($request->variants as $index => $variant) {
            $sku = trim($variant['sku'] ?? '');
            $color = strtolower(trim($variant['color'] ?? ''));
            $material = strtolower(trim($variant['material'] ?? ''));
            $size = strtolower(trim($variant['size'] ?? ''));
            $price = $variant['price'] ?? null;
            $weight = $variant['weight'] ?? null;

            $key = "$color|$material|$size";

            // ❌ Trùng SKU với sản phẩm khác => lỗi
            if (!empty($sku) && in_array($sku, $otherSkus)) {
                return back()->withErrors([
                    "variants.$index.sku" => "SKU '$sku' đã tồn tại ở sản phẩm khác."
                ])->withInput();
            }

            // ❌ Trùng biến thể + trùng SKU nhưng khác giá/size/... => lỗi
            if (isset($combinationMap[$key])) {
                $existing = $combinationMap[$key];

                if (
                    $existing['sku'] === $sku &&
                    (
                        $existing['price'] != $price ||
                        $existing['weight'] != $weight
                    )
                ) {
                    return back()->withErrors([
                        "variants.$index.sku" => "Biến thể '$key' có SKU '$sku' nhưng khác thông số giá/trọng lượng."
                    ])->withInput();
                }

                if ($existing['sku'] !== $sku && $sku !== '') {
                    return back()->withErrors([
                        "variants.$index.sku" => "Biến thể '$key' đã tồn tại với SKU khác ('{$existing['sku']}')."
                    ])->withInput();
                }

                $combinationMap[$key]['stock_quantity'] += $variant['stock_quantity'] ?? 0;
                continue; // skip insert/update
            }

            // Lưu vào map để xử lý
            $combinationMap[$key] = [
                'index' => $index,
                'variant' => $variant,
                'sku' => $sku,
                'price' => $price,
                'weight' => $weight,
                'stock_quantity' => $variant['stock_quantity'] ?? 0,
            ];
            $skuMap[$sku] = $key;
        }

        // Xử lý lưu DB sau khi đã validate
        foreach ($combinationMap as $key => $entry) {
            $variant = $entry['variant'];
            $index = $entry['index'];
            $stockQuantity = $entry['stock_quantity'];
            $variantImage = !empty($variant['id'])
                ? DB::table('product_variants')->where('id', $variant['id'])->value('image')
                : null;

            if ($request->hasFile("variants.$index.image")) {
                if ($variantImage && Storage::disk('public')->exists($variantImage)) {
                    Storage::disk('public')->delete($variantImage);
                }
                $variantImage = $request->file("variants.$index.image")->store('variant_images', 'public');
            }

            $variantData = [
                'name' => $variant['name'],
                'variant_name' => $variant['name'],
                'sku' => $variant['sku'] ?? null,
                'price' => $variant['price'] ?? 0,
                'stock_quantity' => $stockQuantity,
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
