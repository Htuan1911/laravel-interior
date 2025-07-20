@extends('layouts.master')

@section('title', 'Trang chủ')

@section('content')

<div class="category-product-index owl-carousel owl-theme">
    @foreach($products as $product)
    <div class="item text-center">
        <div class="product-miniature js-product-miniature item-one">
            <div class="thumbnail-container">
                <a href="{{ route('client.products.show', $product->id) }}">
                    <img class="img-fluid image-cover" src="{{ asset('img/product/' . $product->main_image) }}"
                        alt="{{ $product->name }}">

                    <img class="img-fluid image-secondary"
                        src="{{ isset($product->variant_image) ? asset('img/product/' . $product->variant_image) : asset('img/product/' . $product->main_image) }}"
                        alt="{{ $product->name }}">

                </a>
                @if($product->old_price)
                <div class="product-flags discount">
                    {{ floor((($product->old_price - $product->price) / $product->old_price) * 100) }}%
                </div>
                @endif
            </div>
            <div class="product-description">
                <div class="product-groups">
                    <div class="product-title">
                        <a href="{{ route('client.products.show', $product->id) }}">
                            {{ $product->name }}
                        </a>
                    </div>
                    <div class="rating">
                        <div class="star-content">
                            <div class="star"></div>
                            <div class="star"></div>
                            <div class="star"></div>
                            <div class="star"></div>
                            <div class="star"></div>
                        </div>
                    </div>
                    <div class="product-group-price">
                        <div class="product-price-and-shipping">
                            <span class="price">{{ number_format($product->price) }} đ</span>
                            @if($product->old_price)
                            <del class="regular-price">{{ number_format($product->old_price) }} đ</del>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="product-buttons d-flex justify-content-center">
                    <form action="#" method="post" class="formAddToCart">
                        <a class="add-to-cart" href="#" data-button-action="add-to-cart">
                            <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                        </a>
                    </form>
                    <a class="addToWishlist" href="#" data-rel="1" onclick="">
                        <i class="fa fa-heart" aria-hidden="true"></i>
                    </a>
                    <a href="#" class="quick-view hidden-sm-down" data-link-action="quickview">
                        <i class="fa fa-eye" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>



@auth
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        Tài khoản
    </a>
    <ul class="dropdown-menu" aria-labelledby="accountDropdown">
        <li><a class="dropdown-item" href="{{ route('client.account.info') }}">Thông tin cá nhân</a></li>
        <li><a class="dropdown-item" href="{{ route('client.account.vouchers') }}">Kho voucher</a></li>
        <li><a class="dropdown-item" href="{{ route('client.account.orders') }}">Lịch sử đơn hàng</a></li>
        <li><a class="dropdown-item" href="{{ route('client.account.wishlist') }}">Yêu thích</a></li>
    </ul>
</li>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


@endauth


@endsection