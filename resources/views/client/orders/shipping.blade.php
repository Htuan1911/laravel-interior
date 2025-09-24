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
                            <input type="text" name="shipping_province" id="shipping_province" class="form-control"
                                   value="{{ auth()->user()->province ?? '' }}" required>
                        </div>
                        <div class="col-md-6">
                            <label>Quận / Huyện</label>
                            <input type="text" name="shipping_district" id="shipping_district" class="form-control"
                                   value="{{ auth()->user()->district ?? '' }}" required>
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
                        <p><strong>Tổng cộng:</strong> 
                            <span id="total-amount">{{ number_format($subtotal, 0, ',', '.') }}</span> đ
                        </p>
                        <button type="submit" class="btn btn-warning w-100 mt-3">Đặt hàng</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        const provinceInput = document.getElementById('shipping_province');
        const districtInput = document.getElementById('shipping_district');
        const feeDisplay = document.getElementById('shipping-fee');
        const totalDisplay = document.getElementById('total-amount');
        const subtotal = {{ $subtotal ?? 0 }};

        // Danh sách quận nội thành Hà Nội
        const innerHanoiDistricts = [
            "Ba Đình", "Hoàn Kiếm", "Đống Đa", "Hai Bà Trưng",
            "Cầu Giấy", "Thanh Xuân", "Hoàng Mai", "Tây Hồ", "Long Biên", "Nam Từ Liêm", "Bắc Từ Liêm", "Hà Đông"
        ];

        // Danh sách quận nội thành TP.HCM
        const innerHcmDistricts = [
            "Quận 1", "Quận 3", "Quận 4", "Quận 5", "Quận 6", "Quận 7", "Quận 8",
            "Quận 10", "Quận 11", "Quận Bình Thạnh", "Quận Phú Nhuận", "Quận Gò Vấp", "Quận Tân Bình", "Quận Tân Phú"
        ];

        function updateShippingFee() {
            const province = provinceInput.value.trim();
            const district = districtInput.value.trim();
            let fee = 1000000; // mặc định ngoại thành

            if (province === "Hà Nội" && innerHanoiDistricts.includes(district)) {
                fee = 0;
            } else if (province === "Hồ Chí Minh" && innerHcmDistricts.includes(district)) {
                fee = 0;
            }

            feeDisplay.textContent = fee.toLocaleString('vi-VN');
            totalDisplay.textContent = (subtotal + fee).toLocaleString('vi-VN');
        }

        provinceInput.addEventListener('input', updateShippingFee);
        districtInput.addEventListener('input', updateShippingFee);

        // Gọi khi load trang nếu có dữ liệu sẵn
        updateShippingFee();

        // Áp dụng mã giảm giá
        document.getElementById('apply-coupon').addEventListener('click', function() {
            const code = document.getElementById('coupon-code').value.trim();
            const subtotal = {{ $subtotal }};

            fetch(`/client/check-coupon?code=${code}&subtotal=${subtotal}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('coupon-message').style.display = 'block';
                        document.getElementById('coupon-message').innerText = data.message;

                        document.getElementById('shipping-fee').innerText = data.shipping_fee.toLocaleString('vi-VN');
                        document.getElementById('total-amount').innerText = data.total.toLocaleString('vi-VN');
                    } else {
                        document.getElementById('coupon-message').style.display = 'block';
                        document.getElementById('coupon-message').innerText = data.message;
                    }
                });
        });
    </script>
@endpush
