@extends('layouts.admin')

@section('title', 'Danh sách sản phẩm không có biến thể')

@section('content')
<h1>Danh sách sản phẩm không có biến thể</h1>

<a href="{{ route('admin.products_without_variants.create') }}" class="btn btn-success mb-3">Thêm sản phẩm mới</a>

@if (session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead>
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
            <td>
                @if ($product->image_url)
                <img src="{{ asset('storage/' . $product->image_url) }}"
                    alt="{{ $product->image_alt_text ?? $product->product_name }}" width="80">
                @else
                Không có ảnh
                @endif
            </td>
            <td>{{ $product->product_name }}</td>
            <td>{{ $product->category_name }}</td>
            <td>{{ number_format($product->base_price, 0, ',', '.') }} ₫</td>
            <td>{{ $product->description }}</td>
            <td>{{ $product->image_alt_text ?? 'Không có chú thích' }}</td>
            <td>
                <a href="{{ route('admin.products_without_variants.edit', $product->id) }}"
                    class="btn btn-primary btn-sm">Sửa</a>
                <form action="{{ route('admin.products_without_variants.destroy', $product->id) }}" method="POST"
                    style="display:inline-block;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7">Không có sản phẩm nào.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection