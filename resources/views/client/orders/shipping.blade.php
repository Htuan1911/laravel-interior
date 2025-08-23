@extends('layouts.cart')

@section('cart-content')
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
                            <input type="province" name="shipping_province" class="form-control"
                                value="{{ auth()->user()->province ?? '' }}">
                        </div>
                        <div class="col-md-6">
                            <label>Quận / Huyện</label>
                            <input type="district" name="shipping_district" class="form-control"
                                value="{{ auth()->user()->district ?? '' }}">
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
                        <div class="mb-3">
                            <label for="coupon-code" class="form-label"><strong>Mã giảm giá:</strong></label>
                            <div class="input-group">
                                <input type="text" id="coupon-code" class="form-control" placeholder="Nhập mã giảm giá">
                                <button type="button" id="apply-coupon" class="btn btn-outline-secondary">Áp dụng</button>
                            </div>
                            <div id="coupon-message" class="text-success mt-1" style="display: none;"></div>
                        </div>

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
@endsection

@push('scripts')
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

        document.getElementById('apply-coupon').addEventListener('click', function() {
            const code = document.getElementById('coupon-code').value.trim();
            const subtotal = {{ $subtotal }};

            fetch(`/client/check-coupon?code=${code}&subtotal=${subtotal}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('coupon-message').style.display = 'block';
                        document.getElementById('coupon-message').innerText = data.message;

                        document.getElementById('shipping-fee').innerText = data.shipping_fee.toLocaleString(
                            'vi-VN');
                        document.getElementById('total-amount').innerText = data.total.toLocaleString('vi-VN');
                    } else {
                        document.getElementById('coupon-message').style.display = 'block';
                        document.getElementById('coupon-message').innerText = data.message;
                    }
                });
        });
    </script>
@endpush
