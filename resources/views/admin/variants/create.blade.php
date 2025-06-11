@extends('layouts.admin')

@section('title', 'Thêm biến thể sản phẩm')

@section('content')
<h1>Thêm biến thể</h1>

<a href="{{ route('admin.variants.index') }}" class="btn btn-secondary mb-3">Quay lại danh sách</a>

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('admin.variants.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label for="product_id">Sản phẩm</label>
        <select name="product_id" id="product_id" class="form-control" required>
            <option value="">-- Chọn sản phẩm --</option>
            @foreach ($products as $product)
                <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                    {{ $product->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="sku">SKU</label>
        <input type="text" name="sku" id="sku" class="form-control" value="{{ old('sku') }}" required>
    </div>

    <div class="mb-3">
        <label for="variant_name">Tên biến thể</label>
        <input type="text" name="variant_name" id="variant_name" class="form-control" value="{{ old('variant_name') }}" required>
    </div>

    <div class="mb-3">
        <label for="price">Giá</label>
        <input type="number" name="price" id="price" class="form-control" step="0.01" value="{{ old('price') }}" required>
    </div>

    <div class="mb-3">
        <label for="stock_quantity">Số lượng tồn kho</label>
        <input type="number" name="stock_quantity" id="stock_quantity" class="form-control" value="{{ old('stock_quantity') }}" required>
    </div>

    <div class="mb-3">
        <label for="image">Ảnh biến thể</label>
        <input type="file" name="image" id="image" class="form-control" accept="image/*">
    </div>

    <button type="submit" class="btn btn-success">Lưu biến thể</button>
</form>

@endsection