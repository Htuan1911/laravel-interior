@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4">➕ Thêm Thuộc Tính Sản Phẩm</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.product_options.store') }}" method="POST">
        @csrf

        {{-- Tên thuộc tính --}}
        <div class="mb-3">
            <label for="name" class="form-label">Tên thuộc tính</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                   name="name" value="{{ old('name') }}">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Danh mục --}}
        <div class="mb-3">
            <label for="category_id" class="form-label">Danh mục</label>
            <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror">
                <option value="">-- Chọn danh mục --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Loại thuộc tính --}}
        <div class="mb-3">
            <label for="type" class="form-label">Loại thuộc tính</label>
            <select name="type" id="type" class="form-select @error('type') is-invalid @enderror">
                <option value="">-- Chọn loại --</option>
                <option value="color" {{ old('type') == 'color' ? 'selected' : '' }}>Màu sắc</option>
                <option value="material" {{ old('type') == 'material' ? 'selected' : '' }}>Chất liệu</option>
                <option value="size" {{ old('type') == 'size' ? 'selected' : '' }}>Kích thước</option>
            </select>
            @error('type')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Trạng thái --}}
        <div class="mb-3">
            <label for="status" class="form-label">Trạng thái</label>
            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Hiển thị</option>
                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Ẩn</option>
            </select>
            @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Giá trị thuộc tính --}}
        <div class="mb-3">
            <label class="form-label">Giá trị thuộc tính</label>
            <div id="value-wrapper">
                @if(old('values'))
                    @foreach(old('values') as $i => $val)
                        <div class="d-flex mb-2 align-items-center">
                            <input type="text" name="values[]" class="form-control me-2 @error("values.$i") is-invalid @enderror"
                                   value="{{ $val }}" placeholder="Giá trị...">
                            <input type="color" name="color_codes[]" class="form-control form-control-color"
                                   value="{{ old('color_codes')[$i] ?? '#000000' }}"
                                   style="width: 60px; display: {{ old('type') === 'color' ? 'block' : 'none' }}">
                            <button type="button" class="btn btn-danger btn-sm ms-2 remove-row">🗑</button>
                            @error("values.$i")
                                <div class="invalid-feedback d-block ms-2">{{ $message }}</div>
                            @enderror
                        </div>
                    @endforeach
                @else
                    <div class="d-flex mb-2 align-items-center">
                        <input type="text" name="values[]" class="form-control me-2" placeholder="Giá trị...">
                        <input type="color" name="color_codes[]" class="form-control form-control-color"
                               style="width: 60px; display: none">
                        <button type="button" class="btn btn-danger btn-sm ms-2 remove-row">🗑</button>
                    </div>
                @endif
            </div>
            <button type="button" id="add-value" class="btn btn-secondary mt-2">➕ Thêm giá trị</button>
            @error('values')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">💾 Lưu</button>
        <a href="{{ route('admin.product_options.index') }}" class="btn btn-secondary">↩️ Quay lại</a>
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const typeSelect = document.getElementById('type');
        const wrapper = document.getElementById('value-wrapper');

        function updateColorVisibility() {
            const type = typeSelect.value;
            wrapper.querySelectorAll('input[type="color"]').forEach(input => {
                input.style.display = (type === 'color') ? 'block' : 'none';
            });
        }

        updateColorVisibility();

        typeSelect.addEventListener('change', updateColorVisibility);

        document.getElementById('add-value').addEventListener('click', function () {
            const div = document.createElement('div');
            div.classList.add('d-flex', 'mb-2', 'align-items-center');
            div.innerHTML = `
                <input type="text" name="values[]" class="form-control me-2" placeholder="Giá trị...">
                <input type="color" name="color_codes[]" class="form-control form-control-color"
                       style="width: 60px; ${typeSelect.value === 'color' ? 'display: block' : 'display: none'}">
                <button type="button" class="btn btn-danger btn-sm ms-2 remove-row">🗑</button>
            `;
            wrapper.appendChild(div);
        });

        wrapper.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-row')) {
                e.target.closest('.d-flex').remove();
            }
        });
    });
</script>
@endsection
