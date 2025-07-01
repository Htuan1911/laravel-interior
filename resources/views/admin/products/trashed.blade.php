@extends('layouts.admin')
@section('content')
<div class="container mt-4">
    <h3 class="mb-3">Thùng rác sản phẩm</h3>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary mb-3">← Quay lại danh sách</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Ảnh</th>
                <th>Tên</th>
                <th>Danh mục</th>
                <th>Giá</th>
                <th>Tồn kho</th>
                <th>Ngày xoá</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>
                        @if($product->main_image)
                            <img src="{{ asset('storage/products/' . $product->main_image) }}" width="60" height="60">
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category_name }}</td>
                    <td>{{ $product->prices }}</td>
                    <td>{{ $product->total_quantity ?? 0 }}</td>
                    <td>Đã xoá</td>
                    <td>
                        <form action="{{ route('admin.products.restore', $product->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            <button class="btn btn-sm btn-info" onclick="return confirm('Khôi phục sản phẩm này?')">Khôi phục</button>
                        </form>

                        <form action="{{ route('admin.products.force-delete', $product->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Xoá vĩnh viễn sản phẩm này?')">Xoá cứng</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection