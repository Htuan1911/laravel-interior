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
                    <div class="col-md-3"><label for="variant_sku_{{ $index }}"
                            class="form-label fw-semibold">SKU</label><input name="variants[{{ $index }}][sku]"
                            value="{{ $variant->sku }}" class="form-control" placeholder="SKU"></div>
                    <div class="col-md-3"><label for="variant_price_{{ $index }}" class="form-label fw-semibold">Giá
                            bán</label><input name="variants[{{ $index }}][price]"
                            value="{{ number_format($variant->price, 0, ',', '.') }}"
                            class="form-control price-input text-end" placeholder="Giá bán" type="text"></div>
                    <div class="col-md-3"><label for="variant_stock_quantity_{{ $index }}"
                            class="form-label fw-semibold">Tồn kho</label>
                        <input name="variants[{{ $index }}][stock_quantity]" value="{{ $variant->stock_quantity }}"
                            class="form-control" placeholder="Tồn kho" type="number">
                    </div>
                    <div class="col-md-3">
                        <label for="variant_weight_{{ $index }}" class="form-label fw-semibold">Khối lượng (kg)</label>
                        <input name="variants[{{ $index }}][weight]" value="{{ (int)$variant->weight }}"
                            class="form-control" placeholder="Khối lượng (kg)" type="number" step="1" min="0">
                    </div>
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
    let existingVariants = new Set(); // Biến thể có sẵn (biến thể gốc)
    
    // Format giá nhập vào (tự động thêm dấu chấm)
document.querySelectorAll('.price-input').forEach(input => {
    input.addEventListener('input', function () {
        let value = this.value.replace(/\D/g, ""); // bỏ ký tự không phải số
        if (value) {
            this.value = new Intl.NumberFormat('vi-VN').format(value);
        }
    });
});

