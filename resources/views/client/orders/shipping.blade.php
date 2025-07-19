@extends('layouts.master')

@section('content')
    <div class="container py-5">
        <h4 class="mb-4">Thông tin giao hàng</h4>

        <form action="{{ route('client.orders.checkout') }}" method="POST">
            @csrf
            <input type="hidden" name="payment_method" value="{{ $paymentMethod }}">
            @foreach ($items as $item)
                <input type="hidden" name="selected_items[]" value="{{ $item->id }}">
            @endforeach

            <div class="row">
                {{-- Thông tin người nhận --}}
                <div class="col-md-8">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label>Họ Tên</label>
                            <input type="text" name="shipping_name" class="form-control" required
                                value="{{ auth()->user()->name ?? '' }}">
                        </div>
                        <div class="col-md-6">
                            <label>Số điện thoại</label>
                            <input type="text" name="shipping_phone" class="form-control" required
                                value="{{ auth()->user()->phone ?? '' }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="shipping_email" class="form-control"
                            value="{{ auth()->user()->email ?? '' }}">
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label>Tỉnh / Thành phố</label>
                            <input type="text" name="province" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label>Quận / Huyện</label>
                            <input type="text" name="district" class="form-control">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Khu vực giao hàng</label>
                        <div>
                            <label class="me-3">
                                <input type="radio" name="shipping_area" value="inner" checked>
                                Nội thành (Miễn phí)
                            </label>
                            <label>
                                <input type="radio" name="shipping_area" value="outer">
                                Ngoại thành (+30.000đ)
                            </label>
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

                {{-- Tóm tắt đơn hàng --}}
                <div class="col-md-4">
                    <h5 class="mb-3">Đơn hàng</h5>
                    <div class="card p-3">
                        @php
                            $subtotal = 0;
                        @endphp

                        @foreach ($items as $item)
                            @php
                                $price = $item->variant->price ?? 0;
                                $quantity = $item->quantity;
                                $lineTotal = $price * $quantity;
                                $subtotal += $lineTotal;
                            @endphp

                            <div class="d-flex align-items-center mb-3">
                                <img src="{{ asset('storage/' . $item->variant->image) }}" width="50" height="50"
                                    class="me-2" style="object-fit: cover;">
                                <div>
                                    <strong>{{ $item->variant_name }}</strong><br>
                                    Số lượng: {{ $quantity }}<br>
                                    Giá: {{ number_format($price, 0, ',', '.') }} đ
                                </div>
                            </div>
                        @endforeach

                        <hr>
                        <p><strong>Tạm tính:</strong> {{ number_format($subtotal, 0, ',', '.') }} đ</p>
                        <p><strong>Phí ship:</strong>
                            <span id="shipping-fee">0</span> đ
                        </p>
                        <p><strong>Tổng cộng:</strong> <span
                                id="total-amount">{{ number_format($subtotal, 0, ',', '.') }}</span> đ</p>
                        <button type="submit" class="btn btn-warning w-100 mt-3">Đặt hàng</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

@section('scripts')
    <script>
        const shippingRadios = document.querySelectorAll('input[name="shipping_area"]');
        const feeDisplay = document.getElementById('shipping-fee');
        const totalDisplay = document.getElementById('total-amount');
        const subtotal = {{ $subtotal ?? 0 }};

        function updateShippingFee() {
            const selected = document.querySelector('input[name="shipping_area"]:checked');
            let fee = 0;
            if (selected.value === 'outer') {
                fee = 30000;
            }
            feeDisplay.textContent = fee.toLocaleString('vi-VN');
            totalDisplay.textContent = (subtotal + fee).toLocaleString('vi-VN');
        }

        shippingRadios.forEach(radio => {
            radio.addEventListener('change', updateShippingFee);
        });

        // Gọi lần đầu để hiển thị đúng
        updateShippingFee();
    </script>
@endsection
@endsection
