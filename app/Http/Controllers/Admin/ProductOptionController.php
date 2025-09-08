<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Models\ProductOption;



class ProductOptionController extends Controller
{

    public function index(Request $request)
    {
        $name = $request->input('name');          // từ khóa tìm theo tên option
        $categoryId = $request->input('category_id'); // lọc theo danh mục

        $query = DB::table('product_options')
            ->leftJoin('categories', 'product_options.category_id', '=', 'categories.id')
            ->leftJoin('category_translations', function ($join) {
                $join->on('categories.id', '=', 'category_translations.category_id')
                    ->where('category_translations.language_code', 'vi');
            })
            ->whereNull('product_options.deleted_at')
            ->select('product_options.*', 'category_translations.name as category_name');

        // Lọc theo tên
        if (!empty($name)) {
            $query->where('product_options.name', 'LIKE', "%{$name}%");
        }

        // Lọc theo danh mục
        if (!empty($categoryId)) {
            $query->where('product_options.category_id', $categoryId);
        }
        $query->orderBy('product_options.created_at', 'desc');
        $options = $query->paginate(10)->withQueryString();

        foreach ($options as $option) {
            $values = DB::table('product_option_values')
                ->where('product_option_id', $option->id)
                ->select('value', 'color_code')
                ->get();

            $option->values = $values;

            // Tạo chuỗi hiển thị
            $displayArr = [];
           foreach ($values as $val) {
                if (!empty($val->color_code)) {
                    $displayArr[] = "<span class='color-circle' style='background: {$val->color_code}'></span> " . e($val->value);
                } else {
                    $displayArr[] = e($val->value);
                }
            }
            $option->values_display = implode(', ', $displayArr);
        }

        // Lấy danh mục để hiển thị trong filter
        $categories = DB::table('categories')
            ->leftJoin('category_translations', function ($join) {
                $join->on('categories.id', '=', 'category_translations.category_id')
                    ->where('category_translations.language_code', 'vi');
            })
            ->select('categories.id', 'category_translations.name')
            ->get();

        return view('admin.product_options.index', compact('options', 'name', 'categoryId', 'categories'));
    }



    public function create()
    {
        $categories = DB::table('categories')
            ->leftJoin('category_translations', 'categories.id', '=', 'category_translations.category_id')
            ->where('category_translations.language_code', 'vi')
            ->select('categories.id', 'category_translations.name')
            ->orderBy('category_translations.name')
            ->get();

        return view('admin.product_options.create', compact('categories'));
    }


