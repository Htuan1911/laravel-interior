<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;


class ProductOptionController extends Controller
{
  public function index()
{
    $options = DB::table('product_options')
        ->leftJoin('categories', 'product_options.category_id', '=', 'categories.id')
        ->leftJoin('category_translations', function ($join) {
            $join->on('categories.id', '=', 'category_translations.category_id')
                 ->where('category_translations.language_code', 'vi');
        })
        ->whereNull('product_options.deleted_at')
        ->select('product_options.*', 'category_translations.name as category_name')
        ->orderByDesc('product_options.id')
        ->get();

    foreach ($options as $option) {
        $option->values = DB::table('product_option_values')
            ->where('product_option_id', $option->id)
            ->get();
    }

    return view('admin.product_options.index', compact('options'));
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
        // Validate dữ liệu chung
        $request->validate([
             'name' => [
            'required',
            'string',
            'max:100',
            function ($attribute, $value, $fail) use ($request) {
                $exists = DB::table('product_options')
                    ->where('category_id', $request->category_id)
                    ->where('type', $request->type)
                    ->whereRaw('LOWER(TRIM(name)) = ?', [Str::lower(trim($value))])
                    ->exists();

                if ($exists) {
                    $fail('Tên thuộc tính đã tồn tại trong danh mục với cùng loại.');
                }
            },
        ],
            'type' => 'required|in:color,size,material',
            'status' => 'required|boolean',
            'category_id' => 'required|exists:categories,id',
            'values' => 'required|array|min:1',
            'values.*' => 'nullable|string|max:100',
            'color_codes' => 'array',
            'color_codes.*' => 'nullable|string|max:20',
        ]);

        $values = $request->input('values', []);
        $colorCodes = $request->input('color_codes', []);

        $unique = [];
        $combinations = [];

        foreach ($values as $index => $value) {
            $value = trim($value);
            $color = $request->type === 'color' ? ($colorCodes[$index] ?? null) : null;

            if (empty($value) && $request->type !== 'color') {
                return back()->withErrors(['values.' . $index => 'Giá trị không được để trống'])->withInput();
            }

            if (empty($value) && empty($color)) {
                return back()->withErrors(['values.' . $index => 'Phải nhập giá trị hoặc chọn màu.'])->withInput();
            }

            $comboKey = strtolower($value . '|' . $color);
            if (in_array($comboKey, $combinations)) {
                return back()->withErrors(['values.' . $index => 'Giá trị bị trùng trong form.'])->withInput();
            }

            $combinations[] = $comboKey;

            // Kiểm tra tồn tại trong DB
            $exists = DB::table('product_option_values')
                ->join('product_options', 'product_option_values.product_option_id', '=', 'product_options.id')
                ->where('product_options.category_id', $request->category_id)
                ->where('product_options.type', $request->type)
                ->when($value, fn ($q) => $q->whereRaw('LOWER(TRIM(product_option_values.value)) = ?', [Str::lower($value)]))
                ->when($color, fn ($q) => $q->where('product_option_values.color_code', $color))
                ->exists();

            if ($exists) {
                return back()->withErrors(['values.' . $index => 'Giá trị đã tồn tại trong DB.'])->withInput();
            }
        }

        DB::beginTransaction();
        try {
            $optionId = DB::table('product_options')->insertGetId([
                'name' => $request->name,
                'type' => $request->type,
                'status' => $request->status,
                'category_id' => $request->category_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($values as $index => $value) {
                DB::table('product_option_values')->insert([
                    'product_option_id' => $optionId,
                    'value' => trim($value) ?: null,
                    'color_code' => $request->type === 'color' ? ($colorCodes[$index] ?? null) : null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
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
    $option = DB::table('product_options')->where('id', $id)->first();

    if (!$option) {
        return back()->with('error', 'Không tìm thấy thuộc tính.');
    }

    // ✅ Truyền biến riêng $optionValues cho view
    $optionValues = DB::table('product_option_values')
        ->where('product_option_id', $option->id)
        ->get();

    $categories = DB::table('categories')
        ->leftJoin('category_translations', 'categories.id', '=', 'category_translations.category_id')
        ->where('category_translations.language_code', 'vi')
        ->select('categories.id', 'category_translations.name')
        ->get();

    return view('admin.product_options.edit', compact('option', 'optionValues', 'categories'));
}


public function update(Request $request, $id)
{
    $request->validate([
        'name' => [
            'required',
            'string',
            'max:100',
            function ($attribute, $value, $fail) use ($request, $id) {
                $exists = DB::table('product_options')
                    ->where('id', '!=', $id)
                    ->where('category_id', $request->category_id)
                    ->where('type', $request->type)
                    ->whereRaw('LOWER(TRIM(name)) = ?', [Str::lower(trim($value))])
                    ->exists();

                if ($exists) {
                    $fail('Tên thuộc tính đã tồn tại trong danh mục với cùng loại.');
                }
            },
        ],
        'type' => 'required|in:color,material,size',
        'status' => 'required|boolean',
        'category_id' => 'required|integer|exists:categories,id',
        'values' => 'required|array|min:1',
        'values.*' => 'nullable|string|max:100',
        'color_codes' => 'array',
    ]);

    $values = $request->input('values', []);
    $colorCodes = $request->input('color_codes', []);

    $uniqueCheck = [];
    foreach ($values as $index => $value) {
        $val = trim($value ?? '');
        $colorCode = $request->type === 'color' ? trim($colorCodes[$index] ?? '') : null;

        if ($request->type === 'color' && !$val && !$colorCode) {
            return back()->withErrors(['values.' . $index => 'Cần nhập giá trị hoặc chọn mã màu.'])->withInput();
        }

        if ($request->type !== 'color' && !$val) {
            return back()->withErrors(['values.' . $index => 'Giá trị không được để trống.'])->withInput();
        }

        $key = strtolower($val . '|' . ($colorCode ?? ''));
        if (in_array($key, $uniqueCheck)) {
            return back()->withErrors(['values.' . $index => 'Giá trị bị trùng trong danh sách.'])->withInput();
        }

        $existsInDB = DB::table('product_option_values')
            ->join('product_options', 'product_option_values.product_option_id', '=', 'product_options.id')
            ->where('product_options.category_id', $request->category_id)
            ->where('product_options.type', $request->type)
            ->where('product_option_values.product_option_id', '!=', $id)
            ->whereRaw('LOWER(TRIM(product_option_values.value)) = ?', [Str::lower($val)])
            ->when($request->type === 'color', function ($query) use ($colorCode) {
                return $query->where('product_option_values.color_code', $colorCode);
            })
            ->exists();

        if ($existsInDB) {
            return back()->withErrors(['values.' . $index => 'Giá trị đã tồn tại trong thuộc tính khác.'])->withInput();
        }

        $uniqueCheck[] = $key;
    }

    DB::beginTransaction();

    try {
        // Update option
        DB::table('product_options')->where('id', $id)->update([
            'name' => $request->name,
            'type' => $request->type,
            'status' => $request->status,
            'category_id' => $request->category_id,
            'updated_at' => now(),
        ]);

        // Delete old values
        DB::table('product_option_values')->where('product_option_id', $id)->delete();

        // Insert new values
        foreach ($values as $index => $value) {
            DB::table('product_option_values')->insert([
                'product_option_id' => $id,
                'value' => $value ?: null,
                'color_code' => $request->type === 'color' ? ($colorCodes[$index] ?? null) : null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
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
    $option = DB::table('product_options')->where('id', $id)->first();

    if (!$option) {
        return redirect()->back()->with('error', 'Không tìm thấy thuộc tính.');
    }

    $column = $option->type; // 'color', 'size', 'material'
    Log::debug("Cột kiểm tra: $column");

    $values = DB::table('product_option_values')
        ->where('product_option_id', $id)
        ->pluck('value')
        ->map(fn($v) => Str::lower(trim($v)))
        ->filter();

    Log::debug("Giá trị kiểm tra:", $values->toArray());

    if ($values->isEmpty()) {
        DB::table('product_options')->where('id', $id)->update(['deleted_at' => now()]);
        return redirect()->route('admin.product_options.index')->with('success', 'Đã xóa thuộc tính (không có giá trị).');
    }

    $isUsed = false;
    foreach ($values as $val) {
        $exists = DB::table('product_variants')
            ->whereRaw("LOWER(TRIM($column)) = ?", [$val])
            ->exists();

        Log::debug("Đang kiểm tra giá trị: $val | Tồn tại: " . ($exists ? 'true' : 'false'));

        if ($exists) {
            $isUsed = true;
            break;
        }
    }

    if ($isUsed) {
        return redirect()->route('admin.product_options.index')
            ->with('error', 'Không thể xoá: Thuộc tính đang được sử dụng trong sản phẩm.');
    }

    DB::table('product_options')->where('id', $id)->update(['deleted_at' => now()]);

    return redirect()->route('admin.product_options.index')->with('success', 'Xóa thuộc tính thành công.');
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

}
