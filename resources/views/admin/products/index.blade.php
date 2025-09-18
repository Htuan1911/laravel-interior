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

    <form action="{{ route('admin.products.index') }}" method="GET" class="mb-3 row">
        <div class="col-md-4">
            <input type="text" name="keyword" value="{{ request('keyword') }}" class="form-control"
                placeholder="Tìm theo tên sản phẩm...">
        </div>
        <div class="col-md-3">
            <select name="category_id" class="form-control">
                <option value="">-- Chọn danh mục --</option>
                @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ request('category_id')==$category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-dark">
                <i class="fas fa-search me-1"></i> Tìm kiếm
            </button>
        </div>
    </form>

    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Ảnh chính</th>
                <th>Ảnh biến thể</th>
                <th>Tên</th>
                <th>Mô tả</th>
                <th>Danh mục</th>
                
                <th>Số lượng</th>
                <th>Giá</th>
                <th>Bảo hành</th>
                <th>Trạng thái</th>
                <th>Ngày tạo</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr class="{{ $product->deleted_at ? 'table-warning' : '' }}">
                <td>{{ $product->id }}</td>

                <!-- Ảnh chính -->
                <td>
                    @if ($product->main_image && file_exists(public_path('storage/' . $product->main_image)))
                    <img src="{{ asset('storage/' . $product->main_image) }}" width="60" height="60" class="rounded">
                    @endif
                </td>

                <!-- Ảnh biến thể -->
                <td>
                    @php
                    $variantImgs = explode(',', $product->variant_images ?? '');
                    @endphp

                    @if (!empty($variantImgs[0]))
                    @foreach ($variantImgs as $img)
                    <img src="{{ asset('storage/' . trim($img)) }}" width="40" height="40"
                        style="object-fit: cover; margin: 2px;">
                    @endforeach
                    @else
                    -
                    @endif
                </td>


                <td>{{ $product->name }}</td>
                <td>{{ Str::limit($product->description, 80) }}</td>
                <td>{{ $product->category_name }}</td>

              

                
                <td>{{ $product->total_quantity ?? 0 }}</td>
                <td>{{ $product->prices ? number_format($product->prices, 0, ',', '.') . ' ₫' : '-' }}
                </td>
                <td>{{ $product->warranty_months ? $product->warranty_months . ' tháng' : '-' }}</td>

                <!-- Trạng thái -->
                <td>
                    <span class="badge {{ $product->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                        {{ $product->status === 'active' ? 'Hiển thị' : 'Ẩn' }}
                    </span>
                </td>

                <!-- Ngày tạo -->
                <td>{{ \Carbon\Carbon::parse($product->created_at)->format('d/m/Y') }}</td>

                <!-- Thao tác -->
                <td>
                    @if (isset($product->deleted_at) && $product->deleted_at)
                    <form action="{{ route('admin.products.restore', $product->id) }}" method="POST"
                        style="display:inline-block;">
                        @csrf
                        <button class="btn btn-sm btn-info" onclick="return confirm('Khôi phục sản phẩm?')">Khôi
                            phục</button>
                    </form>

                    <form action="{{ route('admin.products.force-delete', $product->id) }}" method="POST"
                        style="display:inline-block;">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-dark" onclick="return confirm('Xoá vĩnh viễn sản phẩm này?')">Xoá
                            cứng</button>
                    </form>
                    @else
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-warning">Sửa</a>

                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                        style="display:inline-block;">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger"
                            onclick="return confirm('Xoá mềm sản phẩm này?')">Xoá</button>
                    </form>
                    @endif
                    <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-sm btn-info">
                        Xem
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center mt-3">
        {{ $products->links() }}
    </div>
</div>
@endsection