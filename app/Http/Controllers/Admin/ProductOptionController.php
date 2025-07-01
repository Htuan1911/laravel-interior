<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
        $request->validate([
            'name' => 'required|string|max:100',
            'type' => 'required|string|in:color,size,material',
            'status' => 'required|boolean',
            'category_id' => 'required|integer|exists:categories,id',
            'values' => 'required|array|min:1',
            'values.*' => 'required|string|max:100',
            'color_codes' => 'array',
        ]);

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

            foreach ($request->values as $index => $value) {
                DB::table('product_option_values')->insert([
                    'product_option_id' => $optionId,
                    'value' => $value,
                    'color_code' => $request->type === 'color' ? $request->color_codes[$index] ?? null : null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::commit();
            return redirect()->route('admin.product_options.index')->with('success', 'Tạo thuộc tính thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

   public function edit($id)
{
    $option = DB::table('product_options')->where('id', $id)->first();

    if (!$option) {
        return back()->with('error', 'Không tìm thấy thuộc tính.');
    }

    // ✅ Gán thủ công thuộc tính values
    $option->values = DB::table('product_option_values')
        ->where('product_option_id', $option->id)
        ->get();

    $categories = DB::table('categories')
        ->leftJoin('category_translations', 'categories.id', '=', 'category_translations.category_id')
        ->where('category_translations.language_code', 'vi')
        ->select('categories.id', 'category_translations.name')
        ->get();

    return view('admin.product_options.edit', compact('option', 'categories'));
}


   public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:100',
        'type' => 'required|string|in:color,size,material',
        'status' => 'required|boolean',
        'category_id' => 'required|exists:categories,id',
        'values' => 'required|array|min:1',
        'values.*' => 'required|string|max:100',
        'color_codes' => 'array',
    ]);

    DB::beginTransaction();
    try {
        // Cập nhật thuộc tính
        DB::table('product_options')->where('id', $id)->update([
            'name' => $request->name,
            'type' => $request->type,
            'status' => $request->status,
            'category_id' => $request->category_id,
            'updated_at' => now(),
        ]);

        // Xoá hết giá trị cũ
        DB::table('product_option_values')->where('product_option_id', $id)->delete();

        // Thêm lại các giá trị mới
        foreach ($request->values as $index => $value) {
            DB::table('product_option_values')->insert([
                'product_option_id' => $id,
                'value' => $value,
                'color_code' => $request->type === 'color' ? ($request->color_codes[$index] ?? null) : null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        DB::commit();
        return redirect()->route('admin.product_options.index')->with('success', 'Cập nhật thuộc tính thành công.');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Lỗi: ' . $e->getMessage());
    }
}


    public function destroy($id)
    {
        DB::table('product_options')->where('id', $id)->update([
            'deleted_at' => now(),
        ]);

        return redirect()->route('admin.product_options.index')->with('success', 'Đã xóa thuộc tính (soft delete).');
    }

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

    public function editValue($id)
    {
        $value = DB::table('product_option_values')->where('id', $id)->first();
        if (!$value) return redirect()->back()->with('error', 'Không tìm thấy giá trị.');

        return view('admin.product_options.edit_value', compact('value'));
    }

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

}
