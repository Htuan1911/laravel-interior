@extends('layouts.admin')

@section('title', 'Quản lý Thuộc tính sản phẩm')

@section('content')
@if (session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

@if (session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif
<style>
    .color-circle {
        display: inline-block;
        width: 14px;
        height: 14px;
        border-radius: 50%;
        border: 1px solid #ccc;
        margin-left: 4px;
        vertical-align: middle;
    }

    .table td {
        white-space: nowrap;
        /* Ngăn xuống dòng */
    }
</style>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Danh sách thuộc tính sản phẩm</h1>
        <div>
            <a href="{{ route('admin.product_options.create') }}" class="btn btn-primary me-2">
                <i class="fas fa-plus-circle me-1"></i> Thêm thuộc tính
            </a>
            <a href="{{ route('admin.product_options.trashed') }}" class="btn btn-outline-dark">
                <i class="fas fa-trash-alt me-1"></i> Đã xoá
            </a>
        </div>
    </div>
    <div class="mb-3">
        <form method="GET" action="{{ route('admin.product_options.index') }}" class="row g-2">
            <div class="col-md-4">
                <input type="text" name="name" value="{{ request('name') }}" class="form-control"
                    placeholder="Tìm theo tên thuộc tính...">
            </div>
            <div class="col-md-3">
                <select name="category_id" class="form-select">
                    <option value="">-- Tất cả danh mục --</option>
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id')==$category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary w-100"><i class="fas fa-search"></i> Tìm kiếm</button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('admin.product_options.index') }}" class="btn btn-secondary w-100">
                    <i class="fas fa-sync"></i> Reset
                </a>
            </div>
        </form>
    </div>



    <div class="card shadow-sm">
        <div class="card-body">
            @if ($options->isEmpty())
            <div class="alert alert-info mb-0">Chưa có thuộc tính nào được tạo.</div>
            @else
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle mb-0">
                    <thead class="table-dark text-center">
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th>Tên thuộc tính</th>
                            <th>Danh mục</th>
                            <th>Trạng thái</th>
                            <th>Giá trị</th>
                            <th style="width: 150px;">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($options as $index => $option)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $option->name }}</td>
                            <td>{{ $option->category_name ?? 'Không xác định' }}</td>
                            <td class="text-center">
                                <span class="badge {{ $option->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $option->status === 'active' ? 'Hiển thị' : 'Ẩn' }}
                                </span>
                            </td>
                            <td>
                                {!! $option->values_display ?: '<span class="text-muted fst-italic">Chưa có giá
                                    trị</span>' !!}
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.product_options.edit', $option->id) }}"
                                        class="btn btn-sm btn-warning" title="Sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.product_options.destroy', $option->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Bạn có chắc muốn xoá thuộc tính này không?');"
                                        style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Xoá">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                   <a href="{{ route('admin.product_options.show', $option->id) }}" class="btn btn-info btn-sm" title="Xem chi tiết">
    <i class="fa fa-eye"></i>
</a>

                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $options->links('pagination::bootstrap-5') }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
