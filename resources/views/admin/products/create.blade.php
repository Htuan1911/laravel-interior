@extends('layouts.admin')

@section('content')
<div class="container mt-4 mb-5">
  <h3>Thêm Sản Phẩm Nội Thất</h3>
  @if ($errors->any())
  <div class="alert alert-danger">
    <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif
  <div id="variant-error" class="alert alert-danger d-none"></div>

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
      <div class="col-md-3">
        <label for="status">Trạng thái *</label>
        <select name="status" class="form-select" required>
          <option value="active" {{ old('status')=='active' ? 'selected' : '' }}>Đang hiển thị</option>
          <option value="inactive" {{ old('status')=='inactive' ? 'selected' : '' }}>Tạm ẩn</option>
        </select>
      </div>
      <!-- Chọn tên thuộc tính -->
      <div class="row mb-3">
        <div class="col-md-4">
          <label>Tên thuộc tính</label>
          <select id="attribute-name-select" name="attribute_id" class="form-select">
            <option value="">-- Chọn tên thuộc tính --</option>
          </select>
        </div>
      </div>
    </div>

    <div class="mb-3">
      <label>Mô tả chi tiết</label>
      <textarea name="description" class="form-control" rows="4"></textarea>
      @error('description')
      <small class="text-danger">{{ $message }}</small>
      @enderror
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
    <!-- Thêm thông tin chi tiết trước khi tạo biến thể -->


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
let currentValues = { color: [], size: [], material: [] };
let generatedCombinations = new Set();

const categorySel = document.getElementById('category-select');
const attrSel = document.getElementById('attribute-name-select');
const colorSel = document.getElementById('color');
const sizeSel = document.getElementById('size');
const materialSel = document.getElementById('material');
const genBtn = document.getElementById('generate-variants-btn');

document.getElementById('product-form').addEventListener('submit', function () {
  document.querySelectorAll('input[name^="variants"][name$="[price]"]').forEach(input => {
    // Bỏ dấu chấm để server nhận số nguyên
    input.value = input.value.replace(/\./g, '');
  });
  });

// 1. Khi chọn DANH MỤC → load TÊN thuộc tính
categorySel.addEventListener('change', () => {
  const catId = categorySel.value;
  genBtn.disabled = true;
  attrSel.innerHTML = '<option value="">-- Chọn tên thuộc tính --</option>';
  generatedCombinations.clear();
  variantCount = 0;
  document.getElementById('variants-container').innerHTML = '';

  fetch(`/auth/products/category/${catId}/options`)
    .then(res => res.json())
    .then(json => {
      json.forEach(opt => {
        attrSel.innerHTML += `<option value="${opt.id}">${opt.name}</option>`;
      });
    })
    .catch(err => console.error('Fetch attribute names error:', err));
});

// 2. Khi chọn TÊN thuộc tính → load Giá trị tương ứng
attrSel.addEventListener('change', () => {
  const optId = attrSel.value;
  if (!optId) return;

  colorSel.innerHTML = '<option value="">-- Màu sắc --</option>';
  sizeSel.innerHTML = '<option value="">-- Kích thước --</option>';
  materialSel.innerHTML = '<option value="">-- Chất liệu --</option>';
  currentValues = { color: [], size: [], material: [] };
  generatedCombinations.clear();
  variantCount = 0;
  document.getElementById('variants-container').innerHTML = '';

  fetch(`/auth/products/product-options/${optId}/values`)
    .then(res => res.json())
    .then(data => {
      if (data.color) {
        data.color.forEach(v => {
          colorSel.innerHTML += `<option value="${v}">${v}</option>`;
          currentValues.color.push(v);
        });
      }
      if (data.size) {
        data.size.forEach(v => {
          sizeSel.innerHTML += `<option value="${v}">${v}</option>`;
          currentValues.size.push(v);
        });
      }
      if (data.material) {
        data.material.forEach(v => {
          materialSel.innerHTML += `<option value="${v}">${v}</option>`;
          currentValues.material.push(v);
        });
      }
      genBtn.disabled = false;
    })
    .catch(err => console.error('Fetch attribute values error:', err));
});

// 3. Tạo BIẾN THỂ tự động
genBtn.addEventListener('click', () => {
  const cols = currentValues.color.length ? currentValues.color : [''];
  const mats = currentValues.material.length ? currentValues.material : [''];
  const sizes = currentValues.size.length ? currentValues.size : [''];

let price = null;
while (true) {
  price = prompt("Nhập giá bán cho biến thể (bỏ trống nếu không muốn nhập):");

  if (price === null || price.trim() === '') {
    // Nếu bấm Hủy hoặc để trống thì thoát vòng lặp luôn
    price = null;
    break;
  }

  if (isNaN(price)) {
    alert("Giá bán phải là số nếu bạn nhập!");
  } else {
    break;
  }
}

let stock = null;
while (true) {
  stock = prompt("Nhập tồn kho (bỏ trống nếu không muốn nhập):");

  if (stock === null || stock.trim() === '') {
    stock = null;
    break;
  }

  if (isNaN(stock)) {
    alert("Tồn kho phải là số nếu bạn nhập!");
  } else {
    break;
  }
}

let weight = null;
while (true) {
  weight = prompt("Nhập khối lượng (kg) (bỏ trống nếu không muốn nhập):");

  if (weight === null || weight.trim() === '') {
    weight = null;
    break;
  }

  if (isNaN(weight)) {
    alert("Khối lượng phải là số nếu bạn nhập!");
  } else {
    break;
  }
}

  cols.forEach(c =>
    mats.forEach(m =>
      sizes.forEach(s => addVariant(c, m, s, price || '', stock || 0, weight || 0))
    )
  );
});