    public function store(Request $request)
    {
        // Validate đầu vào
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',

                function ($attribute, $value, $fail) use ($request) {
                    // Kiểm tra xem tên thuộc tính với category đã tồn tại chưa (bất kể type nào)
                    $exists = DB::table('product_options')
                        ->where('category_id', $request->category_id)
                        ->where('status', 'active')
                        ->whereNull('deleted_at')
                        ->whereRaw('LOWER(TRIM(name)) = ?', [Str::lower(trim($value))])
                        ->exists();

                    if ($exists) {
                        $fail("Tên thuộc tính đã tồn tại trong danh mục.");
                        return;
                    }
                },
            ],
            'status' => 'required|in:active,inactive',
            'category_id' => 'required|exists:categories,id',
        ]);

        $attributes = $request->input('attributes', []);
        $hasAnyAttribute = false;
        $errors = [];
         // BẮT BUỘC CẢ 3 PHẢI CÓ ÍT NHẤT 1 GIÁ TRỊ
    $missingTypes = [];
    foreach (['color', 'size', 'material'] as $type) {
        $values = $attributes[$type]['values'] ?? null;
        $filtered = array_filter((array) $values, fn($v) => trim($v) !== '');
        if (count($filtered) === 0) {
            $missingTypes[] = $type;
        }
    }

    if (!empty($missingTypes)) {
        foreach ($missingTypes as $type) {
            $errors["attributes.$type.values"] = "Bạn phải nhập ít nhất một giá trị cho '$type'.";
        }
        return back()->withErrors($errors)->withInput();
    }

        DB::beginTransaction();
        try {
            // Bước 1: Tạo hoặc lấy product_option duy nhất theo name + category_id
            $productOptionId = DB::table('product_options')->insertGetId([
                'name' => trim($request->name),
                'type' => 'group', // Bạn có thể đặt 'group' hoặc để trống nếu không cần
                'status' => $request->status,
                'category_id' => $request->category_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            // Bước 2: Xử lý từng loại thuộc tính color, size, material
            foreach (['color', 'size', 'material'] as $type) {
                $values = $attributes[$type]['values'] ?? null;
                if (!$values || !is_array($values) || empty(array_filter($values))) {
                    continue;
                }

                $hasAnyAttribute = true;
                $colorCodes = $attributes[$type]['color_codes'] ?? [];
                $combinations = [];

                foreach ($values as $index => $val) {
                    $value = trim($val);
                    $color = $type === 'color' ? ($colorCodes[$index] ?? null) : null;

                    if (empty($value) && $type !== 'color') {
                        $errors["attributes.$type.values.$index"] = 'Giá trị không được để trống';
                        continue;
                    }

                    if (empty($value) && empty($color)) {
                        $errors["attributes.$type.values.$index"] = 'Phải nhập giá trị hoặc chọn màu.';
                        continue;
                    }

                    $comboKey = strtolower($value . '|' . $color);
                    if (in_array($comboKey, $combinations)) {
                        $errors["attributes.$type.values.$index"] = 'Giá trị bị trùng trong form.';
                        continue;
                    }
                    $combinations[] = $comboKey;

                    // Kiểm tra tồn tại giá trị trong DB cho product_option_values
                    $exists = DB::table('product_option_values')
                        ->where('product_option_id', $productOptionId)
                        ->whereRaw('LOWER(TRIM(value)) = ?', [Str::lower($value)])
                        ->when($color, fn($q) => $q->where('color_code', $color))
                        ->exists();

                    if ($exists) {
                        $errors["attributes.$type.values.$index"] = 'Giá trị đã tồn tại trong cơ sở dữ liệu.';
                        continue;
                    }
                }

                if (!empty($errors)) {
                    continue;
                }

                // Insert product_option_values cho từng giá trị của loại thuộc tính hiện tại
                foreach ($values as $index => $val) {
                    $value = trim($val);
                    $color = $type === 'color' ? ($colorCodes[$index] ?? null) : null;

                    if (empty($value) && empty($color)) {
                        continue;
                    }

                    DB::table('product_option_values')->insert([
                        'product_option_id' => $productOptionId,
                        'type' => $type,
                        'value' => $value ?: null,
                        'color_code' => $color,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            if (!empty($errors)) {
                DB::rollBack();
                return back()->withErrors($errors)->withInput();
            }

            if (!$hasAnyAttribute) {
                DB::rollBack();
                return back()->withErrors([
                    'attributes' => 'Bạn phải nhập ít nhất một loại thuộc tính.'
                ])->withInput();
            }

            DB::commit();
            return redirect()->route('admin.product_options.index')->with('success', 'Tạo thuộc tính thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Lỗi: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)

    {

        // 1. Lấy product_option theo id
        $option = DB::table('product_options')->where('id', $id)->first();
        if (!$option) {
            return back()->with('error', 'Không tìm thấy thuộc tính.');
        }

        // 2. Lấy tất cả product_option_values cho option này
        $optionValues = DB::table('product_option_values')
            ->where('product_option_id', $option->id)
            ->get();

        // 3. Lấy danh mục (ví dụ như bạn đã làm)
        $categories = DB::table('categories')
            ->leftJoin('category_translations', 'categories.id', '=', 'category_translations.category_id')
            ->where('category_translations.language_code', 'vi')
            ->select('categories.id', 'category_translations.name')
            ->orderBy('category_translations.name')
            ->get();

        // 4. Truyền dữ liệu sang view
        return view('admin.product_options.edit', [
            'option' => $option,
            'optionValues' => $optionValues,
            'categories' => $categories,
        ]);
    }
    public function update(Request $request, $id)
    {
        // Lấy product_option hiện tại
        $productOption = DB::table('product_options')->where('id', $id)->first();
        if (!$productOption) {
            return redirect()->back()->with('error', 'Thuộc tính không tồn tại.');
        }

        // Validate đầu vào
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                function ($attribute, $value, $fail) use ($request, $id) {
                    // Kiểm tra xem tên thuộc tính với category đã tồn tại chưa (bất kể type nào), ngoại trừ bản ghi hiện tại
                    $exists = DB::table('product_options')
                        ->where('category_id', $request->category_id)
                        ->where('status', 'active')
                        ->whereNull('deleted_at')
                        ->whereRaw('LOWER(TRIM(name)) = ?', [Str::lower(trim($value))])
                        ->where('id', '<>', $id)
                        ->exists();

                    if ($exists) {
                        $fail("Tên thuộc tính đã tồn tại trong danh mục.");
                    }
                },
            ],
            'status' => 'required|in:active,inactive',
            'category_id' => 'required|exists:categories,id',
        ]);

        $attributes = $request->input('attributes', []);
        $hasAnyAttribute = false;
        $errors = [];
         // BẮT BUỘC CẢ 3 PHẢI CÓ ÍT NHẤT 1 GIÁ TRỊ
    $missingTypes = [];
    foreach (['color', 'size', 'material'] as $type) {
        $values = $attributes[$type]['values'] ?? null;
        $filtered = array_filter((array) $values, fn($v) => trim($v) !== '');
        if (count($filtered) === 0) {
            $missingTypes[] = $type;
        }
    }

    if (!empty($missingTypes)) {
        foreach ($missingTypes as $type) {
            $errors["attributes.$type.values"] = "Bạn phải nhập ít nhất một giá trị cho '$type'.";
        }
        return back()->withErrors($errors)->withInput();
    }

        DB::beginTransaction();
        try {
            // Cập nhật thông tin product_option
            DB::table('product_options')->where('id', $id)->update([
                'name' => trim($request->name),
                'type' => 'group', // Nếu muốn có thể lấy từ request hoặc giữ nguyên
                'status' => $request->status,
                'category_id' => $request->category_id,
                'updated_at' => now(),
            ]);

            // Xóa hết các giá trị thuộc tính cũ để cập nhật lại
            DB::table('product_option_values')->where('product_option_id', $id)->delete();

            // Xử lý từng loại thuộc tính color, size, material
            foreach (['color', 'size', 'material'] as $type) {
                $values = $attributes[$type]['values'] ?? null;
                if (!$values || !is_array($values) || empty(array_filter($values))) {
                    continue;
                }

                $hasAnyAttribute = true;
                $colorCodes = $attributes[$type]['color_codes'] ?? [];
                $combinations = [];

                foreach ($values as $index => $val) {
                    $value = trim($val);
                    $color = $type === 'color' ? ($colorCodes[$index] ?? null) : null;

                    if (empty($value) && $type !== 'color') {
                        $errors["attributes.$type.values.$index"] = 'Giá trị không được để trống';
                        continue;
                    }

                    if (empty($value) && empty($color)) {
                        $errors["attributes.$type.values.$index"] = 'Phải nhập giá trị hoặc chọn màu.';
                        continue;
                    }

                    $comboKey = strtolower($value . '|' . $color);
                    if (in_array($comboKey, $combinations)) {
                        $errors["attributes.$type.values.$index"] = 'Giá trị bị trùng trong form.';
                        continue;
                    }
                    $combinations[] = $comboKey;

                    // Kiểm tra tồn tại giá trị trong DB cho product_option_values (ngoại trừ product_option_id hiện tại)
                    $exists = DB::table('product_option_values')
                        ->where('product_option_id', $id)
                        ->whereRaw('LOWER(TRIM(value)) = ?', [Str::lower($value)])
                        ->when($color, fn($q) => $q->where('color_code', $color))
                        ->exists();

                    if ($exists) {
                        $errors["attributes.$type.values.$index"] = 'Giá trị đã tồn tại trong cơ sở dữ liệu.';
                        continue;
                    }
                }

                if (!empty($errors)) {
                    continue;
                }

                // Insert lại product_option_values cho từng giá trị của loại thuộc tính hiện tại
                foreach ($values as $index => $val) {
                    $value = trim($val);
                    $color = $type === 'color' ? ($colorCodes[$index] ?? null) : null;

                    if (empty($value) && empty($color)) {
                        continue;
                    }

                    DB::table('product_option_values')->insert([
                        'product_option_id' => $id,
                        'type' => $type,
                        'value' => $value ?: null,
                        'color_code' => $color,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            if (!empty($errors)) {
                DB::rollBack();
                return back()->withErrors($errors)->withInput();
            }

            if (!$hasAnyAttribute) {
                DB::rollBack();
                return back()->withErrors([
                    'attributes' => 'Bạn phải nhập ít nhất một loại thuộc tính.'
                ])->withInput();
            }

            DB::commit();
            return redirect()->route('admin.product_options.index')->with('success', 'Cập nhật thuộc tính thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Lỗi: ' . $e->getMessage())->withInput();
        }
    }





    public function destroy($id)
    {
        $option = ProductOption::findOrFail($id);

        // Kiểm tra xem có sản phẩm nào đang dùng thuộc tính chính này không
        $isUsed = DB::table('products')
            ->where('attribute_id', $id)
            ->whereNull('deleted_at')
            ->exists();

        if ($isUsed) {
            return redirect()->route('admin.product_options.index')
                ->with('error', 'Không thể xóa: Thuộc tính chính đang được sử dụng trong sản phẩm.');
        }
        // Xóa giá trị con
        DB::table('product_option_values')->where('product_option_id', $id)->delete();

        // Xóa chính nó
        $option->delete();

        return redirect()->route('admin.product_options.index')
            ->with('success', 'Xóa thuộc tính thành công.');
    }
    






    // Thêm giá trị mới vào một thuộc tính
    public function storeValue(Request $request, $option_id)
    {
        $request->validate([
            'value' => 'required|string|max:100',
            'color_code' => 'nullable|string|max:7',
        ]);

        DB::table('product_option_values')->insert([
            'product_option_id' => $option_id,
            'value' => $request->value,
            'color_code' => $request->color_code,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.product_options.index')->with('success', 'Thêm giá trị thành công.');
    }
    // Hiển thị form chỉnh sửa giá trị của một thuộc tính
    public function editValue($id)
    {
        $value = DB::table('product_option_values')->where('id', $id)->first();
        if (!$value) return redirect()->back()->with('error', 'Không tìm thấy giá trị.');

        return view('admin.product_options.edit_value', compact('value'));
    }
    // Cập nhật giá trị của một thuộc tính
    public function updateValue(Request $request, $id)
    {
        $request->validate([
            'value' => 'required|string|max:100',
            'color_code' => 'nullable|string|max:7',
        ]);

        DB::table('product_option_values')->where('id', $id)->update([
            'value' => $request->value,
            'color_code' => $request->color_code,
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.product_options.index')->with('success', 'Cập nhật giá trị thành công.');
    }

    public function destroyValue($id)
    {
        $value = DB::table('product_option_values')->where('id', $id)->first();
        if (!$value) return redirect()->back()->with('error', 'Không tìm thấy giá trị.');

        DB::table('product_option_values')->where('id', $id)->delete();

        return redirect()->route('admin.product_options.index')->with('success', 'Xoá giá trị thành công.');
    }
    public function restore($id)
    {
        $restored = DB::table('product_options')->where('id', $id)->update([
            'deleted_at' => null,
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.product_options.trashed')->with('success', 'Khôi phục thành công.');
    }

    public function trashed()
    {
        $trashedOptions = DB::table('product_options')
            ->leftJoin('categories', 'product_options.category_id', '=', 'categories.id')
            ->leftJoin('category_translations', function ($join) {
                $join->on('categories.id', '=', 'category_translations.category_id')
                    ->where('category_translations.language_code', 'vi');
            })
            ->whereNotNull('product_options.deleted_at')
            ->select('product_options.*', 'category_translations.name as category_name')
            ->orderByDesc('product_options.deleted_at')
            ->get();

        return view('admin.product_options.trashed', compact('trashedOptions'));
    }
    public function forceDelete($id)
    {
        $option = DB::table('product_options')->where('id', $id)->first();

        if (!$option) {
            return redirect()->back()->with('error', 'Không tìm thấy thuộc tính.');
        }

        // Xóa vĩnh viễn các giá trị liên quan
        DB::table('product_option_values')->where('product_option_id', $id)->delete();

        // Xóa vĩnh viễn thuộc tính
        DB::table('product_options')->where('id', $id)->delete();

        return redirect()->route('admin.product_options.trashed')->with('success', 'Đã xóa vĩnh viễn thuộc tính.');
    }

    public function show($id)
{
    // Lấy product_option theo id
    $option = DB::table('product_options')->where('id', $id)->first();
    if (!$option) {
        return redirect()->back()->with('error', 'Không tìm thấy thuộc tính.');
    }

    // Lấy tất cả product_option_values cho option này
    $optionValues = DB::table('product_option_values')
        ->where('product_option_id', $option->id)
        ->get();

    // Lấy danh mục để hiển thị tên danh mục hoặc thông tin liên quan
    $category = DB::table('categories')
        ->leftJoin('category_translations', function ($join) {
            $join->on('categories.id', '=', 'category_translations.category_id')
                 ->where('category_translations.language_code', 'vi');
        })
        ->where('categories.id', $option->category_id)
        ->select('categories.id', 'category_translations.name')
        ->first();

    return view('admin.product_options.show', [
        'option' => $option,
        'optionValues' => $optionValues,
        'category' => $category,
    ]);
}

}
