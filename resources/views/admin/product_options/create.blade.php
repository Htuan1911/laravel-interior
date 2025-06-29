@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h4>Thêm thuộc tính sản phẩm</h4>

    <form action="{{ route('admin.product_options.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Tên thuộc tính *</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Loại thuộc tính *</label>
            <select name="type" class="form-select" id="type-select" required>
                <option value="">-- Chọn loại --</option>
                <option value="color">Màu sắc</option>
                <option value="size">Kích cỡ</option>
                <option value="material">Chất liệu</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Danh mục *</label>
            <select name="category_id" class="form-select" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Trạng thái</label>
            <select name="status" class="form-select">
                <option value="1">Hiển thị</option>
                <option value="0">Ẩn</option>
            </select>
        </div>

        <div id="values-wrapper">
            <label>Giá trị thuộc tính</label>

            <div id="value-inputs" class="mb-2">
                <!-- dynamic rows will go here -->
            </div>

            <button type="button" class="btn btn-sm btn-secondary" onclick="addRow()">+ Thêm giá trị</button>
        </div>

        <div class="mt-3">
            <button class="btn btn-primary">Lưu thuộc tính</button>
            <a href="{{ route('admin.product_options.index') }}" class="btn btn-secondary">Quay lại</a>
        </div>
    </form>
</div>

<script>
    let typeSelect = document.getElementById('type-select');
    let valueInputs = document.getElementById('value-inputs');

    typeSelect.addEventListener('change', function () {
        valueInputs.innerHTML = ''; // clear current values
        addRow(); // add initial input
    });

    function addRow() {
        let type = typeSelect.value;
        let row = document.createElement('div');
        row.classList.add('row', 'mb-2');

        if (type === 'color') {
            row.innerHTML = `
                <div class="col-md-6">
                    <input type="text" name="values[]" class="form-control" placeholder="Tên màu (VD: Xanh nhạt)" required>
                </div>
                <div class="col-md-4">
                    <input type="color" name="color_codes[]" class="form-control">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger" onclick="this.parentElement.parentElement.remove()">X</button>
                </div>
            `;
        } else {
            row.innerHTML = `
                <div class="col-md-10">
                    <input type="text" name="values[]" class="form-control" placeholder="Giá trị (VD: Gỗ, Da, Size M)" required>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger" onclick="this.parentElement.parentElement.remove()">X</button>
                </div>
            `;
        }

        valueInputs.appendChild(row);
    }
</script>
@endsection
