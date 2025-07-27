@extends('layouts.cart')

@section('cart-content')
    <div class="main-content" id="cart">
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <!-- main -->
        <div id="wrapper-site">
            <!-- breadcrumb -->
            <nav class="breadcrumb-bg">
                <div class="container no-index">
                    <div class="breadcrumb">
                        <ol>
                            <li>
                                <a href="#">
                                    <span>Home</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span>Shopping Cart</span>
                                </a>
                            </li>
                        </ol>
                    </div>
                </div>
            </nav>
            <div class="container">
                <div class="row">
                    <div id="content-wrapper" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 onecol">
                        <section id="main">
                            <div class="cart-grid row">
                                <div class="col-md-9 col-xs-12 check-info">
                                    <h1 class="title-page">Shopping Cart</h1>
                                    <div class="cart-container">
                                        <div class="cart-overview js-cart">
                                            <ul class="cart-items">
                                                @foreach ($cart->items as $item)
                                                    @php
                                                        $variant = $item->variant;
                                                        $product = $variant ? $variant->product : null;
                                                        $productName =
                                                            $product &&
                                                            $product->translations &&
                                                            $product->translations->first()
                                                                ? $product->translations->first()->name
                                                                : '--- Sản phẩm không tồn tại ---';
                                                        $subtotal = $variant ? $variant->price * $item->quantity : 0;
                                                    @endphp
                                                    <li class="cart-item">
                                                        <div class="product-line-grid row justify-content-between">
                                                            <!-- Checkbox for selection -->
                                                            <div class="col-12 mb-2">
                                                                <input type="checkbox" name="selected_items[]"
                                                                    value="{{ $item->id }}"
                                                                    data-price="{{ $subtotal }}" form="checkout-form"
                                                                    class="me-2">
                                                                <label>Chọn sản phẩm</label>
                                                            </div>
                                                            <!-- Product left content: image -->
                                                            <div class="product-line-grid-left col-md-2">
                                                                <span class="product-image media-middle">
                                                                    <a href="product-detail.html">
                                                                        <img class="img-fluid"
                                                                            src="{{ asset('storage/' . ($variant->image ?? $product->image)) }}"
                                                                            alt="{{ $productName }}"
                                                                            style="object-fit: cover; width: 80px; height: 80px;">
                                                                    </a>
                                                                </span>
                                                            </div>

                                                            <!-- Product info -->
                                                            <div class="product-line-grid-body col-md-6">
                                                                <div class="product-line-info">
                                                                    <a class="label" href="product-detail.html"
                                                                        data-id_customization="0">
                                                                        {{ $productName }}
                                                                    </a>
                                                                </div>
                                                                <div class="product-line-info product-price">
                                                                    <span class="label-atrr">Giá:</span>
                                                                    <span
                                                                        class="value">{{ number_format($variant->price, 0, ',', '.') }}
                                                                        đ</span>
                                                                </div>
                                                                @if ($variant->size ?? false)
                                                                    <div class="product-line-info">
                                                                        <span class="label-atrr">Size:</span>
                                                                        <span class="value">{{ $variant->size }}</span>
                                                                    </div>
                                                                @endif
                                                                @if ($variant->color ?? false)
                                                                    <div class="product-line-info">
                                                                        <span class="label-atrr">Color:</span>
                                                                        <span class="value">{{ $variant->color }}</span>
                                                                    </div>
                                                                @endif
                                                            </div>

                                                            <!-- Actions: quantity and remove -->
                                                            <div
                                                                class="product-line-grid-right text-center product-line-actions col-md-4">
                                                                <div class="row">
                                                                    <div class="col-md-5 col qty">
                                                                        <div class="label">Số lượng:</div>
                                                                        <div
                                                                            class="quantity d-inline-flex align-items-center border rounded">
                                                                            <!-- Decrease quantity form -->
                                                                            <form
                                                                                action="{{ route('client.carts.decrease', $item->id) }}"
                                                                                method="POST" style="display:inline;">
                                                                                @csrf
                                                                                <button
                                                                                    class="btn btn-sm btn-light px-2 btn-touchspin js-touchspin bootstrap-touchspin-down"
                                                                                    type="submit">
                                                                                    −
                                                                                </button>
                                                                            </form>

                                                                            <!-- Current quantity -->
                                                                            <span class="mx-2 form-control text-center"
                                                                                style="width: 60px; border: none;">
                                                                                {{ $item->quantity }}
                                                                            </span>

                                                                            <!-- Increase quantity form -->
                                                                            <form
                                                                                action="{{ route('client.carts.increase', $item->id) }}"
                                                                                method="POST" style="display:inline;">
                                                                                @csrf
                                                                                <button
                                                                                    class="btn btn-sm btn-light px-2 btn-touchspin js-touchspin bootstrap-touchspin-up"
                                                                                    type="submit">
                                                                                    +
                                                                                </button>
                                                                            </form>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-5 col price">
                                                                        <div class="label">Tổng:</div>
                                                                        <div class="product-price total">
                                                                            {{ number_format($subtotal, 0, ',', '.') }} đ
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-2 col text-xs-right align-self-end">
                                                                        <div class="cart-line-product-actions">
                                                                            <form
                                                                                action="{{ route('client.carts.remove', $item->id) }}"
                                                                                method="POST"
                                                                                onsubmit="return confirm('Bạn chắc chắn muốn xoá sản phẩm này?');"
                                                                                style="display:inline;">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="submit"
                                                                                    class="remove-from-cart btn btn-link p-0"
                                                                                    style="color: #dc3545;">
                                                                                    <i class="fa fa-trash-o"
                                                                                        aria-hidden="true"></i>
                                                                                </button>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <form id="checkout-form" action="{{ route('client.orders.shipping') }}" method="GET"
                                        class="d-inline-block p-3 border rounded"
                                        style="max-width: 400px; background-color: #f9f9f9;">
                                        <div class="mb-2">
                                            <label class="form-label fw-semibold mb-2">Phương thức thanh toán:</label>

                                            <div class="form-check mb-1">
                                                <input class="form-check-input" type="radio" name="payment_method"
                                                    id="cod" value="cod" checked>
                                                <label class="form-check-label" for="cod">
                                                    Thanh toán khi nhận hàng
                                                </label>
                                            </div>

                                            <div class="form-check mb-1">
                                                <input class="form-check-input" type="radio" name="payment_method"
                                                    id="momo" value="momo">
                                                <label class="form-check-label" for="momo">
                                                    Thanh toán MoMo
                                                </label>
                                            </div>

                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" name="payment_method"
                                                    id="vnpay" value="vnpay">
                                                <label class="form-check-label" for="vnpay">
                                                    Thanh toán VNPAY
                                                </label>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary w-100">
                                            Tiếp tục
                                        </button>
                                    </form>
                                </div>
                                @php
                                    $totalQuantity = 0;
                                    $subtotal = 0;

                                    if (isset($cart) && $cart->items && $cart->items->count()) {
                                        foreach ($cart->items as $item) {
                                            $quantity = $item->quantity;
                                            $price = $item->variant->price ?? 0;

                                            $totalQuantity += $quantity;
                                            $subtotal += $quantity * $price;
                                        }
                                    }

                                    $shippingFee = 0; // có thể tuỳ biến
                                    $total = $subtotal + $shippingFee;
                                @endphp

                                <div class="cart-grid-right col-xs-12 col-lg-3">
                                    <div class="cart-summary">
                                        <div class="cart-detailed-totals">
                                            <div class="cart-summary-products">
                                                <div class="summary-label">
                                                    Có {{ $totalQuantity }} sản phẩm trong giỏ hàng
                                                </div>
                                            </div>

                                            <div class="cart-summary-line" id="cart-subtotal-products">
                                                <span class="label js-subtotal">Tạm tính:</span>
                                                <span class="value">{{ number_format($subtotal, 0, ',', '.') }} đ</span>
                                            </div>

                                            <div class="cart-summary-line" id="cart-subtotal-shipping">
                                                <span class="label">Phí vận chuyển:</span>
                                                <span
                                                    class="value">{{ $shippingFee == 0 ? 'Miễn phí' : number_format($shippingFee, 0, ',', '.') . ' đ' }}</span>
                                            </div>

                                            <div class="cart-summary-line cart-total">
                                                <span class="label">Tổng cộng:</span>
                                                <span class="value">{{ number_format($total, 0, ',', '.') }} đ</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('checkout-form');
                form.addEventListener('submit', function(e) {
                    const checkedItems = document.querySelectorAll('input[name="selected_items[]"]:checked');
                    if (checkedItems.length === 0) {
                        e.preventDefault();
                        alert('Vui lòng chọn ít nhất một sản phẩm để tiếp tục thanh toán!');
                    }
                });
            });
        </script>
    @endpush
@endsection
