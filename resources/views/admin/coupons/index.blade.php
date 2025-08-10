@extends('layouts.admin')

@section('title', 'Quản lý mã giảm giá')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3">Danh sách mã giảm giá</h1>
        <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-1"></i> Tạo mã mới
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Form tìm kiếm đặt trước bảng --}}
    <form action="{{ route('admin.coupons.index') }}" method="GET" class="mb-3">
        <div class="input-group" style="max-width: 400px;">
            <input type="text" name="search" class="form-control" 
                   placeholder="Nhập mã hoặc số tiền giảm..." 
                   value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
        </div>
    </form>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Mã</th>
                        <th>% Giảm</th>
                        <th>Giảm tối đa</th>
                        <th>Tiền giảm</th>
                        <th>Đơn tối thiểu</th>
                        <th>Lượt tối đa</th>
                        <th>Đã dùng</th>
                        <th>Hạn dùng</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($coupons as $coupon)
                        @php
                            $isExpired = $coupon->expires_at && \Carbon\Carbon::parse($coupon->expires_at)->lt(\Carbon\Carbon::now());
                        @endphp
                        <tr>
                            <td><strong>{{ $coupon->code }}</strong></td>
                            <td>{{ $coupon->discount_percent ? $coupon->discount_percent . '%' : '-' }}</td>
                            <td>
                                @if ($coupon->discount_percent && $coupon->max_discount_amount)
                                    {{ number_format($coupon->max_discount_amount) }}đ
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $coupon->discount_amount ? number_format($coupon->discount_amount) . 'đ' : '-' }}</td>
                            <td>{{ number_format($coupon->min_order_amount) }}đ</td>
                            <td>{{ $coupon->max_uses ?? '-' }}</td>
                            <td>{{ $coupon->used_count }}</td>
                            <td>{{ $coupon->expires_at ? \Carbon\Carbon::parse($coupon->expires_at)->format('d/m/Y') : '-' }}</td>
                            <td>
                                @if (!$coupon->is_active)
                                    <span class="badge bg-secondary">Tạm ngưng</span>
                                @elseif ($isExpired)
                                    <span class="badge bg-danger">Hết hạn</span>
                                @else
                                    <span class="badge bg-success">Đang hoạt động</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.coupons.edit', $coupon->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa?')">
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
                            <td colspan="10" class="text-center text-muted">Chưa có mã giảm giá nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Hiển thị phân trang --}}
            {{ $coupons->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
