<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryTranslation;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('translations')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $languages = Language::all();
        $parentCategories = Category::whereNull('parent_id')->get();
        return view('admin.categories.create', compact('languages', 'parentCategories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'translations.*.name' => 'required|string|max:255',
            'translations.*.language_code' => 'required|exists:languages,code',
            'status' => 'required|in:active,inactive',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $category = Category::create([
            'parent_id' => $request->parent_id,
            'status' => $request->status,
        ]);

        foreach ($request->translations as $translation) {
            CategoryTranslation::create([
                'category_id' => $category->id,
                'language_code' => $translation['language_code'],
                'name' => $translation['name'],
                'description' => $translation['description'],
            ]);
        }

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }

    public function edit($id)
    {
        $category = Category::with('translations')->findOrFail($id);
        $languages = Language::all();
        $parentCategories = Category::whereNull('parent_id')->where('id', '!=', $id)->get();
        return view('admin.categories.edit', compact('category', 'languages', 'parentCategories'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'translations.*.name' => 'required|string|max:255',
            'translations.*.language_code' => 'required|exists:languages,code',
            'status' => 'required|in:active,inactive',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $category = Category::findOrFail($id);
        $category->update([
            'parent_id' => $request->parent_id,
            'status' => $request->status,
        ]);

        // Xóa các bản dịch cũ
        CategoryTranslation::where('category_id', $id)->delete();

        // Thêm bản dịch mới
        foreach ($request->translations as $translation) {
            CategoryTranslation::create([
                'category_id' => $category->id,
                'language_code' => $translation['language_code'],
                'name' => $translation['name'],
                'description' => $translation['description'],
            ]);
        }

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }
}