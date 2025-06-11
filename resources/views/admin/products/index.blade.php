@extends('layouts.admin')

@section('title', 'Danh sách sản phẩm có biến thể')

@section('content')
<div class="container">
    <h1 class="mb-4">Danh sách sản phẩm có biến thể</h1>

    {{-- Thông báo thành công --}}
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    {{-- Nút thêm --}}
    <div class="mb-3">
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> Thêm sản phẩm có biến thể
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>Ảnh Sản phẩm</th>
                    <th>Ảnh Biến thể</th>
                    <th>Tên sản phẩm</th>
                    <th>Danh mục</th>
                    <th>Giá gốc</th>
                    <th>Tên biến thể</th>
                    <th>SKU</th>
                    <th>Giá biến thể</th>
                    <th>Tồn kho</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                <tr>
                    <td>
                        @if ($product->image_url)
                        <img src="{{ asset('storage/' . $product->image_url) }}" width="80" class="rounded">
                        @else
                        <span class="text-muted">Không có</span>
                        @endif
                    </td>
                    <td>
                        @if ($product->variant_image)
                        <img src="{{ asset('storage/' . $product->variant_image) }}" width="80" class="rounded">
                        @else
                        <span class="text-muted">Không có</span>
                        @endif
                    </td>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->category_name }}</td>
                    <td>{{ number_format($product->base_price, 0, ',', '.') }} ₫</td>
                    <td>{{ $product->variant_name }}</td>
                    <td>{{ $product->sku }}</td>
                    <td>{{ number_format($product->variant_price, 0, ',', '.') }} ₫</td>
                    <td>{{ $product->stock_quantity }}</td>
                    <td>
                        <a href="{{ route('admin.products.edit', ['id' => $product->product_id]) }}"
                            class="btn btn-sm btn-warning mb-1">
                            <i class="fas fa-edit"></i> Sửa
                        </a>

                        <form action="{{ route('admin.products.destroy', ['id' => $product->product_id]) }}"
                            method="POST" style="display:inline-block;"
                            onsubmit="return confirm('Bạn có chắc chắn muốn xóa biến thể này?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash-alt"></i> Xoá
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-muted">Không có sản phẩm nào có biến thể.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection