@extends('layouts.admin')

@section('title', 'Thêm Danh mục')

@section('content')
    <h1>Thêm Danh mục</h1>
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
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
                <option value="active">Hiển thị</option>
                <option value="inactive">Ẩn</option>
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
                            required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mô tả</label>
                        <textarea name="translations[{{ $language->code }}][description]" class="form-control"></textarea>
                    </div>
                </div>
            </div>
        @endforeach
        <button type="submit" class="btn btn-primary">Thêm</button>
    </form>
@endsection
