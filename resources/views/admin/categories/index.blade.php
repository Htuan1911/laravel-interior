@extends('layouts.admin')

@section('title', 'Quản lý Danh mục')

@section('content')
    <h1>Danh mục</h1>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary mb-3">Thêm danh mục mới</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên danh mục</th>
                <th>Danh mục cha</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>
                        @foreach ($category->translations as $translation)
                            {{ $translation->name }} ({{ strtoupper($translation->language_code) }})<br>
                        @endforeach
                    </td>
                    <td>{{ $category->parent ? $category->parent->translations->first()->name : 'Không có' }}</td>
                    <td>{{ $category->status == 'active' ? 'Hiển thị' : 'Ẩn' }}</td>
                    <td>
                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa không?')">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
