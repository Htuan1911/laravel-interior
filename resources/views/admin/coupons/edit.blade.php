@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Chỉnh sửa mã giảm giá</h2>
    <form action="{{ route('admin.coupons.update', $coupon->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="code" class="form-label">Mã</label>
            <input type="text" name="code" class="form-control" value="{{ old('code', $coupon->code) }}" required>
            @error('code') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="discount_percent" class="form-label">% Giảm</label>
            <input type="number" name="discount_percent" class="form-control" value="{{ old('discount_percent', $coupon->discount_percent) }}">
            @error('discount_percent') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="discount_amount" class="form-label">Số tiền giảm (VNĐ)</label>
            <input type="number" name="discount_amount" class="form-control" value="{{ old('discount_amount', $coupon->discount_amount) }}">
            @error('discount_amount') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="min_order_amount" class="form-label">Đơn tối thiểu (VNĐ)</label>
            <input type="number" name="min_order_amount" class="form-control" value="{{ old('min_order_amount', $coupon->min_order_amount) }}">
            @error('min_order_amount') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="max_uses" class="form-label">Số lượt sử dụng</label>
            <input type="number" name="max_uses" class="form-control" value="{{ old('max_uses', $coupon->max_uses) }}">
            @error('max_uses') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="expires_at" class="form-label">Ngày hết hạn</label>
            <input type="date" name="expires_at" class="form-control" value="{{ old('expires_at', $coupon->expires_at ? $coupon->expires_at->format('Y-m-d') : '') }}">
            @error('expires_at') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" {{ old('is_active', $coupon->is_active) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Kích hoạt mã</label>
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection
