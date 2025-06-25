@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Danh sách mã giảm giá</h2>
    <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary mb-3">Tạo mã mới</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Mã</th>
                <th>% Giảm</th>
                <th>Số tiền giảm</th>
                <th>Đơn tối thiểu</th>
                <th>Số lượt</th>
                <th>Đã dùng</th>
                <th>Hết hạn</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach($coupons as $coupon)
            <tr>
                <td>{{ $coupon->code }}</td>
                <td>{{ $coupon->discount_percent }}%</td>
                <td>{{ number_format($coupon->discount_amount) }}đ</td>
                <td>{{ number_format($coupon->min_order_amount) }}đ</td>
                <td>{{ $coupon->max_uses }}</td>
                <td>{{ $coupon->used_count }}</td>
                <td>{{ $coupon->expires_at }}</td>
                <td>{{ $coupon->is_active ? 'Đang hoạt động' : 'Tắt' }}</td>
                <td>
                    <a href="{{ route('admin.coupons.edit', $coupon->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                    <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Xóa mã này?')" class="btn btn-sm btn-danger">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
