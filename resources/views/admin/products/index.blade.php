@extends('layouts.admin')

@section('title', 'Quản lý Sản phẩm')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="h3 mb-0">Danh sách sản phẩm</h1>
            <div>
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary me-2">
                    <i class="fas fa-plus-circle me-1"></i> Thêm sản phẩm mới
                </a>
                <a href="{{ route('admin.products.trashed') }}" class="btn btn-outline-dark">
                    <i class="fas fa-trash-alt me-1"></i> Xem thùng rác
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-dark text-center">
                            <tr>
                                <th>ID</th>
                                <th>Ảnh</th>
                                <th>Tên</th>
                                <th>Danh mục</th>
                                <th>Chất liệu</th>
                                <th>Kích thước</th>
                                <th>Màu sắc</th>
                                <th>Phong cách</th>
                                <th>Số lượng</th>
                                <th>Giá</th>
                                <th>Bảo hành</th>
                                <th>Trạng thái</th>
                                <th>Ngày tạo</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                                <tr class="{{ $product->deleted_at ? 'table-warning' : '' }}">
                                    <td class="text-center">{{ $product->id }}</td>
                                    <td class="text-center">
                                        @if ($product->main_image && file_exists(public_path('storage/' . $product->main_image)))
                                            <img src="{{ asset('storage/' . $product->main_image) }}" width="60"
                                                height="60" class="rounded">
                                        @endif
                                    </td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->category_name }}</td>
                                    <td>{{ $product->material ?? '-' }}</td>
                                    <td>{{ $product->dimensions ?? '-' }}</td>
                                    <td>
                                        @foreach (explode(',', $product->colors ?? '') as $color)
                                            <span class="badge bg-light text-dark border">{{ trim($color) }}</span>
                                        @endforeach
                                    </td>
                                    <td>{{ $product->style ?? '-' }}</td>
                                    <td class="text-center">{{ $product->total_quantity ?? 0 }}</td>
                                    <td>{{ number_format($product->prices, 0, ',', '.') }} đ</td>
                                    <td>{{ $product->warranty_months ? $product->warranty_months . ' tháng' : '-' }}</td>
                                    <td>
                                        @if ($product->status === 'active')
                                            <span class="badge bg-success">Hiển thị</span>
                                        @else
                                            <span class="badge bg-secondary">Ẩn</span>
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($product->created_at)->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            @if ($product->deleted_at)
                                                <form action="{{ route('admin.products.restore', $product->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button class="btn btn-sm btn-info" title="Khôi phục"
                                                        onclick="return confirm('Khôi phục sản phẩm?')">
                                                        <i class="fas fa-undo-alt"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.products.force-delete', $product->id) }}"
                                                    method="POST">
                                                    @csrf @method('DELETE')
                                                    <button class="btn btn-sm btn-dark" title="Xoá vĩnh viễn"
                                                        onclick="return confirm('Xoá vĩnh viễn sản phẩm này?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <a href="{{ route('admin.products.edit', $product->id) }}"
                                                    class="btn btn-sm btn-warning" title="Sửa">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.products.destroy', $product->id) }}"
                                                    method="POST">
                                                    @csrf @method('DELETE')
                                                    <button class="btn btn-sm btn-danger" title="Xoá mềm"
                                                        onclick="return confirm('Xoá mềm sản phẩm này?')">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="14" class="text-center text-muted">Chưa có sản phẩm nào.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
