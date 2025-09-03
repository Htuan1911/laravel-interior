show admin 
@extends('layouts.admin')

@section('title', 'Chi tiết sản phẩm')

@section('content')
<div class="container-fluid">

    <div class="card mb-4">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">Thông tin sản phẩm</h5>
        </div>
        <div class="card-body row">
            <div class="col-md-4 text-center">
                @if($product->main_image && file_exists(public_path('storage/' . $product->main_image)))
                    <img src="{{ asset('storage/' . $product->main_image) }}" alt="{{ $product->name }}" class="img-fluid rounded">
                @else
                    <img src="https://via.placeholder.com/250" class="img-fluid rounded" alt="No Image">
                @endif
            </div>
            <div class="col-md-8">
                <p><strong>Tên:</strong> {{ $product->name }}</p>
                <p><strong>Danh mục:</strong> {{ $product->category_name }}</p>
                <p>
                    <strong>Chất liệu:</strong> 
                    @foreach (explode(',', $product->material ?? '') as $mat)
                        @if(trim($mat))
                            <span class="badge bg-light text-dark border">{{ trim($mat) }}</span>
                        @endif
                    @endforeach
                </p>
                <p><strong>Phong cách:</strong> {{ $product->style ?? '-' }}</p>
                <p><strong>Kích thước:</strong> {{ $product->dimensions ?? '-' }}</p>
                <p><strong>Bảo hành:</strong> {{ $product->warranty_months ? $product->warranty_months . ' tháng' : '-' }}</p>
                <p>
                    <strong>Trạng thái:</strong>
                    <span class="badge {{ $product->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                        {{ $product->status === 'active' ? 'Hiển thị' : 'Ẩn' }}
                    </span>
                </p>
                <p><strong>Mô tả:</strong><br>{{ $product->description ?? '-' }}</p>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Danh sách biến thể</h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered table-striped mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Ảnh</th>
                        <th>Tên biến thể</th>
                        <th>SKU</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Màu sắc</th>
                        <th>Kích thước</th>
                        <th>Chất liệu</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($variants as $variant)
                        <tr>
                            <td>
                                @if($variant->image && file_exists(public_path('storage/' . $variant->image)))
                                    <img src="{{ asset('storage/' . $variant->image) }}" width="60" height="60" class="rounded" style="object-fit: cover;">
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $variant->name ?? '-' }}</td>
                            <td>{{ $variant->sku ?? '-' }}</td>
                            <td>{{ number_format($variant->price, 0, ',', '.') }}₫</td>
                            <td>{{ $variant->stock_quantity ?? 0 }}</td>
                            <td>
                                @foreach (explode(',', $variant->color ?? '') as $color)
                                    @if(trim($color))
                                        <span class="badge bg-light text-dark border">{{ trim($color) }}</span>
                                    @endif
                                @endforeach
                            </td>
                            <td>{{ $variant->size ?? '-' }}</td>
                            <td>
                                @foreach (explode(',', $variant->material ?? '') as $mat)
                                    @if(trim($mat))
                                        <span class="badge bg-light text-dark border">{{ trim($mat) }}</span>
                                    @endif
                                @endforeach
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">Không có biến thể nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Sửa
        </a>
    </div>
</div>
@endsection
