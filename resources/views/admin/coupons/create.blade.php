@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Tạo mã giảm giá mới</h2>

    {{-- Hiển thị lỗi tổng quát --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.coupons.store') }}" method="POST">
        @csrf

        {{-- Mã giảm giá --}}
        <div class="mb-3">
            <label for="code" class="form-label">Mã</label>
            <input type="text" name="code" class="form-control" value="{{ old('code') }}" required>
            @error('code') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Phần trăm giảm --}}
        <div class="mb-3">
            <label for="discount_percent" class="form-label">% Giảm</label>
            <input type="number" name="discount_percent" class="form-control" value="{{ old('discount_percent') }}" min="0" max="100">
            @error('discount_percent') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Giảm tối đa khi dùng phần trăm --}}
        <div class="mb-3">
            <label for="max_discount_amount" class="form-label">
                Giảm tối đa (VNĐ) <span class="text-muted">(áp dụng khi dùng %)</span>
            </label>
            <input type="number" name="max_discount_amount" class="form-control" value="{{ old('max_discount_amount') }}" min="0">
            @error('max_discount_amount') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Số tiền giảm --}}
        <div class="mb-3">
            <label for="discount_amount" class="form-label">Số tiền giảm (VNĐ)</label>
            <input type="number" name="discount_amount" class="form-control" value="{{ old('discount_amount') }}" min="0">
            @error('discount_amount') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Đơn hàng tối thiểu --}}
        <div class="mb-3">
            <label for="min_order_amount" class="form-label">Đơn tối thiểu (VNĐ)</label>
            <input type="number" name="min_order_amount" class="form-control" value="{{ old('min_order_amount') }}" min="0">
            @error('min_order_amount') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Số lượt sử dụng --}}
        <div class="mb-3">
            <label for="max_uses" class="form-label">Số lượt sử dụng</label>
            <input type="number" name="max_uses" class="form-control" value="{{ old('max_uses') }}" min="1">
            @error('max_uses') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Ngày hết hạn --}}
        <div class="mb-3">
            <label for="expires_at" class="form-label">Ngày hết hạn</label>
            <input type="date" name="expires_at" class="form-control" value="{{ old('expires_at') }}">
            @error('expires_at') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Kích hoạt --}}
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" {{ old('is_active') ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Kích hoạt mã</label>
        </div>

        <button type="submit" class="btn btn-success">Tạo mã</button>
        <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