function showError(msg) {
  const el = document.getElementById('variant-error');
  el.textContent = msg;
  el.classList.remove('d-none');
  setTimeout(() => el.classList.add('d-none'), 3000);
}

// 4. Tạo BIẾN THỂ thủ công
function addManualVariant() {
  const c = colorSel.value, m = materialSel.value, s = sizeSel.value;

let price = null;

while (true) {
  price = prompt("Nhập giá bán cho biến thể:");

  if (price === null) return; // User bấm "Hủy"
  if (price.trim() === '' || isNaN(price)) {
    alert("Giá bán không hợp lệ. Vui lòng nhập một số!");
  } else {
    break; // Hợp lệ → thoát khỏi vòng lặp
  }
}
  let stock = null;
while (true) {
  stock = prompt("Nhập tồn kho:");
  if (stock === null) return;
  if (stock.trim() === '' || isNaN(stock)) {
    alert("Tồn kho không hợp lệ. Vui lòng nhập một số!");
  } else {
    break;
  }
}

let weight = null;
while (true) {
  weight = prompt("Nhập khối lượng (kg):");
  if (weight === null) return;
  if (weight.trim() === '' || isNaN(weight)) {
    alert("Khối lượng không hợp lệ. Vui lòng nhập một số!");
  } else {
    break;
  }
}

  if (!c && !m && !s) return alert("Phải chọn ít nhất một thuộc tính!");

  addVariant(c, m, s, price || '', stock || 0, weight || 0);
}

// 5. Hiển thị BIẾN THỂ
function addVariant(c, m, s, price = '', stock = 0, weight = 0) {
  const key = [c, m, s].map(x => x.toLowerCase().trim()).join('|');
  if (generatedCombinations.has(key)) {
    showError('Biến thể này đã tồn tại, vui lòng chọn biến thể khác!');
    return;
  }
  generatedCombinations.add(key);

  const name = [c, m, s].filter(x => x).join(' - ') || `Variant ${variantCount + 1}`;
  const idx = variantCount++;
  const sku = `SKU-${Date.now()}-${idx}`;

  const html = `
    <div class="card p-3 mb-3 variant-card" data-combo="${key}">
      <h6>Variant ${idx + 1}: ${name}</h6>
      <input type="hidden" name="variants[${idx}][name]" value="${name}">
      <input type="hidden" name="variants[${idx}][color]" value="${c}">
      <input type="hidden" name="variants[${idx}][material]" value="${m}">
      <input type="hidden" name="variants[${idx}][size]" value="${s}">
      <div class="row">
        <div class="col-md-3">
           <label for="sku_${idx}" class="form-label">SKU</label>
          <input name="variants[${idx}][sku]" class="form-control" placeholder="SKU" value="${sku}">
        </div>
        <div class="col-md-3">
           <label for="price_${idx}" class="form-label">Giá bán</label>
            <input name="variants[${idx}][price]" 
         class="form-control text-end" 
         placeholder="Giá bán" 
         type="text" 
         oninput="formatCurrency(this)" 
         value="${formatNumber(price)}">
        </div>
       <div class="col-md-3 mb-3">
       <label for="stock_quantity_${idx}" class="form-label">Tồn kho</label>
    <input 
        id="stock_quantity_${idx}" 
        name="variants[${idx}][stock_quantity]" 
        class="form-control text-end" 
        placeholder="Nhập số lượng tồn kho" 
        type="number" 
        min="0" 
        step="1" 
        value="${stock}">
</div>

<div class="col-md-3 mb-3">
    <label for="weight_${idx}" class="form-label">Khối lượng (kg)</label>
    <div class="input-group">
        <input 
            id="weight_${idx}" 
            name="variants[${idx}][weight]" 
            class="form-control text-end" 
            placeholder="Ví dụ: 0.50" 
            type="number" 
            min="0" 
            step="0.01" 
            value="${weight}">
        <span class="input-group-text">kg</span>
    </div>
</div>
      </div>
      <label class="mt-2">Ảnh biến thể:</label>
      <input type="file" name="variants[${idx}][image]" class="form-control mb-2">
      <button type="button" class="btn btn-danger btn-sm" onclick="removeVariant(this, '${key}')">Xóa</button>
    </div>
  `;
  document.getElementById('variants-container').insertAdjacentHTML('beforeend', html);
}

// 6. Xóa biến thể
function removeVariant(btn, key) {
  if (confirm("Bạn có chắc muốn xóa biến thể này?")) {
    generatedCombinations.delete(key);
    btn.closest('.variant-card').remove();
  }
}

// 7. Format tiền tệ khi nhập
// Hàm format giá khi người dùng nhập
function formatCurrency(el) {
  // Bỏ hết ký tự không phải số
  let val = el.value.replace(/[^\d]/g, '');

  if (val === '') {
    el.value = '';
    return;
  }

  // Chuyển thành dạng có dấu chấm phân cách
  el.value = parseInt(val, 10).toLocaleString('vi-VN');
}

// 8. Hàm format số từ server/mặc định
function formatNumber(num) {
  if (!num) return '';
  return parseInt(num, 10).toLocaleString('vi-VN');
}


</script>





@endsection