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
        $this->middleware('auth');
        // đảm bảo người dùng đã đăng nhập
    }

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

        // ✳️ lọc theo danh mục nếu có
        if (!empty($categoryId)) {
            $query->where('posts.category_id', $categoryId);
        }

        $posts = $query->paginate(10)->withQueryString();

        // ✳️ lấy danh mục để hiển thị trong select box
        $categories = DB::table('post_categories')->select('id', 'name')->get();

        return view('admin.posts.index', compact('posts', 'categories'));
    }



    public function create()
    {
        $categories = DB::table('post_categories')->get();
        return view('admin.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Bước 1: Validate dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'title'       => 'required|string|max:255',
            'slug'        => 'required|string|max:255|unique:posts,slug',
            'content'     => 'required|string',
            'category_id' => 'required|exists:post_categories,id',
            'thumbnail'   => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status'      => 'nullable|in:draft,published',
        ]);
          //  Kiểm tra tiêu đề trùng trong cùng danh mục
        $validator->after(function ($validator) use ($request) {
        $exists = DB::table('posts')
            ->where('category_id', $request->category_id)
            ->whereRaw('LOWER(title) = ?', [strtolower($request->title)])
            ->exists();

        if ($exists) {
            $validator->errors()->add('title', 'Tiêu đề đã tồn tại trong danh mục này.');
        }
    });

        // Nếu có lỗi thì quay lại với thông báo lỗi
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Bước 2: Tạo slug từ tiêu đề
        $slug = Str::slug($request->title);

        // Bước 3: Xử lý ảnh thumbnail (nếu có)
        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/posts'), $fileName);
            $thumbnailPath = 'uploads/posts/' . $fileName;
        }

        // Bước 4: Lưu dữ liệu vào cơ sở dữ liệu bằng Query Builder
        DB::table('posts')->insert([
            'title'       => $request->title,
            'slug'        => $slug,
            'content'     => $request->content,
            'category_id' => $request->category_id,
            'thumbnail'   => $thumbnailPath,
            'status'      => $request->status ?? 'draft',
            'user_id'     => Auth::id(),
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        // Bước 5: Chuyển hướng và hiển thị thông báo
        return redirect()->route('admin.posts.index')->with('success', 'Bài viết đã được thêm thành công.');
    }


    public function edit($id)
    {
        $post = DB::table('posts')->where('id', $id)->first();
        $categories = DB::table('post_categories')->get();

        if (!$post) {
            return redirect()->route('posts.index')->with('error', 'Bài viết không tồn tại.');
        }

        return view('admin.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title'       => 'required|max:255',
             'slug'        => 'required|string|max:255|unique:posts,slug',
             'content'     => 'required|string',
            'category_id' => 'required|exists:post_categories,id',
            'thumbnail'   => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status'      => 'nullable|in:draft,published',
        ]);
            // Kiểm tra trùng tiêu đề trong danh mục (trừ ID hiện tại)
    $validator->after(function ($validator) use ($request, $id) {
        $exists = DB::table('posts')
            ->where('title', $request->title)
            ->where('category_id', $request->category_id)
            ->where('id', '<>', $id) // Loại trừ chính nó
            ->exists();

        if ($exists) {
            $validator->errors()->add('title', 'Tiêu đề đã tồn tại trong danh mục này.');
        }
    });
        // Nếu có lỗi thì quay lại với thông báo lỗi
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
       // Tìm bài viết theo ID
        $post = DB::table('posts')->where('id', $id)->first();
        if (!$post) {
            return redirect()->route('admin.posts.index')->with('error', 'Bài viết không tồn tại.');
        }
       // Xử lý ảnh thumbnail (nếu có)
        $thumbnail = $post->thumbnail;

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/posts'), $fileName);
            $thumbnail = 'uploads/posts/' . $fileName;
        }
       // Cập nhật dữ liệu vào cơ sở dữ liệu
        DB::table('posts')->where('id', $id)->update([
            'title'       => $request->title,
            'slug'        => Str::slug($request->title),
            'content'     => $request->content,
            'thumbnail'   => $thumbnail,
            'category_id' => $request->category_id,
            'status'      => $request->status ?? 'draft',
            'updated_at'  => now(),
        ]);

        return redirect()->route('admin.posts.index')->with('success', 'Cập nhật bài viết thành công.');
    }

    public function destroy($id)
    {
        $post = DB::table('posts')->where('id', $id)->first();

        if (!$post) {
            return redirect()->route('posts.index')->with('error', 'Bài viết không tồn tại.');
        }

        DB::table('posts')->where('id', $id)->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Đã xóa bài viết.');
    }
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
