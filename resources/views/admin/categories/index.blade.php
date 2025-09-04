@extends('layouts.admin')

@section('title', 'Quản lý Danh mục')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="h3 mb-0">Danh sách danh mục</h1>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-1"></i> Thêm danh mục mới
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Form tìm kiếm --}}
        <form action="{{ route('admin.categories.index') }}" method="GET" class="mb-3">
            <div class="row g-2">
                <div class="col-md-4">
                    <input type="text" name="keyword" value="{{ request('keyword') }}" class="form-control"
                        placeholder="Tìm theo tên danh mục...">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-dark">
                        <i class="fas fa-search"></i> Tìm kiếm
                    </button>
                </div>
            </div>
        </form>

        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 50px;">ID</th>
                            <th style="width: 250px;">Tên danh mục</th>
                            <th>Danh mục cha</th>
                            <th style="width: 120px;">Trạng thái</th>
                            <th style="width: 150px;">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>
                                    @foreach ($category->translations as $translation)
                                        <span class="d-block">
                                            <strong>{{ $translation->name }}</strong>
                                            <small
                                                class="text-muted">({{ strtoupper($translation->language_code) }})</small>
                                        </span>
                                    @endforeach
                                </td>
                                <td>
                                    {{ $category->parent ? $category->parent->translations->first()->name : 'Không có' }}
                                </td>
                                <td>
                                    @if ($category->status == 'active')
                                        <span class="badge bg-success">Hiển thị</span>
                                    @else
                                        <span class="badge bg-secondary">Ẩn</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.categories.edit', $category->id) }}"
                                            class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('admin.categories.show', $category->id) }}"
                                            class="btn btn-sm btn-info text-white">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        @if ($categories->isEmpty())
                            <tr>
                                <td colspan="5" class="text-center text-muted">Chưa có danh mục nào.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                <div class="d-flex justify-content-center mt-3">
                    {{ $categories->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
