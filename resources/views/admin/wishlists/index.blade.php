@extends('layouts.admin')

@section('title', 'Danh sách sản phẩm yêu thích')

@section('content')
    <div class="container">
        <h1 class="my-4">Danh sách sản phẩm yêu thích</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('admin.wishlists.create') }}" class="btn btn-primary mb-3">
            <i class="fas fa-plus"></i> Thêm mới
        </a>

        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Người dùng</th>
                    <th>Sản phẩm</th>
                    <th>Ngày tạo</th>
                    <th>Ngày cập nhật</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($wishlists as $wishlist)
                    <tr>
                        <td>{{ $wishlist->id }}</td>
                        <td>{{ $wishlist->user->name ?? 'N/A' }} (ID: {{ $wishlist->user_id }})</td>
                        <td>{{ $wishlist->product->name ?? 'N/A' }} (ID: {{ $wishlist->product_id }})</td>
                        <td>{{ $wishlist->created_at }}</td>
                        <td>{{ $wishlist->updated_at }}</td>
                        <td>
                            <a href="{{ route('admin.wishlists.edit', $wishlist->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i> Sửa
                            </a>
                            <form action="{{ route('admin.wishlists.destroy', $wishlist->id) }}" method="POST"
                                style="display:inline-block;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i> Xóa
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Không có dữ liệu.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
