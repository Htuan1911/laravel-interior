@extends('layouts.admin')
@section('title', 'Chi tiết đơn hàng')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Chi tiết đơn hàng #{{ $order->id }}</h4>
    </div>
    <div class="card-body">
        <p><strong>Người dùng:</strong> {{ $order->user->name ?? 'N/A' }}</p>
        <p><strong>Tổng tiền:</strong> {{ number_format($order->total_amount, 0, ',', '.') }} đ</p>
        <p><strong>Địa chỉ giao hàng:</strong> {{ $order->shipping_address }}</p>
        <p><strong>Trạng thái:</strong> {{ $order->status }}</p>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Quay lại danh sách</a>
    </div>
</div>
@endsection
