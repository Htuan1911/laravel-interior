@extends('layouts.admin')

@section('title', 'Danh sách biến thể')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Danh sách biến thể sản phẩm</h1>
        <a href="{{ route('admin.variants.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-1"></i> Thêm biến thể mới
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            @if ($variants->count())
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 50px;">ID</th>
                            <th style="width: 100px;">Ảnh</th>
                            <th>Sản phẩm</th>
                            <th>SKU</th>
                            <th>Tên biến thể</th>
                            <th>Giá</th>
                            <th>Tồn kho</th>
                            <th>Trạng thái</th>
                            <th style="width: 150px;">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($variants as $variant)
                            <tr>
                                <td>{{ $variant->id }}</td>
                                <td>
                                    @if ($variant->image_url)
                                        <img src="{{ asset('storage/' . $variant->image_url) }}"
                                             alt="{{ $variant->variant_name }}" width="80"
                                             class="rounded shadow-sm">
                                    @else
                                        <span class="text-muted">Không có ảnh</span>
                                    @endif
                                </td>
                                <td>{{ $variant->product_name }}</td>
                                <td>{{ $variant->sku }}</td>
                                <td>{{ $variant->variant_name }}</td>
                                <td>{{ number_format($variant->price, 0, ',', '.') }}₫</td>
                                <td>{{ $variant->stock_quantity }}</td>
                                <td>
                                    @if ($variant->status === 'active')
                                        <span class="badge bg-success">Hoạt động</span>
                                    @else
                                        <span class="badge bg-secondary">Ẩn</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.variants.edit', $variant->id) }}"
                                           class="btn btn-sm btn-warning" title="Chỉnh sửa">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.variants.destroy', $variant->id) }}"
                                              method="POST" class="d-inline-block"
                                              onsubmit="return confirm('Bạn có chắc chắn muốn xóa biến thể này?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger" title="Xoá">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-muted mb-0">Chưa có biến thể nào.</p>
            @endif
        </div>
    </div>
</div>
@endsection
