@extends('layouts.admin')

@section('title', 'Sửa biến thể')

@section('content')
<h1>Sửa biến thể</h1>

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

<form action="{{ route('admin.variants.update', $variant->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="sku">SKU</label>
        <input type="text" name="sku" value="{{ $variant->sku }}" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="variant_name">Tên biến thể</label>
        <input type="text" name="variant_name" value="{{ $variant->variant_name }}" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="price">Giá</label>
        <input type="number" name="price" value="{{ $variant->price }}" class="form-control" step="0.01" required>
    </div>

    <div class="mb-3">
        <label for="stock_quantity">Số lượng</label>
        <input type="number" name="stock_quantity" value="{{ $variant->stock_quantity }}" class="form-control" required>
    </div>

     <div class="mb-3">
        <label for="image">Ảnh biến thể</label><br>
        @if($variant->image)
            <img src="{{ asset('storage/' . $variant->image) }}" alt="Ảnh hiện tại" width="120">
        @endif
        <input type="file" name="image" id="image" class="form-control mt-2">
    </div>

    <button type="submit" class="btn btn-primary">Cập nhật</button>
</form>
@endsection
