
@extends('layouts.admin')

@section('content')
<div class="container mt-4 mb-5">
    <h3>Cập nhật sản phẩm</h3>

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" id="product-form">
        @csrf
        @method('PUT')

        <!-- Thông tin sản phẩm -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label>Tên sản phẩm *</label>
                <input type="text" name="name" class="form-control" 
                    value="{{ old('name', $translation->name ?? '') }}" required>
            </div>
            <div class="col-md-3">
                <label>Danh mục</label>
                <select name="category_id" id="category-select" class="form-select" required>
                    <option value="">-- Chọn danh mục --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label>Bảo hành (tháng)</label>
                <input type="number" name="warranty_months" class="form-control" 
                    value="{{ old('warranty_months', $product->warranty_months) }}">
            </div>
        </div>

        <div class="mb-3">
            <label>Mô tả chi tiết</label>
            <textarea name="description" class="form-control" rows="4">{{ old('description', $translation->description ?? '') }}</textarea>
        </div>

        <div class="mb-3">
            <label>Ảnh sản phẩm chính</label><br>
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="" width="120">
            @endif
            <input type="file" name="image" class="form-control mt-2">
        </div>

        <h5>Thông số kỹ thuật</h5>
        <div class="row mb-3">
            <div class="col-md-4">
                <input type="text" name="material" class="form-control" 
                    value="{{ old('material', $translation->material ?? '') }}" placeholder="Chất liệu...">
            </div>
            <div class="col-md-4">
                <input type="text" name="dimensions" class="form-control" 
                    value="{{ old('dimensions', $product->dimensions ?? '') }}" placeholder="Kích thước...">
            </div>
            <div class="col-md-4">
                <input type="text" name="style" class="form-control" 
                    value="{{ old('style', $translation->style ?? '') }}" placeholder="Phong cách...">
            </div>
        </div>

        <!-- Biến thể -->
        <h5>Biến thể sản phẩm</h5>

        <!-- Thêm thủ công -->
        <div class="row mb-3">
            <div class="col-md-3">
                <select id="color" class="form-select">
                    <option value="">-- Màu sắc --</option>
                </select>
            </div>
            <div class="col-md-3">
                <select id="variant_material" class="form-select">
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

        <div class="mb-3">
            <button type="button" class="btn btn-warning" id="generate-variants-btn" disabled>Tự động tạo biến thể</button>
        </div>

        <div id="variants-container">
            <!-- Hiển thị các biến thể đã có -->
            @foreach($variants as $index => $variant)
            <div class="card p-3 mb-3 variant-card">
                <h6>
                    Biến thể {{ $index + 1 }}: 
                    <span class="badge bg-info">{{ $variant->color ?? 'N/A' }}</span>
                    <span class="badge bg-secondary">{{ $variant->material ?? 'N/A' }}</span>
                    <span class="badge bg-warning text-dark">{{ $variant->size ?? 'N/A' }}</span>
                </h6>
                <input type="hidden" name="variants[{{ $index }}][id]" value="{{ $variant->id }}">
                <input type="hidden" name="variants[{{ $index }}][name]" value="{{ $variant->name }}">
                <input type="hidden" name="variants[{{ $index }}][color]" value="{{ $variant->color }}">
                <input type="hidden" name="variants[{{ $index }}][material]" value="{{ $variant->material }}">
                <input type="hidden" name="variants[{{ $index }}][size]" value="{{ $variant->size }}">

                <div class="row">
                    <div class="col-md-3"><input name="variants[{{ $index }}][sku]" value="{{ $variant->sku }}" class="form-control" placeholder="SKU"></div>
                    <div class="col-md-3"><input name="variants[{{ $index }}][price]" value="{{ $variant->price }}" class="form-control" placeholder="Giá bán" type="number"></div>
                    <div class="col-md-3"><input name="variants[{{ $index }}][stock_quantity]" value="{{ $variant->stock_quantity }}" class="form-control" placeholder="Tồn kho" type="number"></div>
                    <div class="col-md-3"><input name="variants[{{ $index }}][weight]" value="{{ $variant->weight }}" class="form-control" placeholder="Khối lượng (kg)" type="number"></div>
                </div>
                <div class="mt-2">
                    <label>Ảnh biến thể:</label>
                    @if($variant->image)
                        <img src="{{ asset('storage/' . $variant->image) }}" width="60" class="mb-2">
                    @endif
                    <input type="file" name="variants[{{ $index }}][image]" class="form-control">
                </div>
                <button type="button" class="btn btn-danger btn-sm mt-2" onclick="removeVariant(this)">❌ Xoá biến thể</button>
            </div>
            @endforeach
        </div>

        <div class="mt-4 text-end">
            <button type="submit" class="btn btn-success">Cập nhật sản phẩm</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Huỷ</a>
        </div>
    </form>
