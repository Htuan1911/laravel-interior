@extends('layouts.admin')

@section('title', 'Chỉnh sửa Danh mục')

@section('content')
    <h1>Chỉnh sửa Danh mục</h1>
    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="parent_id" class="form-label">Danh mục cha</label>
            <select name="parent_id" class="form-control">
                <option value="">Không có</option>
                @foreach ($parentCategories as $parent)
                    <option value="{{ $parent->id }}">
                        {{ $parent->translations->where('language_code', 'vi')->first()->name ?? 'Không rõ tên' }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Trạng thái</label>
            <select name="status" class="form-control">
                <option value="active" {{ $category->status == 'active' ? 'selected' : '' }}>Hiển thị</option>
                <option value="inactive" {{ $category->status == 'inactive' ? 'selected' : '' }}>Ẩn</option>
            </select>
        </div>
        @foreach ($languages as $language)
            <div class="card mb-3">
                <div class="card-header">{{ $language->name }} ({{ strtoupper($language->code) }})</div>
                <div class="card-body">
                    <input type="hidden" name="translations[{{ $language->code }}][language_code]"
                        value="{{ $language->code }}">
                    <div class="mb-3">
                        <label class="form-label">Tên danh mục</label>
                        <input type="text" name="translations[{{ $language->code }}][name]" class="form-control"
                            value="{{ $category->translations->where('language_code', $language->code)->first()->name ?? '' }}"
                            required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mô tả</label>
                        <textarea name="translations[{{ $language->code }}][description]" class="form-control">{{ $category->translations->where('language_code', $language->code)->first()->description ?? '' }}</textarea>
                    </div>
                </div>
            </div>
        @endforeach
        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
@endsection
