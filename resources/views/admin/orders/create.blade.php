@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-primary text-white rounded-top-4">
            <h4 class="mb-0">Tạo đơn hàng mới</h4>
        </div>
        <div class="card-body">

            {{-- Hiển thị lỗi --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.orders.store') }}" method="POST">
                @csrf

                {{-- Người dùng --}}
                <div class="mb-3">
                    <label for="user_id" class="form-label">Người dùng</label>
                    <select name="user_id" id="user_id" class="form-select" required>
                        <option value="">-- Chọn người dùng --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Mã giảm giá --}}
                <div class="mb-3">
                    <label for="coupon_id" class="form-label">Mã giảm giá</label>
                    <select name="coupon_id" id="coupon_id" class="form-select">
                        <option value="">-- Không sử dụng --</option>
                        @foreach($coupons as $coupon)
                            <option value="{{ $coupon->id }}">{{ $coupon->code }} ({{ $coupon->discount }})</option>
                        @endforeach
                    </select>
                </div>

                {{-- Tên người nhận --}}
                <div class="mb-3">
                    <label for="shipping_name" class="form-label">Tên người nhận</label>
                    <input type="text" class="form-control" name="shipping_name" id="shipping_name" required>
                </div>

                {{-- Số điện thoại --}}
                <div class="mb-3">
                    <label for="shipping_phone" class="form-label">Số điện thoại</label>
                    <input type="number" class="form-control" name="shipping_phone" id="shipping_phone" required>
                </div>

                {{-- Địa chỉ --}}
                <div class="mb-3">
                    <label for="shipping_address" class="form-label">Địa chỉ giao hàng</label>
                    <input type="text" class="form-control" name="shipping_address" id="shipping_address" required>
                </div>

                {{-- Tổng tiền --}}
                <div class="mb-3">
                    <label for="total_amount" class="form-label">Tổng tiền</label>
                    <input type="number" class="form-control" name="total_amount" id="total_amount" min="0" required>
                </div>

                {{-- Trạng thái --}}
                <div class="mb-3">
                    <label for="status" class="form-label">Trạng thái</label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="pending">Chờ xử lý</option>
                        <option value="confirmed">Đã thanh toán</option>
                        <option value="shipping">Đang giao</option>
                        <option value="completed">Hoàn tất</option>
                        <option value="cancelled">Đã hủy</option>
                    </select>
                </div>

                {{-- Nút gửi --}}
                <div class="text-end">
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Hủy</a>
                    <button type="submit" class="btn btn-success">Tạo đơn</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
