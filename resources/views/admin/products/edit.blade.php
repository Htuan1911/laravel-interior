@extends('layouts.admin')

@section('content')
<div class="container mt-4 mb-5">
    <h3>Cập nhật sản phẩm</h3>
    @if ($errors->any())
    <div class="alert alert-danger">
        <strong>Đã xảy ra lỗi:</strong>
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div id="variant-error" class="alert alert-danger d-none"></div>

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data"
        id="product-form">
        @csrf
        @method('PUT')

        <!-- Thông tin sản phẩm -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label>Tên sản phẩm *</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $translation->name ?? '') }}"
                    required>
            </div>
            <div class="col-md-3">
                <label>Danh mục</label>
                <select name="category_id" id="category-select" class="form-select" required>
                    <option value="">-- Chọn danh mục --</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>{{
                        $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label>Bảo hành (tháng)</label>
                <input type="number" name="warranty_months" class="form-control"
                    value="{{ old('warranty_months', $product->warranty_months) }}">
            </div>
            <div class="col-md-3">
                <label for="status">Trạng thái *</label>
                <select name="status" class="form-select" required>
                    <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>Đang hiển
                        thị</option>
                    <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>Tạm
                        ẩn</option>
                </select>
            </div>
        </div>

        <!-- Chọn thuộc tính -->
        <div class="row mb-3">
            <div class="col-md-4">
                <label>Tên thuộc tính</label>


                <select id="attribute-name-select" class="form-select" name="attribute_id">
                    <option value="">-- Chọn tên thuộc tính --</option>
                    @foreach($attributeOptions as $opt)
                    <option value="{{ $opt->id }}" {{ $opt->id == $selectedAttributeId ? 'selected' : '' }}>
                        {{ $opt->name }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label>Mô tả chi tiết</label>
            <textarea name="description" class="form-control"
                rows="4">{{ old('description', $translation->description ?? '') }}</textarea>
            @error('description')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label>Ảnh sản phẩm chính</label><br>
            @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" width="120" class="mb-2">
            @endif
            <input type="file" name="image" class="form-control mt-2">
        </div>

        <h5>Thông số kỹ thuật</h5>
        <div class="row mb-3">
            <div class="col-md-4"><input type="text" name="material" class="form-control" placeholder="Chất liệu..."
                    value="{{ old('material', $translation->material ?? '') }}"></div>
            <div class="col-md-4"><input type="text" name="dimensions" class="form-control" placeholder="Kích thước..."
                    value="{{ old('dimensions', $product->dimensions ?? '') }}"></div>
            <div class="col-md-4"><input type="text" name="style" class="form-control" placeholder="Phong cách..."
                    value="{{ old('style', $translation->style ?? '') }}"></div>
        </div>

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

        <!-- Tự động -->
        <div class="mb-3">
            <button type="button" class="btn btn-warning" id="generate-variants-btn" disabled>Tự động tạo biến
                thể</button>
        </div>

        <div id="variants-container">
            @foreach($variants as $index => $variant)
            <div class="card p-3 mb-3 variant-card">
                <h6>Biến thể {{ $index + 1 }}:
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
                    <div class="col-md-3"><input name="variants[{{ $index }}][sku]" value="{{ $variant->sku }}"
                            class="form-control" placeholder="SKU"></div>
                    <div class="col-md-3"><input name="variants[{{ $index }}][price]" value="{{ $variant->price }}"
                            class="form-control" placeholder="Giá bán" type="number"></div>
                    <div class="col-md-3"><input name="variants[{{ $index }}][stock_quantity]"
                            value="{{ $variant->stock_quantity }}" class="form-control" placeholder="Tồn kho"
                            type="number"></div>
                    <div class="col-md-3"><input name="variants[{{ $index }}][weight]" value="{{ $variant->weight }}"
                            class="form-control" placeholder="Khối lượng (kg)" type="number"></div>
                </div>

                <div class="mt-2">
                    <label>Ảnh biến thể:</label>
                    @if($variant->image)
                    <img src="{{ asset('storage/' . $variant->image) }}" width="60" class="mb-2">
                    @endif
                    <input type="file" name="variants[{{ $index }}][image]" class="form-control">
                </div>

                <button type="button" class="btn btn-danger btn-sm mt-2" onclick="removeVariant(this)">❌ Xoá biến
                    thể</button>
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
    let variantCount = {{ count($variants) }};
    let currentValues = { color: [], material: [], size: [] };
    let generatedCombinations = new Set();
    let existingVariants = new Set(); // Lưu biến thể có sẵn (biến thể gốc)

    // Hàm tạo option cho select
    function addOptions(selectElem, values, defaultText) {
        selectElem.innerHTML = ''; // Xoá hết option cũ
        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.textContent = defaultText;
        selectElem.appendChild(defaultOption);

        values.forEach(v => {
            const option = document.createElement('option');
            option.value = v;
            option.textContent = v;
            selectElem.appendChild(option);
        });
    }

    // Load tên thuộc tính khi chọn danh mục
    document.getElementById('category-select').addEventListener('change', () => {
        const catId = document.getElementById('category-select').value;
        console.log('Chọn danh mục:', catId);
        fetch(`/auth/products/category/${catId}/options`)
            .then(res => res.json())
            .then(data => {
                console.log('Tên thuộc tính nhận được:', data);
                const attrSelect = document.getElementById('attribute-name-select');
                if (Array.isArray(data)) {
                    addOptions(attrSelect, data.map(opt => ({id: opt.id, name: opt.name})), '-- Chọn tên thuộc tính --');
                    // Vì data là array object, nên cần xử lý riêng
                    attrSelect.innerHTML = '<option value="">-- Chọn tên thuộc tính --</option>';
                    data.forEach(opt => {
                        const option = document.createElement('option');
                        option.value = opt.id;
                        option.textContent = opt.name;
                        attrSelect.appendChild(option);
                    });
                } else {
                    // Nếu data không đúng định dạng, reset select
                    attrSelect.innerHTML = '<option value="">-- Chọn tên thuộc tính --</option>';
                }
                // Reset biến thể và disable nút tạo biến thể
                resetVariantSelects();
                document.getElementById('generate-variants-btn').disabled = true;
            })
            .catch(err => {
                console.error('Lỗi khi lấy tên thuộc tính:', err);
            });
    });

    // Load giá trị thuộc tính khi chọn tên thuộc tính
    document.getElementById('attribute-name-select').addEventListener('change', () => {
        const optId = document.getElementById('attribute-name-select').value;
        console.log('Chọn tên thuộc tính:', optId);

        if (!optId) {
            resetVariantSelects();
            document.getElementById('generate-variants-btn').disabled = true;
            return;
        }

        fetch(`/auth/products/product-options/${optId}/values`)
            .then(res => res.json())
            .then(data => {
                console.log('Giá trị thuộc tính nhận được:', data);

                const colorSel = document.getElementById('color');
                const materialSel = document.getElementById('variant_material');
                const sizeSel = document.getElementById('size');

                currentValues = { color: [], material: [], size: [] };

                if (data.color && Array.isArray(data.color) && data.color.length > 0) {
                    addOptions(colorSel, data.color, '-- Màu sắc --');
                    currentValues.color = data.color;
                } else {
                    addOptions(colorSel, [], '-- Màu sắc --');
                }

                if (data.material && Array.isArray(data.material) && data.material.length > 0) {
                    addOptions(materialSel, data.material, '-- Chất liệu --');
                    currentValues.material = data.material;
                } else {
                    addOptions(materialSel, [], '-- Chất liệu --');
                }

                if (data.size && Array.isArray(data.size) && data.size.length > 0) {
                    addOptions(sizeSel, data.size, '-- Kích thước --');
                    currentValues.size = data.size;
                } else {
                    addOptions(sizeSel, [], '-- Kích thước --');
                }

                // Bật nút tạo biến thể nếu có ít nhất một thuộc tính
                const hasValues = currentValues.color.length > 0 || currentValues.material.length > 0 || currentValues.size.length > 0;
                document.getElementById('generate-variants-btn').disabled = !hasValues;
            })
            .catch(err => {
                console.error('Lỗi khi lấy giá trị thuộc tính:', err);
            });
    });

    // Hàm reset select biến thể
    function resetVariantSelects() {
        addOptions(document.getElementById('color'), [], '-- Màu sắc --');
        addOptions(document.getElementById('variant_material'), [], '-- Chất liệu --');
        addOptions(document.getElementById('size'), [], '-- Kích thước --');
    }

    // Thêm biến thể thủ công
    function addManualVariant() {
        const c = document.getElementById('color').value;
        const m = document.getElementById('variant_material').value;
        const s = document.getElementById('size').value;

        if (!c && !m && !s) {
            alert("Phải chọn ít nhất một thuộc tính!");
            return;
        }

        addVariant(c, m, s);
    }

    // Tạo biến thể tự động
    document.getElementById('generate-variants-btn').addEventListener('click', () => {
        const colors = currentValues.color.length ? currentValues.color : [''];
        const materials = currentValues.material.length ? currentValues.material : [''];
        const sizes = currentValues.size.length ? currentValues.size : [''];

        colors.forEach(c => materials.forEach(m => sizes.forEach(s => addVariant(c, m, s))));
    });

    // Hiển thị biến thể mới
    function addVariant(c, m, s) {
        const key = [c, m, s].map(x => x.toLowerCase().trim()).join('|');

        // Kiểm tra nếu đã tồn tại biến thể này rồi (cả biến thể gốc và mới tạo)
        if (existingVariants.has(key) || generatedCombinations.has(key)) {
            alert("Biến thể này đã tồn tại!");
            return;
        }

        generatedCombinations.add(key);

        const name = [c, m, s].filter(x => x).join(' - ') || `Variant ${variantCount + 1}`;
        const idx = variantCount++;
        const html = `
            <div class="card p-3 mb-3 variant-card" data-key="${key}">
                <h6>Biến thể ${idx + 1}: ${name}</h6>
                <input type="hidden" name="variants[${idx}][id]" value="">
                <input type="hidden" name="variants[${idx}][name]" value="${name}">
                <input type="hidden" name="variants[${idx}][color]" value="${c}">
                <input type="hidden" name="variants[${idx}][material]" value="${m}">
                <input type="hidden" name="variants[${idx}][size]" value="${s}">
                <div class="row">
                    <div class="col-md-3"><input name="variants[${idx}][sku]" class="form-control" placeholder="SKU"></div>
                    <div class="col-md-3"><input name="variants[${idx}][price]" class="form-control" placeholder="Giá bán" type="number"></div>
                    <div class="col-md-3"><input name="variants[${idx}][stock_quantity]" class="form-control" placeholder="Tồn kho" type="number"></div>
                    <div class="col-md-3"><input name="variants[${idx}][weight]" class="form-control" placeholder="Khối lượng (kg)" type="number"></div>
                </div>
                <label class="mt-2">Ảnh biến thể:</label>
                <input type="file" name="variants[${idx}][image]" class="form-control mb-2 required">
                <button type="button" class="btn btn-danger btn-sm" onclick="removeVariant(this)">Xóa</button>
            </div>`;
        document.getElementById('variants-container').insertAdjacentHTML('beforeend', html);
    }

    // Xóa biến thể
    function removeVariant(btn) {
        if (confirm("Bạn có chắc không?")) {
            const card = btn.closest('.variant-card');
            const key = card.getAttribute('data-key');
            if (key) {
                generatedCombinations.delete(key);
            }
            card.remove();
        }
    }

    // Khởi tạo generatedCombinations và existingVariants nếu có biến thể cũ khi load trang
    document.addEventListener('DOMContentLoaded', () => {
        const variantCards = document.querySelectorAll('.variant-card');
        variantCards.forEach(card => {
            const key = card.getAttribute('data-key');
            if (key) {
                existingVariants.add(key);
                generatedCombinations.add(key);
            }
        });

        const selectedAttrId = document.getElementById('attribute-name-select').value;
        if (selectedAttrId) {
            // Giả lập gọi sự kiện change để load giá trị thuộc tính
            fetch(`/auth/products/product-options/${selectedAttrId}/values`)
                .then(res => res.json())
                .then(data => {
                    console.log('Giá trị thuộc tính nhận được lúc load trang:', data);

                    const colorSel = document.getElementById('color');
                    const materialSel = document.getElementById('variant_material');
                    const sizeSel = document.getElementById('size');

                    currentValues = { color: [], material: [], size: [] };

                    if (data.color && Array.isArray(data.color) && data.color.length > 0) {
                        addOptions(colorSel, data.color, '-- Màu sắc --');
                        currentValues.color = data.color;
                    } else {
                        addOptions(colorSel, [], '-- Màu sắc --');
                    }

                    if (data.material && Array.isArray(data.material) && data.material.length > 0) {
                        addOptions(materialSel, data.material, '-- Chất liệu --');
                        currentValues.material = data.material;
                    } else {
                        addOptions(materialSel, [], '-- Chất liệu --');
                    }

                    if (data.size && Array.isArray(data.size) && data.size.length > 0) {
                        addOptions(sizeSel, data.size, '-- Kích thước --');
                        currentValues.size = data.size;
                    } else {
                        addOptions(sizeSel, [], '-- Kích thước --');
                    }

                    // Bật nút tạo biến thể nếu có ít nhất một thuộc tính
                    const hasValues = currentValues.color.length > 0 || currentValues.material.length > 0 || currentValues.size.length > 0;
                    document.getElementById('generate-variants-btn').disabled = !hasValues;
                })
                .catch(err => {
                    console.error('Lỗi khi lấy giá trị thuộc tính lúc load trang:', err);
                });
        }
    });
</script>


@endsection