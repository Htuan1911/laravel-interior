@extends('layouts.admin')

@section('title', 'Danh sách sản phẩm yêu thích')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="h3">Danh sách sản phẩm yêu thích</h1>
            <a href="{{ route('admin.wishlists.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-1"></i> Thêm mới
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="GET" action="{{ route('admin.wishlists.index') }}" class="mb-4">
            <div class="card shadow-sm border-0 p-3">
                <div class="row g-3 align-items-center">
                    <!-- Lọc theo người dùng -->
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Người dùng</label>
                        <select name="user_id" class="form-select">
                            <option value="">-- Tất cả --</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Lọc theo sản phẩm -->
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Sản phẩm</label>
                        <select name="product_id" class="form-select">
                            <option value="">-- Tất cả --</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}"
                                    {{ request('product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->translation->name ?? $product->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tìm theo tên -->
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Từ khóa</label>
                        <input type="text" name="keyword" class="form-control" placeholder="Nhập từ khóa..."
                            value="{{ request('keyword') }}">
                    </div>

                    <!-- Nút tìm kiếm -->
                    <div class="col-md-3 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary w-50">
                            <i class="bi bi-search"></i> Tìm kiếm
                        </button>
                        <a href="{{ route('admin.wishlists.index') }}" class="btn btn-secondary w-50">
                            <i class="bi bi-x-circle"></i> Xóa lọc
                        </a>
                    </div>
                </div>
            </div>
        </form>



        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-dark">
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
                        @forelse ($wishlists as $wishlist)
                            <tr>
                                <td>{{ $wishlist->id }}</td>
                                <td>
                                    <strong>{{ $wishlist->user->name ?? 'Không rõ' }}</strong><br>
                                    <small class="text-muted">ID: {{ $wishlist->user_id }}</small>
                                </td>
                                <td>
                                    <strong>{{ $wishlist->product->translation->name ?? 'Không rõ' }}</strong><br>
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
                                        <form action="{{ route('admin.wishlists.destroy', $wishlist->id) }}" method="POST"
                                            class="d-inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger" title="Xoá">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Chưa có sản phẩm yêu thích nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="d-flex justify-content-center mt-3">
            {{ $wishlists->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
