<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // đảm bảo người dùng đã đăng nhập
    }

    // Danh sách bài viết
    public function index(Request $request)
    {
        $categoryId = $request->category_id;

        $query = DB::table('posts')
            ->leftJoin('post_categories', 'posts.category_id', '=', 'post_categories.id')
            ->join('users', 'posts.user_id', '=', 'users.id')
            ->select(
                'posts.*',
                'post_categories.name as category_name',
                'users.name as user_name'
            )
            ->orderByDesc('posts.created_at');

        if (!empty($categoryId)) {
            $query->where('posts.category_id', $categoryId);
        }

        $posts = $query->paginate(10)->withQueryString();
        $categories = DB::table('post_categories')->select('id', 'name')->get();

        return view('admin.posts.index', compact('posts', 'categories'));
    }

    // Form thêm mới
    public function create()
    {
        $categories = DB::table('post_categories')->get();
        return view('admin.posts.create', compact('categories'));
    }

    // Lưu bài viết mới
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'       => 'required|string|max:255',
            'slug'        => 'required|string|max:255|unique:posts,slug',
            'content'     => 'required|string',
            'category_id' => 'required|exists:post_categories,id',
            'thumbnail'   => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status'      => 'nullable|in:draft,published',
        ]);

        // Kiểm tra tiêu đề trùng trong cùng danh mục
        $validator->after(function ($validator) use ($request) {
            $exists = DB::table('posts')
                ->where('category_id', $request->category_id)
                ->whereRaw('LOWER(title) = ?', [strtolower($request->title)])
                ->exists();

            if ($exists) {
                $validator->errors()->add('title', 'Tiêu đề đã tồn tại trong danh mục này.');
            }
        });

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $slug = Str::slug($request->title);

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/posts'), $fileName);
            $thumbnailPath = 'uploads/posts/' . $fileName;
        }

        DB::table('posts')->insert([
            'title'       => $request->title,
            'slug'        => $slug,
            'content' => $request->input('content'),
            'category_id' => $request->category_id,
            'thumbnail'   => $thumbnailPath,
            'status'      => $request->status ?? 'draft',
            'user_id'     => Auth::id(),
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        return redirect()->route('admin.posts.index')->with('success', 'Bài viết đã được thêm thành công.');
    }

    // Form sửa
    public function edit($id)
    {
        $post = DB::table('posts')->where('id', $id)->first();
        $categories = DB::table('post_categories')->get();

        if (!$post) {
            return redirect()->route('admin.posts.index')->with('error', 'Bài viết không tồn tại.');
        }

        return view('admin.posts.edit', compact('post', 'categories'));
    }

    // Cập nhật bài viết
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title'       => 'required|max:255',
            'slug'        => 'required|string|max:255|unique:posts,slug,' . $id,
            'content'     => 'required|string',
            'category_id' => 'required|exists:post_categories,id',
            'thumbnail'   => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status'      => 'nullable|in:draft,published',
        ]);

        $validator->after(function ($validator) use ($request, $id) {
            $exists = DB::table('posts')
                ->where('title', $request->title)
                ->where('category_id', $request->category_id)
                ->where('id', '<>', $id)
                ->exists();

            if ($exists) {
                $validator->errors()->add('title', 'Tiêu đề đã tồn tại trong danh mục này.');
            }
        });

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $post = DB::table('posts')->where('id', $id)->first();
        if (!$post) {
            return redirect()->route('admin.posts.index')->with('error', 'Bài viết không tồn tại.');
        }

        $thumbnail = $post->thumbnail;
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/posts'), $fileName);
            $thumbnail = 'uploads/posts/' . $fileName;
        }

        DB::table('posts')->where('id', $id)->update([
            'title'       => $request->title,
            'slug'        => Str::slug($request->title),
            'content' => $request->input('content'),
            'thumbnail'   => $thumbnail,
            'category_id' => $request->category_id,
            'status'      => $request->status ?? 'draft',
            'updated_at'  => now(),
        ]);

        return redirect()->route('admin.posts.index')->with('success', 'Cập nhật bài viết thành công.');
    }

    // Xóa bài viết
    public function destroy($id)
    {
        $post = DB::table('posts')->where('id', $id)->first();

        if (!$post) {
            return redirect()->route('admin.posts.index')->with('error', 'Bài viết không tồn tại.');
        }

        DB::table('posts')->where('id', $id)->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Đã xóa bài viết.');
    }

    // Xem chi tiết
    public function show($id)
    {
        $post = DB::table('posts')
            ->leftJoin('post_categories', 'posts.category_id', '=', 'post_categories.id')
            ->select('posts.*', 'post_categories.name as category_name')
            ->where('posts.id', $id)
            ->first();

        if (!$post) {
            return redirect()->route('admin.posts.index')->with('error', 'Bài viết không tồn tại.');
        }

        return view('admin.posts.show', compact('post'));
    }
}
