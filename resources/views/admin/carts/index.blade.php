@extends('layouts.admin')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Danh sách giỏ hàng</h2>
    <div>
        <a href="{{ route('admin.carts.trashed') }}" class="btn btn-warning btn-sm">🗑️ Thùng rác</a>
    </div>
</div>

<form method="GET" class="row g-2 mb-3">
    <div class="col-md-4">
        <input type="text" name="search" class="form-control" placeholder="Tìm tên hoặc email" value="{{ request('search') }}">
    </div>
    <div class="col-md-3">
        <select name="status" class="form-select">
            <option value="">-- Tất cả trạng thái --</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="ordered" {{ request('status') == 'ordered' ? 'selected' : '' }}>Ordered</option>
            <option value="abandoned" {{ request('status') == 'abandoned' ? 'selected' : '' }}>Abandoned</option>
        </select>
    </div>
    <div class="col-md-2">
        <button class="btn btn-primary">Lọc</button>
    </div>
</form>

<table class="table table-bordered table-hover">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Người dùng</th>
            <th>Trạng thái</th>
            <th>Số sản phẩm</th>
            <th>Ngày tạo</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @forelse($carts as $cart)
            <tr>
                <td>{{ $cart->id }}</td>
                <td>
                    {{ $cart->user->name ?? 'N/A' }}<br>
                    <small>{{ $cart->user->email ?? '' }}</small>
                </td>
                <td><span class="badge bg-info text-dark">{{ ucfirst($cart->status) }}</span></td>
                <td>{{ $cart->items->count() }}</td>
                <td>{{ $cart->created_at->format('d/m/Y H:i') }}</td>
                <td>
                    <a href="{{ route('admin.carts.show', $cart->id) }}" class="btn btn-sm btn-outline-primary">Xem</a>
                    <form action="{{ route('admin.carts.destroy', $cart->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xoá?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">Xoá</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="text-center">Không có dữ liệu.</td></tr>
        @endforelse
    </tbody>
</table>

{{ $carts->links('pagination::bootstrap-5') }}
@endsection
