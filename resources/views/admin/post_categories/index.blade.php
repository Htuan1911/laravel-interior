
@extends('layouts.admin')

@section('title', 'Danh mục bài viết')

@section('content')
<div class="container">
    <h1 class="mb-4">Danh sách danh mục bài viết</h1>

    <a href="{{ route('admin.post_categories.create') }}" class="btn btn-primary mb-3">+ Thêm danh mục</a>

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên danh mục</th>
                <th>Slug</th>
                <th>Ngày tạo</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($postCategories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->slug }}</td>
                     <td>{{ \Carbon\Carbon::parse($category->created_at)->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('admin.post_categories.edit', $category->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                        <form action="{{ route('admin.post_categories.destroy', $category->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
