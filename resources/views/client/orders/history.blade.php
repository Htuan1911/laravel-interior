@extends('layouts.cart')

@section('cart-content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <div class="container py-5">
        <h3>Lịch sử đơn hàng</h3>

        @if ($orders->isEmpty())
            <p>Bạn chưa có đơn hàng nào.</p>
        @else
            @foreach ($orders as $order)
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <strong>Mã đơn:</strong> {{ $order->id }} |
                            <strong>Tổng:</strong> {{ number_format($order->total_amount, 0, ',', '.') }} đ |
                            <strong>Trạng thái:</strong> {{ $order->status_label }} |
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

                        @if ($order->status === 'pending')
                            <form action="{{ route('client.orders.cancel', $order->id) }}" method="POST"
                                onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này không?')">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Hủy đơn</button>
                            </form>
                        @endif
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
