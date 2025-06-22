@extends('layouts.admin')

@section('title', 'Sửa biến thể sản phẩm')

@section('content')
<h1>Sửa biến thể sản phẩm</h1>

{{-- Hiển thị lỗi --}}
@if ($errors->any())
<div class="alert alert-danger">
    <strong>Đã xảy ra lỗi:</strong>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<form action="{{ route('admin.products.update', $variant->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="product_id">Chọn sản phẩm</label>
        <select id="product_id" name="product_id" class="form-select">
            <option value="">-- Chọn sản phẩm --</option>
            @foreach ($products as $product)
            <option value="{{ $product->id }}" {{ $product->id == $variant->product_id ? 'selected' : '' }}>
                {{ $product->name }}
            </option>
            @endforeach
        </select>
    </div>

    <div id="product-info" class="mb-4" style="{{ $productInfo ? '' : 'display: none;' }}">
        <div class="mb-2">
            <label>Tên sản phẩm (Tiếng Việt)</label>
            <input type="text" id="product_name" class="form-control" value="{{ $productInfo->product_name ?? '' }}" readonly>
        </div>
        <div class="mb-2">
            <label>Danh mục</label>
            <input type="text" id="product_category" class="form-control" value="{{ $productInfo->category_name ?? '' }}" readonly>
        </div>
        <div class="mb-2">
            <label>Giá sản phẩm</label>
            <input type="text" id="product_base_price" class="form-control" value="{{ $productInfo->base_price ?? '' }}" readonly>
        </div>
    </div>

    <div class="mb-3">
        <label for="sku">Chọn SKU</label>
        <select id="sku" name="sku" class="form-select">
            <option value="">-- Chọn SKU --</option>
            @foreach ($skus as $skuItem)
            <option value="{{ $skuItem->sku }}" {{ $skuItem->sku == $variant->sku ? 'selected' : '' }}>
                {{ $skuItem->sku }}
            </option>
            @endforeach
        </select>
    </div>

    <div id="variant-info" class="mb-4" style="{{ $variant ? '' : 'display: none;' }}">
        <div class="mb-2">
            <label>Tên biến thể</label>
            <input type="text" id="variant_name" name="variant_name" value="{{ $variant->variant_name }}" class="form-control" readonly>
        </div>
        <div class="mb-2">
            <label>Giá biến thể</label>
            <input type="text" id="variant_price" name="variant_price" value="{{ $variant->price }}" class="form-control" readonly>
        </div>
        <div class="mb-2">
            <label>Tồn kho</label>
            <input type="text" id="variant_stock" name="variant_stock" value="{{ $variant->stock_quantity }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Ảnh hiện tại:</label><br>
            @if ($variant->image)
            <img src="{{ asset('storage/' . $variant->image) }}" width="150" id="preview_image">
            @else
            <img src="" style="display: none;" id="preview_image" width="150">
            @endif
        </div>
    </div>

    <div class="mb-3">
        <label for="variant_image">Cập nhật ảnh biến thể (nếu muốn)</label>
        <input type="file" name="variant_image" id="variant_image" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">Cập nhật</button>
</form>
@endsection

@section('scripts')
<script>
    // Chỉ chạy khi người dùng thật sự thay đổi product_id, không khi vừa load trang
    document.addEventListener('DOMContentLoaded', function () {
        const productSelect = document.getElementById('product_id');
        const skuSelect = document.getElementById('sku');

        let initialProduct = productSelect.value;
        let initialSku = skuSelect.value;

        productSelect.addEventListener('change', function () {
            if (this.value !== initialProduct) {
                fetch(`/admin/products/${this.value}/info`)
                    .then(res => res.json())
                    .then(data => {
                        document.getElementById('product-info').style.display = 'block';
                        document.getElementById('product_name').value = data.product_name;
                        document.getElementById('product_category').value = data.category_name;
                        document.getElementById('product_base_price').value = data.base_price;
                    });
            }
        });

        skuSelect.addEventListener('change', function () {
            if (this.value !== initialSku) {
                fetch(`/admin/variants/${this.value}/info`)
                    .then(res => res.json())
                    .then(data => {
                        document.getElementById('variant-info').style.display = 'block';
                        document.getElementById('variant_name').value = data.variant_name;
                        document.getElementById('variant_price').value = data.price;
                        document.getElementById('variant_stock').value = data.stock_quantity;

                        if (data.image) {
                            document.getElementById('preview_image').src = '/storage/' + data.image;
                            document.getElementById('preview_image').style.display = 'block';
                        }
                    });
            }
        });
    });
</script>

@endsection
