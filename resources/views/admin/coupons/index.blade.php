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

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Mã</th>
                        <th>% Giảm</th>
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
                        <tr>
                            <td><strong>{{ $coupon->code }}</strong></td>
                            <td>{{ $coupon->discount_percent }}%</td>
                            <td>{{ number_format($coupon->discount_amount) }}đ</td>
                            <td>{{ number_format($coupon->min_order_amount) }}đ</td>
                            <td>{{ $coupon->max_uses }}</td>
                            <td>{{ $coupon->used_count }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($coupon->expires_at)->format('d/m/Y') }}
                            </td>
                            <td>
                                @if ($coupon->is_active)
                                    <span class="badge bg-success">Đang hoạt động</span>
                                @else
                                    <span class="badge bg-secondary">Tạm ngưng</span>
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
                            <td colspan="9" class="text-center text-muted">Chưa có mã giảm giá nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
