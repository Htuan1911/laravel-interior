@extends('layouts.admin')

@section('title', 'Danh sách sản phẩm không có biến thể')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3">Sản phẩm không có biến thể</h1>
        <a href="{{ route('admin.products_without_variants.create') }}" class="btn btn-success">
            <i class="fas fa-plus-circle me-1"></i> Thêm sản phẩm mới
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover table-bordered align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th>Danh mục</th>
                        <th>Giá</th>
                        <th>Mô tả</th>
                        <th>Chú thích ảnh</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td class="text-center">
                                @if ($product->image_url)
                                    <img src="{{ asset('storage/' . $product->image_url) }}"
                                         alt="{{ $product->image_alt_text ?? $product->product_name }}"
                                         class="img-thumbnail" width="80">
                                @else
                                    <span class="text-muted">Không có ảnh</span>
                                @endif
                            </td>
                            <td>{{ $product->product_name }}</td>
                            <td>{{ $product->category_name }}</td>
                            <td class="text-end text-primary">
                                {{ number_format($product->base_price, 0, ',', '.') }} ₫
                            </td>
                            <td>{{ Str::limit(strip_tags($product->description), 50) }}</td>
                            <td>{{ $product->image_alt_text ?? 'Không có' }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.products_without_variants.edit', $product->id) }}"
                                       class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.products_without_variants.destroy', $product->id) }}"
                                          method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Không có sản phẩm nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