</div>
<script>
    document.getElementById('generate-variants-btn').addEventListener('click', generateVariants);

function generateVariants() {
    if (!allOptions.colors || !allOptions.materials || !allOptions.sizes) {
        alert("Không có dữ liệu thuộc tính (màu, chất liệu, kích thước) để tạo biến thể!");
        return;
    }

    let countAdded = 0;
    allOptions.colors.forEach(colorObj => {
        allOptions.materials.forEach(materialObj => {
            allOptions.sizes.forEach(sizeObj => {
                addVariant(colorObj.value, materialObj.value, sizeObj.value);
                countAdded++;
            });
        });
    });

    console.log(`Đã thêm ${countAdded} biến thể.`);
    alert(`Đã tạo ${countAdded} biến thể mới.`);
}
</script>
<script>
    let variantCount = {{ count($variants) }};
    let allOptions = {};

    document.addEventListener('DOMContentLoaded', function() {
        const currentCategoryId = document.getElementById('category-select').value;
        if (currentCategoryId) {
            fetchOptionsForCategory(currentCategoryId);
        }
    });

    document.getElementById('category-select').addEventListener('change', function () {
        fetchOptionsForCategory(this.value);
    });

    function fetchOptionsForCategory(categoryId) {
        document.getElementById('generate-variants-btn').disabled = true;
        
         fetch(`/auth/products/category/${categoryId}/options`)
            .then(response => response.json())
            .then(data => {
                allOptions = data;
                document.getElementById('generate-variants-btn').disabled = false;

                const colorSelect = document.getElementById('color');
                const materialSelect = document.getElementById('variant_material');
                const sizeSelect = document.getElementById('size');

                colorSelect.innerHTML = '<option value="">-- Màu sắc --</option>';
                materialSelect.innerHTML = '<option value="">-- Chất liệu --</option>';
                sizeSelect.innerHTML = '<option value="">-- Kích thước --</option>';

                data.colors.forEach(item => colorSelect.innerHTML += `<option value="${item.value}">${item.value}</option>`);
                data.materials.forEach(item => materialSelect.innerHTML += `<option value="${item.value}">${item.value}</option>`);
                data.sizes.forEach(item => sizeSelect.innerHTML += `<option value="${item.value}">${item.value}</option>`);
            })
            .catch(error => console.error('Lỗi khi lấy thuộc tính:', error));
    }

    function addManualVariant() {
        const color = document.getElementById('color').value;
        const material = document.getElementById('variant_material').value;
        const size = document.getElementById('size').value;

        console.log('Chọn biến thể:', { color, material, size });

        if (!color || !material || !size) {
            alert("Vui lòng chọn đầy đủ thuộc tính (Màu, Chất liệu, Kích thước)");
            return;
        }
        addVariant(color, material, size);
    }

    function addVariant(color, material, size) {
        const name = `${color} - ${material} - ${size}`;
        const html = `
            <div class="card p-3 mb-3 variant-card">
                <h6>
                    Biến thể ${variantCount + 1}: 
                    <span class="badge bg-info">${color}</span>
                    <span class="badge bg-secondary">${material}</span>
                    <span class="badge bg-warning text-dark">${size}</span>
                </h6>
                <input type="hidden" name="variants[${variantCount}][id]" value="">
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

