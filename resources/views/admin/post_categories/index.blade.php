@extends('layouts.admin')

@section('title', 'Danh mục bài viết')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="h3">Danh sách danh mục bài viết</h1>
            <a href="{{ route('admin.post_categories.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-1"></i> Thêm danh mục
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.post_categories.index') }}" method="GET" class="mb-3 row">
            <div class="col-md-4">
                <input type="text" name="keyword" value="{{ request('keyword') }}" class="form-control"
                    placeholder="Tìm theo tên danh mục...">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-dark">
                    <i class="fas fa-search me-1"></i> Tìm kiếm
                </button>
            </div>
        </form>


        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 60px;">ID</th>
                            <th>Tên danh mục</th>
                            <th>Slug</th>
                            <th style="width: 160px;">Ngày tạo</th>
                            <th style="width: 180px;">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($postCategories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->slug }}</td>
                                <td>{{ \Carbon\Carbon::parse($category->created_at)->format('d/m/Y') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.post_categories.edit', $category->id) }}"
                                            class="btn btn-sm btn-warning" title="Sửa">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.post_categories.destroy', $category->id) }}"
                                            method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger" title="Xoá">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Chưa có danh mục nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="d-flex justify-content-center mt-3">
                    {{ $postCategories->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
