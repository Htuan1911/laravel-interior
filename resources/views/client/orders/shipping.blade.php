@extends('layouts.master')

@section('content')
    <div class="container py-5">
        <h4 class="mb-4">Thông tin giao hàng</h4>

        <form action="{{ route('client.orders.checkout') }}" method="POST">
            @csrf
            <input type="hidden" name="payment_method" value="{{ $paymentMethod }}">

            <div class="row">
                {{-- Bên trái: Form nhập thông tin --}}
                <div class="col-md-8">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label>Họ Tên</label>
                            <input type="text" name="shipping_name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Số điện thoại</label>
                            <input type="text" name="shipping_phone" class="form-control" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="shipping_email" class="form-control">
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label>Tỉnh / Thành phố</label>
                            <input type="text" name="province" class="form-control" placeholder="Nhập tỉnh/thành phố">
                        </div>
                        <div class="col-md-6">
                            <label>Quận / Huyện</label>
                            <input type="text" name="district" class="form-control" placeholder="Nhập quận/huyện">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Địa chỉ chi tiết</label>
                        <textarea name="shipping_address" class="form-control" rows="2" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label>Ghi chú</label>
                        <textarea name="note" class="form-control" rows="2"></textarea>
                    </div>
                </div>

                {{-- Bên phải: Tóm tắt đơn hàng --}}
                <div class="col-md-4">
                    <h5 class="mb-3">Đặt hàng</h5>
                    <div class="card p-3">
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ asset('storage/' . $cart->items->first()->variant->image) }}" width="50"
                                height="50" class="me-2" style="object-fit: cover;">
                            <div>
                                <strong>{{ $cart->items->first()->variant_name ?? 'Sản phẩm' }}</strong><br>
                                Số lượng: {{ $cart->items->first()->quantity }}
                            </div>
                        </div>

                        @php
                            $unit = $cart->items->first()->variant->price ?? 0;
                            $subtotal = $unit * $cart->items->first()->quantity;
                            $discount = 0; // nếu có
                            $total = $subtotal - $discount;
                        @endphp

                        <p>Giá: {{ number_format($unit, 0, ',', '.') }} đ</p>
                        <p>Khuyến mãi: {{ number_format($discount, 0, ',', '.') }} đ</p>
                        <p><strong>Tạm tính:</strong> {{ number_format($subtotal, 0, ',', '.') }} đ</p>
                        <hr>
                        <p><strong>Tổng cộng:</strong> {{ number_format($total, 0, ',', '.') }} đ</p>

                        <button type="submit" class="btn btn-warning w-100">Đặt hàng</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
