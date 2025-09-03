@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4">✏️ Chỉnh sửa Thuộc Tính Sản Phẩm</h2>

    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.product_options.update', $option->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Tên thuộc tính --}}
        <div class="mb-3">
            <label for="name" class="form-label">Tên thuộc tính</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                value="{{ old('name', $option->name) }}">
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
                <option value="{{ $category->id }}" {{ old('category_id', $option->category_id) == $category->id ?
                    'selected' : '' }}>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>
            @error('category_id')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Trạng thái --}}
        <div class="mb-3">
            <label for="status" class="form-label">Trạng thái</label>
            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                <option value="active" {{ old('status', $option->status) == 'active' ? 'selected' : '' }}>Hiển thị
                </option>
                <option value="inactive" {{ old('status', $option->status) == 'inactive' ? 'selected' : '' }}>Ẩn
                </option>
            </select>


            @error('status')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Các thuộc tính --}}
        @foreach (['color', 'size', 'material'] as $type)
        <div class="mb-4">
            <label class="form-label fw-bold text-uppercase">{{ ucfirst($type) }}</label>
            {{-- Hiển thị lỗi tổng quát nếu chưa nhập giá trị --}}
            @error("attributes.$type.values")
            <div class="text-danger mb-2">{{ $message }}</div>
            @enderror
            <div id="wrapper-{{ $type }}">
                @php
                $values = old("attributes.$type.values") ??
                $optionValues->where('type', $type)->pluck('value')->toArray();

                $colorCodes = old("attributes.$type.color_codes") ??
                ($type === 'color'
                ? $optionValues->where('type', $type)->pluck('color_code')->toArray()
                : []);
                @endphp

                @forelse ($values as $i => $val)
                <div class="d-flex mb-2 align-items-center">
                    <input type="text" name="attributes[{{ $type }}][values][]" class="form-control me-2 @error("
                        attributes.$type.values.$i") is-invalid @enderror" value="{{ $val }}"
                        placeholder="Giá trị {{ $type }}...">

                    @if ($type === 'color')
                    <input type="color" name="attributes[{{ $type }}][color_codes][]"
                        class="form-control form-control-color me-2 @error(" attributes.$type.color_codes.$i")
                        is-invalid @enderror" value="{{ $colorCodes[$i] ?? '#000000' }}" style="width: 60px;">
                    @endif

                    <button type="button" class="btn btn-danger btn-sm remove-row ms-2">🗑</button>

                    {{-- Hiển thị lỗi cụ thể --}}
                    @error("attributes.$type.values.$i")
                    <div class="invalid-feedback d-block ms-2">{{ $message }}</div>
                    @enderror
                    @if ($type === 'color')
                    @error("attributes.$type.color_codes.$i")
                    <div class="invalid-feedback d-block ms-2">{{ $message }}</div>
                    @enderror
                    @endif
                </div>
                @empty
                <div class="d-flex mb-2 align-items-center">
                    <input type="text" name="attributes[{{ $type }}][values][]" class="form-control me-2"
                        placeholder="Giá trị {{ $type }}...">
                    @if ($type === 'color')
                    <input type="color" name="attributes[{{ $type }}][color_codes][]"
                        class="form-control form-control-color me-2" value="#000000" style="width: 60px;">
                    @endif
                    <button type="button" class="btn btn-danger btn-sm remove-row ms-2">🗑</button>
                </div>
                @endforelse
            </div>
            <button type="button" class="btn btn-secondary btn-sm mt-2 add-value" data-type="{{ $type }}">➕ Thêm giá trị
                {{ $type }}</button>
        </div>
        @endforeach

        <button type="submit" class="btn btn-primary">💾 Cập nhật</button>
        <a href="{{ route('admin.product_options.index') }}" class="btn btn-secondary">↩️ Quay lại</a>
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.add-value').forEach(button => {
            button.addEventListener('click', function () {
                const type = this.dataset.type;
                const wrapper = document.getElementById('wrapper-' + type);

                const div = document.createElement('div');
                div.classList.add('d-flex', 'mb-2', 'align-items-center');
let html = `
                    <input type="text" name="attributes[${type}][values][]" class="form-control me-2" placeholder="Giá trị ${type}...">
                `;

                if (type === 'color') {
                    html += `<input type="color" name="attributes[${type}][color_codes][]" class="form-control form-control-color me-2" value="#000000" style="width: 60px;">`;
                }

                html += `<button type="button" class="btn btn-danger btn-sm remove-row ms-2">🗑</button>`;
                div.innerHTML = html;
                wrapper.appendChild(div);
            });
        });

        document.querySelectorAll('[id^="wrapper-"]').forEach(wrapper => {
            wrapper.addEventListener('click', function (e) {
                if (e.target.classList.contains('remove-row')) {
                    e.target.closest('.d-flex').remove();
                }
            });
        });
    });
</script>
@endsection