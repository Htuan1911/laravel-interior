@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Thêm bài viết mới</h2>

    <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label>Tiêu đề</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Slug</label>
            <input type="text" name="slug" id="slug" class="form-control">
        </div>

        <div class="mb-3">
            <label>Nội dung</label>
            <textarea name="content" class="form-control" rows="5"></textarea>
        </div>

        <div class="mb-3">
            <label>Hình ảnh (thumbnail)</label>
            <input type="file" name="thumbnail" class="form-control">
        </div>

        <div class="mb-3">
            <label>Danh mục</label>
            <select name="category_id" class="form-control">
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Trạng thái</label>
            <select name="status" class="form-control">
                <option value="draft">Nháp</option>
                <option value="published">Xuất bản</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Lưu</button>
    </form>
</div>

{{-- ✅ JS tạo slug tự động --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const titleInput = document.getElementById("title");
        const slugInput = document.getElementById("slug");

        function generateSlug(text) {
            return text.toLowerCase()
                .normalize('NFD')                    // Tách dấu
                .replace(/[\u0300-\u036f]/g, '')     // Xoá dấu
                .replace(/[^a-z0-9 -]/g, '')         // Xoá ký tự đặc biệt
                .replace(/\s+/g, '-')                // Thay khoảng trắng bằng -
                .replace(/-+/g, '-')                 // Xoá dấu - lặp
                .replace(/^-+|-+$/g, '');            // Xoá - ở đầu/cuối
        }

        titleInput.addEventListener("input", function () {
            // Chỉ tạo slug nếu người dùng chưa nhập tay
            if (!slugInput.value.trim()) {
                slugInput.value = generateSlug(titleInput.value);
            }
        });
    });
</script>
@endsection
