@extends('layouts.admin')

@section('title', 'Chỉnh sửa sản phẩm')

@section('content')
<h1>Chỉnh sửa sản phẩm</h1>

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

<form action="{{ route('admin.products_without_variants.update', $product->id) }}" method="POST"
    enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="category_id">Danh mục</label>
        <select name="category_id" id="category_id" class="form-control" required>
            <option value="">-- Chọn danh mục --</option>
            @foreach ($categories as $category)
            <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="name_vi">Tên sản phẩm (Tiếng Việt)</label>
        <input type="text" name="name_vi" id="name_vi" class="form-control"
            value="{{ old('name_vi', $translation_vi->name ?? '') }}" required>
    </div>

    <div class="mb-3">
        <label for="description_vi">Mô tả (Tiếng Việt)</label>
        <textarea name="description_vi" id="description_vi"
            class="form-control">{{ old('description_vi', $translation_vi->description ?? '') }}</textarea>
    </div>

    <div class="mb-3">
        <label for="base_price">Giá sản phẩm</label>
        <input type="number" name="base_price" id="base_price" class="form-control" step="0.01"
            value="{{ old('base_price', $product->base_price) }}" required>
    </div>

    <div class="mb-3">
        <label for="image">Ảnh chính</label>
        @if ($image && $image->url)
        <div class="mb-2">
            <img src="{{ asset('storage/' . $image->url) }}" alt="{{ $image->alt_text }}" style="max-height: 150px;">
        </div>
        @endif
        <input type="file" name="image" id="image" class="form-control">
    </div>

    <div class="mb-3">
        <label for="alt_text">Chú thích ảnh</label>
        <input type="text" name="alt_text" id="alt_text" class="form-control"
            value="{{ old('alt_text', $image->alt_text ?? '') }}">
    </div>

    <button type="submit" class="btn btn-primary">Cập nhật sản phẩm</button>
</form>
@endsection