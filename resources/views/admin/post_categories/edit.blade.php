@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Sửa danh mục bài viết</h2>

    @if ($errors->any())
    <div class="alert alert-danger mt-2">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.post_categories.update', $category->id) }}" method="POST" class="mt-3">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Tên danh mục</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $category->name) }}"
                required>
        </div>

        <div class="mb-3">
            <label for="slug" class="form-label">Slug (URL)</label>
            <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug', $category->slug) }}">
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('admin.post_categories.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>

<script>
    // Tự động tạo slug từ name
    document.getElementById('name').addEventListener('input', function () {
        const name = this.value;
        const slug = name.toLowerCase().trim()
            .replace(/[^\w\s-]/g, '') // Xóa ký tự đặc biệt
            .replace(/\s+/g, '-')     // Thay khoảng trắng bằng dấu -
            .replace(/-+/g, '-');     // Xóa trùng dấu -
        document.getElementById('slug').value = slug;
    });
</script>
@endsection