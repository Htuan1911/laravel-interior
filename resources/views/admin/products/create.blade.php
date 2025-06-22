@extends('layouts.admin')

@section('title', 'Thêm biến thể sản phẩm')

@section('content')
<h1>Thêm biến thể sản phẩm</h1>

{{-- Hiển thị thông báo lỗi --}}
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

{{-- Hiển thị thông báo thành công --}}
@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label for="product_id">Chọn sản phẩm</label>
        <select id="product_id" name="product_id" class="form-select">
            <option value="">-- Chọn sản phẩm --</option>
            @foreach ($products as $product)
            <option value="{{ $product->id }}">{{ $product->name }}</option>
            @endforeach
        </select>
    </div>

    <div id="product-info" class="mb-4" style="display: none;">
        <div class="mb-2">
            <label>Tên sản phẩm (Tiếng Việt)</label>
            <input type="text" id="product_name" name="product_name" class="form-control" readonly>
        </div>
        <div class="mb-2">
            <label>Danh mục</label>
            <input type="text" id="product_category" name="product_category" class="form-control" readonly>
        </div>
        <div class="mb-2">
            <label>Giá sản phẩm</label>
            <input type="text" id="product_base_price" name="product_base_price" class="form-control" readonly>
        </div>
    </div>

    <div class="mb-3">
        <label for="sku">Chọn SKU</label>
        <select id="sku" name="sku" class="form-select">
            <option value="">-- Chọn SKU --</option>
            @foreach ($skus as $variant)
            <option value="{{ $variant->sku }}" data-name="{{ $variant->variant_name }}"
                data-price="{{ $variant->price }}" data-stock="{{ $variant->stock_quantity }}">
                {{ $variant->sku }}
            </option>
            @endforeach
        </select>
    </div>

    <div id="variant-info" class="mb-4" style="display: none;">
        <div class="mb-2">
            <label>Tên biến thể</label>
            <input type="text" id="variant_name" name="variant_name" class="form-control" readonly>
        </div>
        <div class="mb-2">
            <label>Giá biến thể</label>
            <input type="text" id="variant_price" name="variant_price" class="form-control" readonly>
        </div>
        <div class="mb-2">
            <label>Tồn kho</label>
            <input type="text" id="variant_stock" name="variant_stock" class="form-control" readonly>
        </div>
    </div>

    <div class="mb-3">
        <label for="variant_image">Ảnh biến thể</label>
        <input type="file" name="variant_image" id="variant_image" class="form-control">
    </div>

    <button type="submit" class="btn btn-success">Lưu</button>
</form>
@endsection

@section('scripts')
<script>
    // Tự động hiển thị thông tin sản phẩm khi chọn
    document.getElementById('product_id').addEventListener('change', function () {
        let productId = this.value;
        if (productId) {
            fetch(`/admin/products/${productId}/info`)
                .then(res => res.json())
                .then(data => {
                    document.getElementById('product-info').style.display = 'block';
                    document.getElementById('product_name').value = data.product_name;
                    document.getElementById('product_category').value = data.category_name;
                    document.getElementById('product_base_price').value = data.base_price;
                });
        } else {
            document.getElementById('product-info').style.display = 'none';
        }
    });

    // Tự động hiển thị thông tin biến thể khi chọn SKU
    document.getElementById('sku').addEventListener('change', function () {
        let sku = this.value;
        if (sku) {
            fetch(`/admin/variants/${sku}/info`)
                .then(res => res.json())
                .then(data => {
                    document.getElementById('variant-info').style.display = 'block';
                    document.getElementById('variant_name').value = data.variant_name;
                    document.getElementById('variant_price').value = data.price;
                    document.getElementById('variant_stock').value = data.stock_quantity;
                });
        } else {
            document.getElementById('variant-info').style.display = 'none';
        }
    });
</script>
@endsection