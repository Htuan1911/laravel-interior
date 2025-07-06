@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">📦 Danh sách giỏ hàng</h2>

    <form method="GET" class="row g-3 align-items-end mb-4">
        <div class="col-md-4">
            <label class="form-label">Tìm kiếm theo tên/email</label>
            <input type="text" name="search" class="form-control" placeholder="Nhập tên hoặc email" value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <label class="form-label">Trạng thái</label>
            <select name="status" class="form-select">
                <option value="">-- Tất cả trạng thái --</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="ordered" {{ request('status') == 'ordered' ? 'selected' : '' }}>Ordered</option>
                <option value="abandoned" {{ request('status') == 'abandoned' ? 'selected' : '' }}>Abandoned</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Lọc</button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Người dùng</th>
                    <th>Trạng thái</th>
                    <th>Ngày tạo</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($carts as $cart)
                <tr>
                    <td>{{ $cart->id }}</td>
                    <td>{{ $cart->user->name }}<br><small>{{ $cart->user->email }}</small></td>
                    <td>
                        <span class="badge
                            {{ $cart->status == 'pending' ? 'bg-warning' :
                                ($cart->status == 'ordered' ? 'bg-success' : 'bg-secondary') }}">
                            {{ ucfirst($cart->status) }}
                        </span>
                    </td>
                    <td>{{ $cart->created_at->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('admin.carts.show', $cart->id) }}" class="btn btn-sm btn-info">Chi tiết</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">Không có giỏ hàng nào phù hợp.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $carts->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
