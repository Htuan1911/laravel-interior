@extends('layouts.admin')

@section('content')
<div class="container mt-4 mb-5">
    <h3>Thêm Sản Phẩm Nội Thất</h3>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="product-form">
        @csrf

        <!-- Thông tin sản phẩm -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label>Tên sản phẩm *</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label>Danh mục</label>
                <select name="category_id" id="category-select" class="form-select" required>
                    <option value="">-- Chọn danh mục --</option>
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
            <div class="col-md-4"><input type="text" name="material" class="form-control" placeholder="Chất liệu...">
            </div>
            <div class="col-md-4"><input type="text" name="dimensions" class="form-control" placeholder="Kích thước...">
            </div>
            <div class="col-md-4"><input type="text" name="style" class="form-control" placeholder="Phong cách...">
            </div>
        </div>

        <!-- Biến thể sản phẩm -->
        <h5>Biến thể sản phẩm</h5>

        <!-- Thủ công -->
        <div class="row mb-3">
            <div class="col-md-3">
                <select id="color" class="form-select">
                    <option value="">-- Màu sắc --</option>
                </select>
            </div>
            <div class="col-md-3">
                <select id="material" class="form-select">
                    <option value="">-- Chất liệu --</option>
                </select>
            </div>
            <div class="col-md-3">
                <select id="size" class="form-select">
                    <option value="">-- Kích thước --</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="button" class="btn btn-primary w-100" onclick="addManualVariant()">Tạo biến thể</button>
            </div>
        </div>

        <!-- Tự động -->
        <div class="mb-3">
            <button type="button" class="btn btn-warning" id="generate-variants-btn" disabled>Tự động tạo biến
                thể</button>
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
    let allOptions = {};

    document.getElementById('category-select').addEventListener('change', function () {
        const categoryId = this.value;
        document.getElementById('generate-variants-btn').disabled = true;

    fetch(`/auth/products/category/${categoryId}/options`)
        
            .then(response => response.json())
            .then(data => {
                allOptions = data;
                document.getElementById('generate-variants-btn').disabled = false;

                // Populate dropdowns for thủ công
                const colorSelect = document.getElementById('color');
                const materialSelect = document.getElementById('material');
                const sizeSelect = document.getElementById('size');

                colorSelect.innerHTML = '<option value="">-- Màu sắc --</option>';
                materialSelect.innerHTML = '<option value="">-- Chất liệu --</option>';
                sizeSelect.innerHTML = '<option value="">-- Kích thước --</option>';

                data.colors.forEach(item => {
                    colorSelect.innerHTML += `<option value="${item.value}">${item.value}</option>`;
                });
                data.materials.forEach(item => {
                    materialSelect.innerHTML += `<option value="${item.value}">${item.value}</option>`;
                });
                data.sizes.forEach(item => {
                    sizeSelect.innerHTML += `<option value="${item.value}">${item.value}</option>`;
                });
            })
            .catch(error => {
                console.error('Lỗi khi lấy thuộc tính:', error);
            });
            console.log("Category ID đã chọn:", categoryId);
    });

    // Tự động tạo biến thể
    document.getElementById('generate-variants-btn').addEventListener('click', function () {
        const colors = allOptions.colors || [];
        const materials = allOptions.materials || [];
        const sizes = allOptions.sizes || [];

        if (!colors.length || !materials.length || !sizes.length) {
            alert("Danh mục này chưa có đầy đủ thuộc tính để tạo biến thể.");
            return;
        }

        colors.forEach(color => {
            materials.forEach(material => {
                sizes.forEach(size => {
                    addVariant(color.value, material.value, size.value);
                });
            });
        });
    });

    // Thêm biến thể thủ công
    function addManualVariant() {
        const color = document.getElementById('color').value;
        const material = document.getElementById('material').value;
        const size = document.getElementById('size').value;

        if (!color || !material || !size) {
            alert("Vui lòng chọn đầy đủ thuộc tính");
            return;
        }

        addVariant(color, material, size);
    }

    // Hàm thêm biến thể chung
    function addVariant(color, material, size) {
        const name = `${color} - ${material} - ${size}`;
        const html = `
            <div class="card p-3 mb-3 variant-card">
                <h6>Biến thể ${variantCount + 1}: ${name}</h6>
                <input type="hidden" name="variants[${variantCount}][name]" value="${name}">
                <input type="hidden" name="variants[${variantCount}][color]" value="${color}">
                <input type="hidden" name="variants[${variantCount}][material]" value="${material}">
                <input type="hidden" name="variants[${variantCount}][size]" value="${size}">
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
                <button type="button" class="btn btn-danger btn-sm mt-2" onclick="removeVariant(this)">❌ Xoá biến thể</button>
            </div>
        `;
        document.getElementById('variants-container').insertAdjacentHTML('beforeend', html);
        variantCount++;
    }

    function removeVariant(btn) {
        if (confirm("Bạn có chắc muốn xoá biến thể này không?")) {
            btn.closest('.variant-card').remove();
        }
    }
</script>
@endsection