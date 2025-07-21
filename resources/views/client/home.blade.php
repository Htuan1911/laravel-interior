@extends('layouts.master')

@section('title', 'Trang chủ')

@section('content')

    <div class="product-miniature first-item js-product-miniature item-one">
        <div class="thumbnail-container">
            <a href="product-detail.html">
                <img class="img-fluid image-cover" src="img/product/1.jpg" alt="img">
                <img class="img-fluid image-secondary" src="img/product/5.jpg" alt="img">
            </a>
            <div class="product-flags discount">-30%</div>
            <div class="highlighted-informations">
                <div class="variant-links">
                    <a href="#" class="color beige" title="Beige"></a>
                    <a href="#" class="color orange" title="Orange"></a>
                    <a href="#" class="color green" title="Green"></a>
                </div>
            </div>
        </div>
        <div class="product-description">
            <div class="product-groups">
                <div class="product-title">
                    <a href="product-detail.html">Nulla et
                        justo non augue</a>
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
                        <span class="price">£20.08</span>
                        <del class="regular-price">£28.68</del>
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
@endsection
