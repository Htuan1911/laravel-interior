@extends('layouts.master')

@section('content')
    <div class="container py-5">
        <h3>Lịch sử đơn hàng</h3>

        @if ($orders->isEmpty())
            <p>Bạn chưa có đơn hàng nào.</p>
        @else
            @foreach ($orders as $order)
                <div class="card mb-4">
                    <div class="card-header">
                        <strong>Mã đơn:</strong> {{ $order->id }} |
                        <strong>Tổng:</strong> {{ number_format($order->total_amount, 0, ',', '.') }} đ |
                        <strong>Trạng thái:</strong> {{ $order->status }} |
                        <strong>Phương thức:</strong>
                        @switch(optional($order->payment)->method)
                            @case('cod')
                                Thanh toán khi nhận hàng
                            @break

                            @case('online')
                                Ví MoMo
                            @break

                            @default
                                <span class="text-danger">Không xác định</span>
                        @endswitch
                    </div>

                    <div class="card-body">
                        <p><strong>Người nhận:</strong> {{ $order->shipping_name }} - {{ $order->shipping_phone }}</p>
                        <p><strong>Địa chỉ:</strong> {{ $order->shipping_address }}</p>

                        <ul class="list-unstyled">
                            @foreach ($order->items as $item)
                                <li class="mb-3 d-flex align-items-center">
                                    <img src="{{ asset('storage/' . ($item->variant->image ?? 'default.jpg')) }}"
                                        alt="Sản phẩm" width="60" height="60" class="me-3"
                                        style="object-fit: cover;">

                                    <div>
                                        <strong>{{ $item->variant_name }}</strong><br>
                                        SL: {{ $item->quantity }} |
                                        Đơn giá: {{ number_format($item->unit_price, 0, ',', '.') }} đ |
                                        Tổng: {{ number_format($item->total_price, 0, ',', '.') }} đ
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endsection
