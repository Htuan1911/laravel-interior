@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h3 class="mb-3">Danh sách sản phẩm</h3>
    <a href="{{ route('admin.products.create') }}" class="btn btn-success me-2">+ Thêm sản phẩm</a>
    <a href="{{ route('admin.products.trashed') }}" class="btn btn-outline-dark me-2">🗑 Xem thùng rác</a>


    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Ảnh chính</th>
                <th>Ảnh biến thể</th>
                <th>Tên</th>
                <th>Mô tả</th>
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
            @foreach($products as $product)
            <tr class="{{ $product->deleted_at ? 'table-warning' : '' }}">
                <td>{{ $product->id }}</td>

                <!-- Ảnh chính -->
                <td>
                    @if($product->main_image)
                    <img src="{{ asset('storage/products/' . $product->main_image) }}" width="70" height="70"
                        style="object-fit: cover;">
                    @else
                    -
                    @endif
                </td>

                <!-- Ảnh biến thể -->
                <td>
                    @if($product->variant_images)
                    @foreach(explode(',', $product->variant_images) as $img)
                    <img src="{{ asset('storage/products/' . trim($img)) }}" width="40" height="40"
                        style="object-fit: cover; margin: 2px;">
                    @endforeach
                    @else
                    -
                    @endif
                </td>

                <td>{{ $product->name }}</td>
                <td>{{ Str::limit($product->description, 80) }}</td>
                <td>{{ $product->category_name }}</td>
                <td>{{ $product->material ?? '-' }}</td>
                <td>{{ $product->dimensions ?? '-' }}</td>
                <td>
                    @if(!empty($product->colors))
                    @foreach(explode(',', $product->colors) as $color)
                    <span class="badge bg-light text-dark border">{{ trim($color) }}</span>
                    @endforeach
                    @else
                    -
                    @endif
                </td>
                <td>{{ $product->style ?? '-' }}</td>
                <td>{{ $product->total_quantity ?? 0 }}</td>
                <td>{{ $product->prices ?? '-' }}</td>
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
                    @if(isset($product->deleted_at) && $product->deleted_at)
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
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection