<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\PostCategory;


class PostCategoryController extends Controller
{
public function index()
{
    $postCategories = DB::table('post_categories')->get(); 

    return view('admin.post_categories.index', compact('postCategories'));
}


    public function create()
    {
        return view('admin.post_categories.create');
    }

public function store(Request $request)
{
    // Validate từng trường thủ công
    $request->validate([
        'name' => 'required|string|max:255',
        'slug' => 'nullable|string|max:255|unique:post_categories,slug',
    ]);

    $name = $request->input('name');
    $slug = $request->input('slug');

    // Nếu không nhập slug thì tự tạo
    if (empty($slug)) {
        $slug = Str::slug($name);

        // Nếu trùng thì thêm số phía sau cho unique
        $originalSlug = $slug;
        $i = 1;
        while (PostCategory::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $i++;
        }
    }

    // Tạo bản ghi mới
    $category = new PostCategory();
    $category->name = $name;
    $category->slug = $slug;
    $category->save();

    return redirect()->route('admin.post_categories.index')->with('success', 'Thêm danh mục thành công!');
}

    public function edit($id)
    {
        $category = DB::table('post_categories')->where('id', $id)->first();
        return view('admin.post_categories.edit', compact('category'));
    }

      public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $name = $request->input('name');
        $slug = Str::slug($name);

        DB::table('post_categories')->where('id', $id)->update([
            'name' => $name,
            'slug' => $slug,
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.post_categories.index')->with('success', 'Cập nhật danh mục thành công!');
    }

     public function destroy($id)
    {
        DB::table('post_categories')->where('id', $id)->delete();
        return redirect()->route('admin.post_categories.index')->with('success', 'Xóa danh mục thành công!');
    }
}
