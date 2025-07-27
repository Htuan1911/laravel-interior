@extends('layouts.admin')

@section('title', 'Chi tiết đơn hàng')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Chi tiết đơn hàng #{{ $order->id }}</h4>
    </div>
    <div class="card-body">
        <p><strong>Người dùng:</strong> {{ optional($order->user)->name ?? 'Không rõ' }}</p>
        <p><strong>Số điện thoại:</strong> {{ $order->shipping_phone }}</p>
        <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>     
        <p><strong>Tổng tiền:</strong> {{ number_format($order->total_amount, 0, ',', '.') }} đ</p>
        <p><strong>Địa chỉ giao hàng:</strong> {{ $order->shipping_address }}</p>
        <p><strong>Trạng thái đơn hàng:</strong> {{ ucfirst($order->status) }}</p>      
        <p><strong>Trạng thái thanh toán:</strong> 
            @php
                $paymentStatus = $order->payment?->status ?? 'unpaid';
            @endphp

            @if ($paymentStatus === 'paid' || $paymentStatus === 'success')
                    <span class="badge bg-success">Đã thanh toán</span>
                @elseif ($paymentStatus === 'failed')
                    <span class="badge bg-danger">Thanh toán thất bại</span>
                @else
                    <span class="badge bg-warning text-dark">Chưa thanh toán</span>
            @endif
        </p>
        <p><strong>Phương thức:</strong> {{ $order->payment?->method ?? 'Không rõ' }}</p>



        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Quay lại danh sách</a>
    </div>
</div>
@endsection
