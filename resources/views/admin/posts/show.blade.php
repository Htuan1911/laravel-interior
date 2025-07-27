@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Chi tiết bài viết</h3>
        </div>
        <div class="card-body">
            <h4 class="card-title">{{ $post->title }}</h4>
            <p><strong>Slug:</strong> {{ $post->slug }}</p>
            <p><strong>Trạng thái:</strong> 
                @if($post->status == 1)
                    <span class="badge bg-success">Hiển thị</span>
                @else
                    <span class="badge bg-secondary">Ẩn</span>
                @endif
            </p>
            <p><strong>Danh mục:</strong> {{ $post->category_id }}</p>
            <p><strong>Người đăng:</strong> {{ $post->user_id }}</p>
            <p><strong>Ngày tạo:</strong> {{ \Carbon\Carbon::parse($post->created_at)->format('d/m/Y H:i') }}</p>

            @if($post->thumbnail)
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="Ảnh bìa" class="img-fluid rounded">
                </div>
            @endif

            <div class="mt-4">
                <h5>Nội dung:</h5>
                <div class="border p-3" style="white-space: pre-wrap;">{!! $post->content !!}</div>
            </div>
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-warning">Sửa</a>
            <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">Quay lại</a>
        </div>
    </div>
</div>
@endsection
