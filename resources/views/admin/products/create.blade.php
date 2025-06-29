@extends('layouts.admin')

@section('content')
<div class="container mt-4 mb-5">
    <h3>Thêm Sản Phẩm Nội Thất</h3>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="product-form">
        @csrf

        <div class="row mb-3">
            <div class="col-md-6">
                <label>Tên sản phẩm *</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label>Danh mục</label>
                <select name="category_id" class="form-select">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label>Bảo hành (tháng)</label>
                <input type="number" name="warranty_months" class="form-control" value="12">
            </div>
        </div>

        <div class="mb-3">
            <label>Mô tả chi tiết</label>
            <textarea name="description" class="form-control" rows="4"></textarea>
        </div>

        <div class="mb-3">
            <label>Ảnh sản phẩm chính *</label>
            <input type="file" name="image" class="form-control" required>
        </div>

        <h5>Thông số kỹ thuật</h5>
        <div class="row mb-3">
            <div class="col-md-4"><input type="text" name="material" class="form-control" placeholder="Chất liệu..."></div>
            <div class="col-md-4"><input type="text" name="dimensions" class="form-control" placeholder="Kích thước..."></div>
            <div class="col-md-4"><input type="text" name="style" class="form-control" placeholder="Phong cách..."></div>
        </div>

        <h5>Thuộc tính biến thể</h5>
        <div class="row mb-3">
            <div class="col-md-3">
                <select id="color" class="form-select">
                    <option value="">-- Màu sắc --</option>
                    @foreach($colors as $color)
                        <option value="{{ $color->value }}">{{ $color->value }} ({{ $color->color_code }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select id="material" class="form-select">
                    <option value="">-- Chất liệu --</option>
                    @foreach($materials as $material)
                        <option value="{{ $material->value }}">{{ $material->value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select id="size" class="form-select">
                    <option value="">-- Kích thước --</option>
                    @foreach($sizes as $size)
                        <option value="{{ $size->value }}">{{ $size->value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <button type="button" class="btn btn-primary w-100" onclick="addVariant()">Tạo biến thể</button>
            </div>
        </div>

        <div id="variants-container"></div>

        <div class="mt-4 text-end">
            <button type="submit" class="btn btn-success">Tạo sản phẩm</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Huỷ</a>
        </div>
    </form>
</div>

<script>
    let variantCount = 0;

    function addVariant() {
        const color = document.getElementById('color');
        const material = document.getElementById('material');
        const size = document.getElementById('size');

        if (!color.value || !material.value || !size.value) {
            alert("Vui lòng chọn đầy đủ màu, chất liệu và kích thước");
            return;
        }

        const variantName = `${color.value} - ${material.value} - ${size.value}`;

        const html = `
        <div class="card p-3 mb-3">
            <h6>Biến thể ${variantCount + 1}: ${variantName}</h6>
            <input type="hidden" name="variants[${variantCount}][name]" value="${variantName}">
            <input type="hidden" name="variants[${variantCount}][color]" value="${color.value}">
            <div class="row">
                <div class="col-md-3"><input name="variants[${variantCount}][sku]" class="form-control" placeholder="SKU"></div>
                <div class="col-md-3"><input name="variants[${variantCount}][price]" class="form-control" placeholder="Giá bán" type="number"></div>
                <div class="col-md-3"><input name="variants[${variantCount}][stock_quantity]" class="form-control" placeholder="Tồn kho" type="number"></div>
                <div class="col-md-3"><input name="variants[${variantCount}][weight]" class="form-control" placeholder="Khối lượng (kg)" type="number"></div>
            </div>
            <div class="mt-2">
                <label>Ảnh biến thể:</label>
                <input type="file" name="variants[${variantCount}][image]" class="form-control">
            </div>
        </div>`;
        
        document.getElementById('variants-container').insertAdjacentHTML('beforeend', html);
        variantCount++;
    }
</script>
@endsection