// Trước khi submit form: bỏ dấu chấm để server nhận đúng số
document.getElementById('product-form').addEventListener('submit', function () {
    document.querySelectorAll('.price-input').forEach(input => {
        input.value = input.value.replace(/\./g, ""); 
    });
});
    function addOptions(selectElem, values, defaultText) {
        selectElem.innerHTML = '';
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

    document.getElementById('category-select').addEventListener('change', () => {
        const catId = document.getElementById('category-select').value;
        fetch(`/auth/products/category/${catId}/options`)
            .then(res => res.json())
            .then(data => {
                const attrSelect = document.getElementById('attribute-name-select');
                attrSelect.innerHTML = '<option value="">-- Chọn tên thuộc tính --</option>';
                if (Array.isArray(data)) {
                    data.forEach(opt => {
                        const option = document.createElement('option');
                        option.value = opt.id;
                        option.textContent = opt.name;
                        attrSelect.appendChild(option);
                    });
                }
                resetVariantSelects();
                document.getElementById('generate-variants-btn').disabled = true;
            })
            .catch(err => {
                console.error('Lỗi khi lấy tên thuộc tính:', err);
            });
    });

    document.getElementById('attribute-name-select').addEventListener('change', () => {
        const optId = document.getElementById('attribute-name-select').value;

        if (!optId) {
            resetVariantSelects();
            document.getElementById('generate-variants-btn').disabled = true;
            return;
        }

        fetch(`/auth/products/product-options/${optId}/values`)
            .then(res => res.json())
            .then(data => {
                const colorSel = document.getElementById('color');
                const materialSel = document.getElementById('variant_material');
                const sizeSel = document.getElementById('size');

                currentValues = { color: [], material: [], size: [] };

                if (data.color?.length) {
                    addOptions(colorSel, data.color, '-- Màu sắc --');
                    currentValues.color = data.color;
                } else {
                    addOptions(colorSel, [], '-- Màu sắc --');
                }

                if (data.material?.length) {
                    addOptions(materialSel, data.material, '-- Chất liệu --');
                    currentValues.material = data.material;
                } else {
                    addOptions(materialSel, [], '-- Chất liệu --');
                }

                if (data.size?.length) {
                    addOptions(sizeSel, data.size, '-- Kích thước --');
                    currentValues.size = data.size;
                } else {
                    addOptions(sizeSel, [], '-- Kích thước --');
                }

                const hasValues = currentValues.color.length > 0 || currentValues.material.length > 0 || currentValues.size.length > 0;
                document.getElementById('generate-variants-btn').disabled = !hasValues;
            })
            .catch(err => {
                console.error('Lỗi khi lấy giá trị thuộc tính:', err);
            });
    });

    function resetVariantSelects() {
        addOptions(document.getElementById('color'), [], '-- Màu sắc --');
        addOptions(document.getElementById('variant_material'), [], '-- Chất liệu --');
        addOptions(document.getElementById('size'), [], '-- Kích thước --');
    }

    // Hàm nhập prompt giá, tồn kho, khối lượng, trả về object hoặc null nếu user cancel
    function promptVariantInfo() {
        let price = null;
        while (true) {
            price = prompt("Nhập giá bán:");
            if (price === null) return null;
            if (price.trim() === '' || isNaN(price)) {
                alert("Giá bán không hợp lệ. Vui lòng nhập số!");
            } else break;
        }

        let stock = null;
        while (true) {
            stock = prompt("Nhập tồn kho:");
            if (stock === null) return null;
            if (stock.trim() === '' || isNaN(stock)) {
                alert("Tồn kho không hợp lệ. Vui lòng nhập số!");
            } else break;
        }

        let weight = null;
        while (true) {
            weight = prompt("Nhập khối lượng (kg):");
            if (weight === null) return null;
            if (weight.trim() === '' || isNaN(weight)) {
                alert("Khối lượng không hợp lệ. Vui lòng nhập số!");
            } else break;
        }

        return { price, stock, weight };
    }

    // Thêm biến thể thủ công có prompt nhập giá, tồn kho, khối lượng
    function addManualVariant() {
        const c = document.getElementById('color').value;
        const m = document.getElementById('variant_material').value;
        const s = document.getElementById('size').value;

        if (!c && !m && !s) {
            alert("Phải chọn ít nhất một thuộc tính!");
            return;
        }

       
          const info = promptVariantInfo(true);  // Bắt buộc nhập
        if (info === null) return;

        addVariant(c, m, s, info.price, info.stock, info.weight);
    }

    // Thêm biến thể mới với giá, tồn kho, khối lượng
    function addVariant(c, m, s, price = '', stock = '', weight = '') {
    const key = [c, m, s].map(x => x.toLowerCase().trim()).join('|');

    if (existingVariants.has(key) || generatedCombinations.has(key)) {
        alert("Biến thể này đã tồn tại!");
        return;
    }

    generatedCombinations.add(key);

    const name = [c, m, s].filter(x => x).join(' - ') || `Variant ${variantCount + 1}`;
    const idx = variantCount++;
    const sku = `SKU-${Date.now()}-${idx}`;  // Tạo SKU tự động

   const html = `
  <div class="card p-3 mb-3 variant-card" data-key="${key}">
    <h6>Biến thể ${idx + 1}: ${name}</h6>
    <input type="hidden" name="variants[${idx}][id]" value="">
    <input type="hidden" name="variants[${idx}][name]" value="${name}">
    <input type="hidden" name="variants[${idx}][color]" value="${c}">
    <input type="hidden" name="variants[${idx}][material]" value="${m}">
    <input type="hidden" name="variants[${idx}][size]" value="${s}">
    <div class="row">

      <div class="col-md-3 mb-3">
        <label for="variant_sku_${idx}" class="form-label fw-semibold">SKU</label>
        <input 
          id="variant_sku_${idx}" 
          name="variants[${idx}][sku]" 
          class="form-control" 
          placeholder="SKU" 
          value="${sku}">
      </div>

      <div class="col-md-3 mb-3">
        <label for="variant_price_${idx}" class="form-label fw-semibold">Giá bán</label>
        <input 
          id="variant_price_${idx}" 
          name="variants[${idx}][price]"
          class="form-control price-input text-end"
          placeholder="Giá bán"
          type="text"
          value="${price ? new Intl.NumberFormat('vi-VN').format(price) : ''}">
      </div>

      <div class="col-md-3 mb-3">
        <label for="variant_stock_${idx}" class="form-label fw-semibold">Tồn kho</label>
        <div class="input-group">
          <input 
            id="variant_stock_${idx}" 
            name="variants[${idx}][stock_quantity]" 
            class="form-control text-end" 
            type="number" 
            min="0" 
            step="1" 
            value="${stock}" 
            placeholder="Nhập số lượng">
          <span class="input-group-text">sp</span>
        </div>
      </div>

      <div class="col-md-3 mb-3">
        <label for="variant_weight_${idx}" class="form-label fw-semibold">Khối lượng</label>
        <div class="input-group">
          <input 
            id="variant_weight_${idx}" 
            name="variants[${idx}][weight]" 
            class="form-control text-end weight-input" 
            type="number" 
            min="0" 
            step="0.01" 
            value="${
              (() => {
                const w = parseFloat(weight);
                if (isNaN(w)) return '';
                return Number.isInteger(w) ? w : w.toFixed(2);
              })()
            }"
            placeholder="Ví dụ: 0.5">
          <span class="input-group-text">kg</span>
        </div>
      </div>

    </div>

    <label class="mt-2">Ảnh biến thể:</label>
    <input type="file" name="variants[${idx}][image]" class="form-control mb-2 required">

    <button type="button" class="btn btn-danger btn-sm" onclick="removeVariant(this)">Xóa</button>
  </div>`;

document.getElementById('variants-container').insertAdjacentHTML('beforeend', html);
bindPriceInputs();
    }
    
    // Nút generate tự động prompt nhập info từng biến thể
    document.getElementById('generate-variants-btn').addEventListener('click', () => {
        const colors = currentValues.color.length ? currentValues.color : [''];
        const materials = currentValues.material.length ? currentValues.material : [''];
        const sizes = currentValues.size.length ? currentValues.size : [''];

        // Duyệt từng tổ hợp, prompt nhập info rồi tạo biến thể nếu ko cancel
        for (const c of colors) {
            for (const m of materials) {
                for (const s of sizes) {
                      const info = promptVariantInfo(false); // Không bắt buộc nhập
                    if (info === null) return; // Nếu hủy thì dừng tạo luôn
                    addVariant(c, m, s, info.price, info.stock, info.weight);
                }
            }
        }
    });
    function promptVariantInfo(required = true) {
    let price = null;
    while (true) {
        price = prompt("Nhập giá bán" + (required ? " (bắt buộc):" : " (bỏ trống nếu không nhập):"));
        if (!required && (price === null || price.trim() === '')) {
            price = null;
            break;
        }
        if (required && (price === null || price.trim() === '')) {
            alert("Phải nhập giá bán!");
            continue;
        }
        if (price !== null && price.trim() !== '' && isNaN(price)) {
            alert("Giá bán không hợp lệ. Vui lòng nhập số!");
        } else {
            break;
        }
    }

    let stock = null;
    while (true) {
        stock = prompt("Nhập tồn kho" + (required ? " (bắt buộc):" : " (bỏ trống nếu không nhập):"));
        if (!required && (stock === null || stock.trim() === '')) {
            stock = null;
            break;
        }
        if (required && (stock === null || stock.trim() === '')) {
            alert("Phải nhập tồn kho!");
            continue;
        }
        if (stock !== null && stock.trim() !== '' && isNaN(stock)) {
            alert("Tồn kho không hợp lệ. Vui lòng nhập số!");
        } else {
            break;
        }
    }

    let weight = null;
    while (true) {
        weight = prompt("Nhập khối lượng (kg)" + (required ? " (bắt buộc):" : " (bỏ trống nếu không nhập):"));
        if (!required && (weight === null || weight.trim() === '')) {
            weight = null;
            break;
        }
        if (required && (weight === null || weight.trim() === '')) {
            alert("Phải nhập khối lượng!");
            continue;
        }
        if (weight !== null && weight.trim() !== '' && isNaN(weight)) {
            alert("Khối lượng không hợp lệ. Vui lòng nhập số!");
        } else {
            break;
        }
    }

    return { price, stock, weight };
}

    // Xóa biến thể (cả từ generated và existing)
    function removeVariant(btn) {
        if (confirm("Bạn có chắc muốn xóa biến thể này?")) {
            const card = btn.closest('.variant-card');
            const key = card.getAttribute('data-key');
            if (key) {
                generatedCombinations.delete(key);
                existingVariants.delete(key);
            }
            card.remove();
        }
    }
       document.addEventListener('DOMContentLoaded', function () {
        // Lấy tất cả input có class weight-input
        document.querySelectorAll('.weight-input').forEach(function(input) {
            input.addEventListener('blur', function () {
                const value = parseFloat(this.value);
                if (!isNaN(value)) {
                    // Nếu là số nguyên thì hiển thị không phần thập phân, ngược lại giữ 2 số thập phân
                    this.value = (value % 1 === 0) ? value : value.toFixed(2);
                }
            });
        });
    });

    document.addEventListener('DOMContentLoaded', () => {
        // Thêm các biến thể có sẵn vào existingVariants + generatedCombinations
        const variantCards = document.querySelectorAll('.variant-card');
        variantCards.forEach(card => {
            const key = card.getAttribute('data-key');
            if (key) {
                existingVariants.add(key);
                generatedCombinations.add(key);
            }
        });

        // Load giá trị thuộc tính khi đã chọn sẵn lúc load trang (nếu có)
        const selectedAttrId = document.getElementById('attribute-name-select').value;
        if (selectedAttrId) {
            fetch(`/auth/products/product-options/${selectedAttrId}/values`)
                .then(res => res.json())
                .then(data => {
                    const colorSel = document.getElementById('color');
                    const materialSel = document.getElementById('variant_material');
                    const sizeSel = document.getElementById('size');

                    currentValues = { color: [], material: [], size: [] };

                    if (data.color?.length) {
                        addOptions(colorSel, data.color, '-- Màu sắc --');
                        currentValues.color = data.color;
                    } else {
                        addOptions(colorSel, [], '-- Màu sắc --');
                    }

                    if (data.material?.length) {
                        addOptions(materialSel, data.material, '-- Chất liệu --');
                        currentValues.material = data.material;
                    } else {
                        addOptions(materialSel, [], '-- Chất liệu --');
                    }

                    if (data.size?.length) {
                        addOptions(sizeSel, data.size, '-- Kích thước --');
                        currentValues.size = data.size;
                    } else {
                        addOptions(sizeSel, [], '-- Kích thước --');
                    }

                    const hasValues = currentValues.color.length > 0 || currentValues.material.length > 0 || currentValues.size.length > 0;
                    document.getElementById('generate-variants-btn').disabled = !hasValues;
                })
                .catch(err => {
                    console.error('Lỗi khi lấy giá trị thuộc tính lúc load trang:', err);
                });
        }
        // Hàm format tiền tệ khi nhập
function formatCurrencyInput(input) {
    let value = input.value.replace(/\D/g, ""); // bỏ ký tự không phải số
    if (value) {
        input.value = new Intl.NumberFormat('vi-VN').format(value); // thêm dấu .
    } else {
        input.value = "";
    }
}
function formatWeightValue(weight) {
  const w = parseFloat(weight);
  if (isNaN(w)) return '';
  return Number.isInteger(w) ? w.toString() : w.toFixed(2);
}

// Ví dụ khi load dữ liệu sửa biến thể
const weightInput = document.querySelector('#variant_weight_0'); // thay 0 thành index đúng
weightInput.value = formatWeightValue(weightFromServer);

// Gắn sự kiện format cho tất cả input có class price-input
function bindPriceInputs() {
    document.querySelectorAll('.price-input').forEach(input => {
        input.addEventListener('input', function () {
            formatCurrencyInput(this);
        });
    });
}

// Khi submit form: bỏ dấu chấm để server nhận số đúng
document.getElementById('product-form').addEventListener('submit', function () {
    document.querySelectorAll('.price-input').forEach(input => {
        input.value = input.value.replace(/\./g, "");
    });
});

// Khi load xong DOM thì gắn sự kiện
document.addEventListener('DOMContentLoaded', bindPriceInputs);
    });
</script>


@endsection