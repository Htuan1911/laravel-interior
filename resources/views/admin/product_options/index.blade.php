@extends('layouts.admin')

@section('title', 'Quản lý Thuộc tính sản phẩm')

@section('content')
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

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
                                    <th>Loại</th>
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
                                        <td>{{ ucfirst($option->type) }}</td>
                                        <td>{{ $option->category_name ?? 'Không xác định' }}</td>
                                        <td class="text-center">
                                            @if ($option->status)
                                                <span class="badge bg-success">Hiển thị</span>
                                            @else
                                                <span class="badge bg-secondary">Ẩn</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($option->values->isEmpty())
                                                <span class="text-muted fst-italic">Chưa có giá trị</span>
                                            @else
                                                <ul class="mb-0 list-unstyled">
                                                    @foreach ($option->values as $value)
                                                        <li>
                                                            {{ $value->value }}
                                                            @if ($option->type === 'color' && $value->color_code)
                                                                <span class="ms-2 d-inline-block rounded border"
                                                                    style="width:14px;height:14px;background-color:{{ $value->color_code }}"></span>
                                                            @endif
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.product_options.edit', $option->id) }}"
                                                    class="btn btn-sm btn-warning" title="Sửa">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.product_options.destroy', $option->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Bạn có chắc muốn xoá thuộc tính này không?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Xoá">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
