@extends('layouts.admin')

@section('content')
<div class="container">
    <h4 class="mb-4">Sửa thuộc tính sản phẩm</h4>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('admin.product_options.update', $option->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Tên thuộc tính *</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $option->name) }}" required>
        </div>

        <div class="mb-3">
            <label>Loại *</label>
            <select name="type" class="form-select" id="type-select" required>
                <option value="color" {{ $option->type === 'color' ? 'selected' : '' }}>Màu sắc</option>
                <option value="size" {{ $option->type === 'size' ? 'selected' : '' }}>Kích thước</option>
                <option value="material" {{ $option->type === 'material' ? 'selected' : '' }}>Chất liệu</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Trạng thái *</label>
            <select name="status" class="form-select" required>
                <option value="1" {{ $option->status ? 'selected' : '' }}>Hiện</option>
                <option value="0" {{ !$option->status ? 'selected' : '' }}>Ẩn</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Danh mục *</label>
            <select name="category_id" class="form-select" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $option->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Giá trị thuộc tính *</label>
            <div id="value-container">
                @foreach($option->values as $index => $value)
                    <div class="row align-items-center mb-2">
                        <div class="col-md-5">
                            <input type="text" name="values[]" class="form-control" value="{{ $value->value }}" required>
                        </div>
                        <div class="col-md-5 color-code-group" style="{{ $option->type == 'color' ? '' : 'display:none;' }}">
                            <input type="color" name="color_codes[]" class="form-control form-control-color" value="{{ $value->color_code ?? '#000000' }}">
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger btn-sm remove-value">X</button>
                        </div>
                    </div>
                @endforeach
            </div>
            <button type="button" class="btn btn-sm btn-success" id="add-value">+ Thêm giá trị</button>
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('admin.product_options.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const valueContainer = document.getElementById('value-container');
    const addButton = document.getElementById('add-value');
    const typeSelect = document.getElementById('type-select');

    addButton.addEventListener('click', function () {
        const isColor = typeSelect.value === 'color';
        const row = document.createElement('div');
        row.classList.add('row', 'align-items-center', 'mb-2');
        row.innerHTML = `
            <div class="col-md-5">
                <input type="text" name="values[]" class="form-control" required>
            </div>
            <div class="col-md-5 color-code-group" ${isColor ? '' : 'style="display:none;"'}>
                <input type="color" name="color_codes[]" class="form-control form-control-color" value="#000000">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger btn-sm remove-value">X</button>
            </div>
        `;
        valueContainer.appendChild(row);
    });

    valueContainer.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-value')) {
            e.target.closest('.row').remove();
        }
    });

    typeSelect.addEventListener('change', function () {
        const isColor = this.value === 'color';
        document.querySelectorAll('.color-code-group').forEach(group => {
            group.style.display = isColor ? '' : 'none';
        });
    });
});
</script>
@endsection
