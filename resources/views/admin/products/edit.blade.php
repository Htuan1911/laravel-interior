@extends('layouts.admin')

@section('content')
<div class="container mt-4 mb-5">
    <h3>Cập nhật sản phẩm</h3>

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row mb-3">
            <div class="col-md-6">
                <label>Tên sản phẩm *</label>
                <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
            </div>
            <div class="col-md-3">
                <label>Danh mục</label>
                <select name="category_id" class="form-select">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label>Bảo hành (tháng)</label>
                <input type="number" name="warranty_months" class="form-control" value="{{ $product->warranty_months }}">
            </div>
        </div>

        <div class="mb-3">
            <label>Mô tả</label>
            <textarea name="description" class="form-control" rows="4">{{ $product->description }}</textarea>
        </div>

        <h5>Thông số kỹ thuật</h5>
        <div class="row mb-3">
            <div class="col-md-4">
                <input type="text" name="material" class="form-control" value="{{ $product->material }}" placeholder="Chất liệu...">
            </div>
            <div class="col-md-4">
                <input type="text" name="dimensions" class="form-control" value="{{ $product->dimensions }}" placeholder="Kích thước...">
            </div>
            <div class="col-md-4">
                <input type="text" name="style" class="form-control" value="{{ $product->style }}" placeholder="Phong cách...">
            </div>
        </div>

        <div class="mb-3">
            <label>Ảnh chính sản phẩm</label><br>
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="" width="120">
            @endif
            <input type="file" name="image" class="form-control mt-2">
        </div>

        <h5>Biến thể</h5>
        @foreach($variants as $index => $variant)
        <div class="card p-3 mb-3">
            <input type="hidden" name="variants[{{ $index }}][id]" value="{{ $variant->id }}">
            <div class="row mb-2">
                <div class="col-md-6">
                    <label>Tên biến thể</label>
                    <input type="text" name="variants[{{ $index }}][name]" value="{{ $variant->name }}" class="form-control">
                </div>
                <div class="col-md-3">
                    <label>SKU</label>
                    <input type="text" name="variants[{{ $index }}][sku]" value="{{ $variant->sku }}" class="form-control">
                </div>
                <div class="col-md-3">
                    <label>Màu sắc</label>
                    <input type="text" name="variants[{{ $index }}][color]" value="{{ $variant->color }}" class="form-control">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-3">
                    <label>Giá</label>
                    <input type="number" name="variants[{{ $index }}][price]" value="{{ $variant->price }}" class="form-control">
                </div>
                <div class="col-md-3">
                    <label>Tồn kho</label>
                    <input type="number" name="variants[{{ $index }}][stock_quantity]" value="{{ $variant->stock_quantity }}" class="form-control">
                </div>
                <div class="col-md-3">
                    <label>Khối lượng (kg)</label>
                    <input type="number" name="variants[{{ $index }}][weight]" value="{{ $variant->weight }}" class="form-control">
                </div>
                <div class="col-md-3">
                    <label>Ảnh biến thể</label><br>
                    @if($variant->image)
                        <img src="{{ asset('storage/' . $variant->image) }}" width="60">
                    @endif
                    <input type="file" name="variants[{{ $index }}][image]" class="form-control mt-2">
                </div>
            </div>
        </div>
        @endforeach

        <div class="text-end mt-4">
            <button type="submit" class="btn btn-success">Cập nhật sản phẩm</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Huỷ</a>
        </div>
    </form>
</div>
@endsection
