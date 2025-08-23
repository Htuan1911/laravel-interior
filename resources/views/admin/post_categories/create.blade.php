@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <h2>Thêm danh mục bài viết</h2>

    {{-- Hiển thị lỗi nếu có --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Lỗi!</strong> Vui lòng kiểm tra lại dữ liệu nhập vào.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form thêm danh mục --}}
    <form action="{{ route('admin.post_categories.store') }}" method="POST">
        @csrf

        {{-- Tên danh mục --}}
        <div class="form-group mb-3">
            <label for="name">Tên danh mục <span class="text-danger">*</span></label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        {{-- Slug --}}
        <div class="form-group mb-3">
            <label for="slug">Slug (nếu bỏ trống sẽ tự tạo)</label>
            <input type="text" id="slug" name="slug" class="form-control" value="{{ old('slug') }}">
        </div>

        {{-- Nút submit --}}
        <button type="submit" class="btn btn-primary">Thêm mới</button>
        <a href="{{ route('admin.post_categories.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>

{{-- ✅ JS tạo slug tự động --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const nameInput = document.getElementById("name");
        const slugInput = document.getElementById("slug");

        function generateSlug(text) {
            return text.toLowerCase()
                .normalize('NFD')                    // Tách dấu tiếng Việt
                .replace(/[\u0300-\u036f]/g, '')     // Xóa dấu
                .replace(/[^a-z0-9\s-]/g, '')        // Loại ký tự đặc biệt
                .trim()
                .replace(/\s+/g, '-')                // Khoảng trắng -> dấu gạch ngang
                .replace(/-+/g, '-');                // Nhiều dấu '-' thành một
        }

        nameInput.addEventListener("input", function () {
            // Nếu slug đang trống hoặc đã được tự động tạo trước đó thì cập nhật lại
            if (!slugInput.dataset.userTyped || !slugInput.value.trim()) {
                const slug = generateSlug(nameInput.value);
                slugInput.value = slug;
                slugInput.dataset.userTyped = "false"; // Gắn cờ là auto
            }
        });

        slugInput.addEventListener("input", function () {
            // Nếu user tự nhập slug, không ghi đè
            slugInput.dataset.userTyped = "true";
        });
    });
</script>

@endsection
