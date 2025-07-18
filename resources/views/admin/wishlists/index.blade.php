@extends('layouts.admin')

@section('title', 'Danh sách sản phẩm yêu thích')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Danh sách sản phẩm yêu thích</h1>
        <a href="{{ route('admin.wishlists.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-1"></i> Thêm mới
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            @if ($wishlists->count())
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 50px;">ID</th>
                                <th style="width: 200px;">Người dùng</th>
                                <th style="width: 200px;">Sản phẩm</th>
                                <th style="width: 150px;">Ngày tạo</th>
                                <th style="width: 150px;">Ngày cập nhật</th>
                                <th style="width: 150px;" class="text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($wishlists as $wishlist)
                                <tr>
                                    <td>{{ $wishlist->id }}</td>
                                    <td>
                                        <strong>{{ $wishlist->user->name ?? 'Không rõ' }}</strong><br>
                                        <small class="text-muted">ID: {{ $wishlist->user_id }}</small>
                                    </td>
                                    <td>
                                        <strong>{{ $wishlist->product->variant ?? 'Không rõ' }}</strong><br>
                                        <small class="text-muted">ID: {{ $wishlist->product_id }}</small>
                                    </td>
                                    <td>{{ $wishlist->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ $wishlist->updated_at->format('d/m/Y H:i') }}</td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.wishlists.edit', $wishlist->id) }}"
                                               class="btn btn-sm btn-warning" title="Sửa">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.wishlists.destroy', $wishlist->id) }}"
                                                  method="POST" class="d-inline-block"
                                                  onsubmit="return confirm('Bạn có chắc chắn muốn xóa?')">
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
                </div>
            @else
                <div class="alert alert-info text-center mb-0">Chưa có sản phẩm yêu thích nào.</div>
            @endif
        </div>
    </div>
</div>
@endsection
