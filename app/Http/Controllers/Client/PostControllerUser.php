<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class PostControllerUser extends Controller
{
    public function index()
    {
        // Hiển thị danh sách bài viết (chỉ những bài đăng status = 1)
        $posts = Post::where('status', 2)->orderBy('created_at', 'desc')->paginate(6);
        return view('client.blog.index', compact('posts'));
    }

    public function show($slug)
    {
        // Hiển thị chi tiết bài viết theo slug
        $post = Post::where('slug', $slug)->where('status', 2)->firstOrFail();
        return view('client.blog.show', compact('post'));
    }
}
