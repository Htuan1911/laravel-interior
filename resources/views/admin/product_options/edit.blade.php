@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 fw-bold">✏️ Chỉnh sửa thuộc tính sản phẩm</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('admin.product_options.update', $option->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="category_id" class="form-label">Danh mục</label>
            <select class="form-select @error('category_id') is-invalid @enderror" name="category_id">
                <option value="">-- Chọn danh mục --</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $option->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Tên thuộc tính</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name', $option->name) }}">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="type" class="form-label">Loại thuộc tính</label>
            <select name="type" class="form-select @error('type') is-invalid @enderror" id="type-select">
                <option value="color" {{ old('type', $option->type) == 'color' ? 'selected' : '' }}>Màu sắc</option>
                <option value="material" {{ old('type', $option->type) == 'material' ? 'selected' : '' }}>Chất liệu</option>
                <option value="size" {{ old('type', $option->type) == 'size' ? 'selected' : '' }}>Kích thước</option>
            </select>
            @error('type')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div id="value-list">
            <label class="form-label">Giá trị thuộc tính</label>

            @php
                $oldValues = old('values', collect($optionValues)->pluck('value')->toArray());
                $oldColors = old('color_codes', collect($optionValues)->pluck('color_code')->toArray());
            @endphp

            @foreach($oldValues as $index => $val)
                <div class="row mb-2 value-row">
                    <div class="col-md-6">
                        <input type="text" name="values[]" class="form-control @error('values.' . $index) is-invalid @enderror"
                            value="{{ $val }}" placeholder="Giá trị (văn bản)">
                        @error('values.' . $index)
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <input type="color" name="color_codes[]" class="form-control form-control-color"
                            value="{{ $oldColors[$index] ?? '#000000' }}">
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger btn-sm remove-value">X</button>
                    </div>
                </div>
            @endforeach
        </div>

        <button type="button" class="btn btn-secondary mb-3" id="add-value">➕ Thêm giá trị</button>

        <div class="mb-3">
            <label for="status" class="form-label">Trạng thái</label>
            <select name="status" class="form-select @error('status') is-invalid @enderror">
                <option value="1" {{ old('status', $option->status) == 1 ? 'selected' : '' }}>Hiển thị</option>
                <option value="0" {{ old('status', $option->status) == 0 ? 'selected' : '' }}>Ẩn</option>
            </select>
            @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button class="btn btn-primary">💾 Cập nhật</button>
        <a href="{{ route('admin.product_options.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection

@push('scripts')
<script>
    function createValueRow(value = '', color = '#000000') {
        return `
            <div class="row mb-2 value-row">
                <div class="col-md-6">
                    <input type="text" name="values[]" class="form-control" value="${value}">
                </div>
                <div class="col-md-4">
                    <input type="color" name="color_codes[]" class="form-control form-control-color" value="${color}">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger btn-sm remove-value">X</button>
                </div>
            </div>
        `;
    }

    document.getElementById('add-value').addEventListener('click', function () {
        document.getElementById('value-list').insertAdjacentHTML('beforeend', createValueRow());
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-value')) {
            e.target.closest('.value-row').remove();
        }
    });
</script>
@endpush
