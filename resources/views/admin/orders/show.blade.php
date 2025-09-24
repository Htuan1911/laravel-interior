@extends('layouts.admin')

@section('title', 'Chi tiết đơn hàng')

@section('content')
<div class="container-fluid px-4">
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold">🧾 Đơn hàng #{{ $order->id }}</h4>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-dark">← Quay lại danh sách</a>
        </div>
        <div class="card-body">

            {{-- Thông tin khách hàng & đơn hàng --}}
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5 class="fw-bold mb-3">👤 Thông tin khách hàng</h5>
                    <p><strong>Họ tên:</strong> {{ optional($order->user)->name ?? 'Không rõ' }}</p>
                    <p><strong>Điện thoại:</strong> {{ $order->shipping_phone }}</p>
                    <p><strong>Địa chỉ:</strong> {{ $order->shipping_address }}</p>
                </div>
                <div class="col-md-6">
                    <h5 class="fw-bold mb-3">📦 Thông tin đơn hàng</h5>
                    <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                    <p><strong>Phương thức thanh toán:</strong> {{ $order->payment?->method ?? 'Không rõ' }}</p>
                    <p><strong>Tổng tiền:</strong> 
                        <span class="text-danger fs-5 fw-bold">
                            {{ number_format($order->total_amount, 0, ',', '.') }} đ
                        </span>
                    </p>
                </div>
            </div>

            {{-- Trạng thái --}}
            {{-- Trạng thái --}}
            <div class="row">
                <div class="col-md-6 mb-3">
                    <h6 class="fw-bold">🛒 Trạng thái đơn hàng:</h6>
                    @php
                        $statusSteps = [
                            'pending' => 'Chờ xác nhận',
                            'confirmed' => 'Đã xác nhận',
                            'shipping' => 'Đang giao',
                            'completed' => 'Hoàn tất',
                            'cancelled' => 'Đã hủy'
                        ];
                        $statusColor = [
                            'pending' => 'warning',
                            'confirmed' => 'info',
                            'shipping' => 'primary',
                            'completed' => 'success',
                            'cancelled' => 'danger'
                        ];
                    @endphp
                    <span class="badge bg-{{ $statusColor[$order->status] ?? 'secondary' }} px-3 py-2">
                        {{ $statusSteps[$order->status] ?? ucfirst($order->status) }}
                    </span>

                    {{-- Nếu đã hủy thì hiện lý do --}}
                    @if($order->status === 'cancelled')
                        <div class="mt-3">
                            <h6 class="fw-bold text-danger">❌ Lý do hủy:</h6>
                            <div class="p-3 border rounded bg-light">
                                {{ $order->cancel_reason ?? 'Không có lý do' }}
                            </div>
                        </div>
                    @endif
                </div>

                <div class="col-md-6 mb-3">
                    <h6 class="fw-bold">💳 Trạng thái thanh toán:</h6>
                    @php $paymentStatus = strtolower($order->payment?->status ?? 'unpaid'); @endphp
                    @if (in_array($paymentStatus, ['paid', 'success']))
                        <span class="badge bg-success px-3 py-2">Đã thanh toán</span>
                    @elseif ($paymentStatus === 'failed')
                        <span class="badge bg-danger px-3 py-2">Thanh toán thất bại</span>
                    @else
                        <span class="badge bg-warning text-dark px-3 py-2">Chưa thanh toán</span>
                    @endif
                </div>
            </div>


        </div>
    </div>
</div>
@endsection
