@extends('layouts.admin')

@section('title', 'Thêm sản phẩm mới')

@section('content')
<h1>Thêm sản phẩm không có biến thể</h1>

<a href="{{ route('admin.products_without_variants.index') }}" class="btn btn-secondary mb-3">Quay lại danh sách</a>

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('admin.products_without_variants.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
        <div class="mb-3">
        <label for="name_vi">Tên sản phẩm (Tiếng Việt)</label>
        <input type="text" name="name_vi" id="name_vi" class="form-control" value="{{ old('name_vi') }}" required>
    </div>
    <div class="mb-3">
        <label for="category_id">Danh mục</label>
        <select name="category_id" id="category_id" class="form-control" required>
            <option value="">-- Chọn danh mục --</option>
            @foreach ($categories as $category)
            <option value="{{ $category->id }}" {{ old('category_id')==$category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
            @endforeach
        </select>
    </div>

     <div class="mb-3">
        <label for="base_price">Giá sản phẩm</label>
        <input type="number" name="base_price" id="base_price" class="form-control" step="0.01"
            value="{{ old('base_price') }}" required>
    </div>

    <div class="mb-3">
        <label for="description_vi">Mô tả (Tiếng Việt)</label>
        <textarea name="description_vi" id="description_vi" class="form-control">{{ old('description_vi') }}</textarea>
    </div>

    <div class="mb-3">
        <label for="name_en">Tên sản phẩm (Tiếng Anh)</label>
        <input type="text" name="name_en" id="name_en" class="form-control" value="{{ old('name_en') }}" required>
    </div>

    <div class="mb-3">
        <label for="description_en">Mô tả (Tiếng Anh)</label>
        <textarea name="description_en" id="description_en" class="form-control">{{ old('description_en') }}</textarea>
    </div>

   

    <div class="mb-3">
        <label for="image">Ảnh chính</label>
        <input type="file" name="image" id="image" class="form-control" accept=".jpg,.jpeg,.png" required>
    </div>

    <div class="mb-3">
        <label for="alt_text">Chú thích ảnh</label>
        <input type="text" name="alt_text" id="alt_text" class="form-control" value="{{ old('alt_text') }}">
    </div>

    <button type="submit" class="btn btn-success">Lưu sản phẩm</button>
</form>
@endsection