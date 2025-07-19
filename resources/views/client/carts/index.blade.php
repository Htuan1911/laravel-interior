@extends('layouts.master')

@section('content')
    <style>
        .cart-table thead th {
            background-color: #c79853;
            color: white;
            text-align: center;
        }

        .cart-table td,
        .cart-table th {
            vertical-align: middle;
            text-align: center;
        }

        .cart-actions input {
            max-width: 150px;
            display: inline-block;
        }

        .total-box {
            background: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
            padding: 20px;
            border-radius: 8px;
            display: inline-block;
        }
    </style>

    <div class="container py-5">
        <h4 class="mb-4">Giỏ hàng của bạn</h4>

        @if (!$cart || $cart->items->isEmpty())
            <p>Bạn chưa có sản phẩm nào trong giỏ.</p>
        @else
            <table class="table cart-table align-middle">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="checkAll"></th>
                        <th>Hình ảnh</th>
                        <th>Tên</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Tạm tính</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cart->items as $item)
                        @php
                            $variant = $item->variant;
                            $product = $variant->product;
                            $productName = $product->translations->first()->name ?? '---';
                            $subtotal = $variant->price * $item->quantity;
                        @endphp
                        <tr>
                            <td>
                                <input type="checkbox" name="selected_items[]" value="{{ $item->id }}"
                                    data-price="{{ $subtotal }}" form="checkout-form">
                            </td>
                            <td>
                                <img src="{{ asset('storage/' . ($variant->image ?? $product->image)) }}" width="60"
                                    height="60" style="object-fit: cover;" />
                            </td>
                            <td>{{ $productName }}</td>
                            <td>{{ number_format($variant->price, 0, ',', '.') }} đ</td>
                            <td>
                                <div class="d-inline-flex align-items-center border rounded px-2">
                                    <form action="{{ route('client.carts.decrease', $item->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        <button class="btn btn-sm btn-light px-2" type="submit">−</button>
                                    </form>

                                    <span class="mx-2">{{ $item->quantity }}</span>

                                    <form action="{{ route('client.carts.increase', $item->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        <button class="btn btn-sm btn-light px-2" type="submit">+</button>
                                    </form>
                                </div>
                            </td>
                            <td>{{ number_format($subtotal, 0, ',', '.') }} đ</td>
                            <td>
                                <form action="{{ route('client.carts.remove', $item->id) }}" method="POST"
                                    onsubmit="return confirm('Bạn chắc chắn muốn xoá sản phẩm này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">X</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Mã giảm giá và tổng tiền --}}
            <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap">
                <div class="cart-actions d-flex gap-2">
                    <input type="text" class="form-control" placeholder="Mã giảm giá" disabled>
                    <button class="btn btn-warning text-white" disabled>Thêm</button>
                </div>

                <div class="total-box">
                    <form action="{{ route('client.orders.shipping') }}" method="GET" id="checkout-form">
                        <div class="total-box">
                            <p class="mb-2">
                                <strong>Tổng tiền:</strong>
                                <span id="total-price">0</span> đ
                            </p>

                            <div class="mb-2">
                                <label><input type="radio" name="payment_method" value="cod" checked> Thanh toán khi
                                    nhận hàng</label><br>
                                <label><input type="radio" name="payment_method" value="online"> Thanh toán online</label>
                            </div>

                            <button class="btn btn-warning text-white" type="submit">Tiếp tục thanh toán</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>

@section('scripts')
    <script>
        function formatNumber(num) {
            return num.toLocaleString('vi-VN');
        }

        function updateTotal() {
            let total = 0;
            document.querySelectorAll('input[name="selected_items[]"]:checked').forEach(cb => {
                total += parseInt(cb.dataset.price);
            });
            document.getElementById('total-price').textContent = formatNumber(total);
        }

        // Cập nhật khi từng checkbox thay đổi
        document.querySelectorAll('input[name="selected_items[]"]').forEach(cb => {
            cb.addEventListener('change', updateTotal);
        });

        // Chọn tất cả
        document.getElementById('checkAll').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('input[name="selected_items[]"]');
            checkboxes.forEach(cb => cb.checked = this.checked);
            updateTotal();
        });

        // Kiểm tra khi submit form thanh toán
        document.getElementById('checkout-form').addEventListener('submit', function(e) {
            const selected = document.querySelectorAll('input[name="selected_items[]"]:checked');
            if (selected.length === 0) {
                e.preventDefault(); // Ngăn form submit
                alert('Vui lòng chọn ít nhất một sản phẩm để thanh toán.');
            }
        });
        // Tính tổng ngay từ đầu
        updateTotal();
    </script>
@endsection


@endsection
