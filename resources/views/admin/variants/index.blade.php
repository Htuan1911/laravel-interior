@extends('layouts.admin')

@section('title', 'Danh sách biến thể')

@section('content')
<h1>Danh sách biến thể</h1>

<a href="{{ route('admin.variants.create') }}" class="btn btn-primary mb-3">Thêm biến thể mới</a>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($errors->any())
<div class="alert alert-danger">{{ implode('', $errors->all(':message')) }}</div>
@endif

<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>ID</th>
             <th>Ảnh</th>
            <th>Sản phẩm</th>
            <th>SKU</th>
            <th>Tên biến thể</th>
            <th>Giá</th>
            <th>Số lượng tồn kho</th>
            <th>Trạng thái</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($variants as $variant)
        <tr>
            <td>{{ $variant->id }}</td>
            <td>
                @if ($variant->image_url)
                    <img src="{{ asset('storage/' . $variant->image_url) }}" alt="{{ $variant->variant_name }}" width="80">
                @else
                    <span class="text-muted">Không có ảnh</span>
                @endif
            </td>
            
            <td>{{ $variant->product_name }}</td>
            <td>{{ $variant->sku }}</td>
            <td>{{ $variant->variant_name }}</td>
            <td>{{ number_format($variant->price, 2) }}</td>
            <td>{{ $variant->stock_quantity }}</td>
            <td>{{ $variant->status }}</td>
            <td>
                <a href="{{ route('admin.variants.edit', $variant->id) }}" class="btn btn-sm btn-warning">Sửa</a>

                <form action="{{ route('admin.variants.destroy', $variant->id) }}" method="POST"
                    style="display:inline-block;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa biến thể này?');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger" type="submit">Xóa</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="8" class="text-center">Không có biến thể nào.</td>
        </tr>
        @endforelse
    </tbody>
</table>


@endsection