@extends('layouts.client')

@section('contentproduct')
<div class="main-content">
    <div id="wrapper-site">
        <div id="content-wrapper" class="full-width">
            <div id="main">
                <div class="page-home">
                    <!-- breadcrumb -->
                    <nav class="breadcrumb-bg">
                        <div class="container no-index">
                            <div class="breadcrumb">
                                <ol>
                                    <li>
                                        <a href="{{ url('/client') }}">
                                            <span>Home</span>
                                        </a>
                                    </li>
                                    
                                </ol>
                            </div>
                        </div>
                    </nav>

                    <div class="container">
                        <div class="content">
                            <div class="row">
                                <div class="sidebar-3 sidebar-collection col-lg-3 col-md-4 col-sm-4">

                                    <!-- category menu -->
                                    <div class="sidebar-block">
                                        <div class="title-block">Categories</div>
                                        <div class="block-content">
                                            <div class="cateTitle hasSubCategory open level1">
                                                <span class="arrow collapsed collapse-icons" data-toggle="collapse"
                                                    data-target="#livingroom" aria-expanded="false" role="status">
                                                    <i class="zmdi zmdi-minus"></i>
                                                    <i class="zmdi zmdi-plus"></i>
                                                </span>
                                                <a class="cateItem" href="#">Living Room</a>
                                                <div class="subCategory collapse" id="livingroom" aria-expanded="true"
                                                    role="status">
                                                    <div class="cateTitle">
                                                        <a href="#" class="cateItem">Side Table</a>
                                                        <div class="subCategory collapse" id="subCategory-fruits"
                                                            aria-expanded="true" role="status">
                                                            <div class="cateTitle">
                                                                <a href="#" class="cateItem">Side Table</a>
                                                            </div>
                                                            <div class="cateTitle">
                                                                <a href="#" class="cateItem">FIREPLACE</a>
                                                            </div>
                                                            <div class="cateTitle">
                                                                <a href="#" class="cateItem">FIREPLACE</a>
                                                            </div>
                                                            <div class="cateTitle">
                                                                <a href="#" class="cateItem">floor lamp</a>
                                                            </div>
                                                            <div class="cateTitle">
                                                                <a href="#" class="cateItem">ottoman</a>
                                                            </div>
                                                            <div class="cateTitle">
                                                                <a href="#" class="cateItem">armchair</a>
                                                            </div>
                                                            <div class="cateTitle">
                                                                <a href="#" class="cateItem">cushion</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="cateTitle">
                                                        <a href="#" class="cateItem">FIREPLACE</a>
                                                    </div>
                                                    <div class="cateTitle">
                                                        <a href="#" class="cateItem">FIREPLACE</a>
                                                    </div>
                                                    <div class="cateTitle">
                                                        <a href="#" class="cateItem">floor lamp</a>
                                                    </div>
                                                    <div class="cateTitle">
                                                        <a href="#" class="cateItem">ottoman</a>
                                                    </div>
                                                    <div class="cateTitle">
                                                        <a href="#" class="cateItem">armchair</a>
                                                    </div>
                                                    <div class="cateTitle">
                                                        <a href="#" class="cateItem">cushion</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="cateTitle hasSubCategory open level1">
                                                <span class="arrow collapsed collapse-icons" data-toggle="collapse"
                                                    data-target="#bathroom" aria-expanded="false" role="status">
                                                    <i class="zmdi zmdi-minus"></i>
                                                    <i class="zmdi zmdi-plus"></i>
                                                </span>
                                                <a class="cateItem" href="#">Bathroom</a>
                                                <div class="subCategory collapse" id="bathroom" aria-expanded="false"
                                                    role="status">
                                                    <div class="cateTitle">
                                                        <a href="#" class="cateItem">TOMATO</a>
                                                    </div>
                                                    <div class="cateTitle">
                                                        <a href="#" class="cateItem">BROCCOLI</a>
                                                    </div>
                                                    <div class="cateTitle">
                                                        <a href="#" class="cateItem">CABBAGE</a>
                                                    </div>
                                                    <div class="cateTitle">
                                                        <a href="#" class="cateItem">CUCUMBER</a>
                                                    </div>
                                                    <div class="cateTitle">
                                                        <a href="#" class="cateItem">EGGPLANT</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="cateTitle hasSubCategory open level1">
                                                <span class="arrow collapsed collapse-icons" data-toggle="collapse"
                                                    data-target="#diningroom" aria-expanded="false" role="status">
                                                    <i class="zmdi zmdi-minus"></i>
                                                    <i class="zmdi zmdi-plus"></i>
                                                </span>
                                                <a class="cateItem" href="#">Dining Rooom</a>
                                                <div class="subCategory collapse" id="diningroom" aria-expanded="true"
                                                    role="status">
                                                    <div class="cateTitle">
                                                        <a href="#" class="cateItem">DRY BREAD</a>
                                                    </div>
                                                    <div class="cateTitle">
                                                        <a href="#" class="cateItem">BREAD SLICES</a>
                                                    </div>
                                                    <div class="cateTitle">
                                                        <a href="#" class="cateItem">FRENCH BREAD</a>
                                                    </div>
                                                    <div class="cateTitle">
                                                        <a href="#" class="cateItem">BLACK BREAD</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="cateTitle hasSubCategory open level1">
                                                <span class="arrow collapsed collapse-icons" data-toggle="collapse"
                                                    data-target="#bedroom" aria-expanded="false" role="status">
                                                    <i class="zmdi zmdi-minus"></i>
                                                    <i class="zmdi zmdi-plus"></i>
                                                </span>
                                                <a class="cateItem" href="#">BedRoom</a>
                                                <div class="subCategory collapse" id="bedroom" aria-expanded="true"
                                                    role="status">
                                                    <div class="cateTitle">
                                                        <a href="#" class="cateItem">ORANGE JUICES</a>
                                                    </div>
                                                    <div class="cateTitle">
                                                        <a href="#" class="cateItem">TOMATO JUICES</a>
                                                    </div>
                                                    <div class="cateTitle">
                                                        <a href="#" class="cateItem">APPLE JUICES</a>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="cateTitle hasSubCategory open level1">
                                                <span class="arrow collapsed collapse-icons" data-toggle="collapse"
                                                    data-target="#kitchen" aria-expanded="false" role="status">
                                                    <i class="zmdi zmdi-minus"></i>
                                                    <i class="zmdi zmdi-plus"></i>
                                                </span>
                                                <a class="cateItem" href="#">Kitchen</a>
                                                <div class="subCategory collapse" id="kitchen" aria-expanded="true"
                                                    role="status">
                                                    <div class="cateTitle">
                                                        <a href="#" class="cateItem">ORANGE JUICES</a>
                                                    </div>
                                                    <div class="cateTitle">
                                                        <a href="#" class="cateItem">TOMATO JUICES</a>
                                                    </div>
                                                    <div class="cateTitle">
                                                        <a href="#" class="cateItem">APPLE JUICES</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- best seller -->
                                    <div class="sidebar-block">
                                        <div class="title-block">Catalog</div>
                                        <div class="new-item-content">
                                            <h3 class="title-product">categories</h3>
                                            <ul class="scroll-product">
                                                <li>
                                                    <label class="check">
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <a href="#">
                                                        <b>side table</b>
                                                        <span class="quantity">(30)</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <label class="check">
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <a href="#">
                                                        <b>floor lamp</b>
                                                        <span class="quantity">(32)</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <label class="check">
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <a href="#">
                                                        <b>ottoman</b>
                                                        <span class="quantity">(67)</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <label class="check">
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <a href="#">
                                                        <b>armchair</b>
                                                        <span class="quantity">(15)</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <label class="check">
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <a href="#">
                                                        <b>ottoman</b>
                                                        <span class="quantity">(24)</span>

                                                    </a>
                                                </li>
                                                <li>
                                                    <label class="check">
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <a href="#">
                                                        <b>CUSHION</b>
                                                        <span class="quantity">(20)</span>

                                                    </a>
                                                </li>
                                                <li>
                                                    <label class="check">
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <a href="#">
                                                        <b>Pineapple</b>
                                                        <span class="quantity">(21)</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="new-item-content">
                                            <h3 class="title-product">Manufacture</h3>
                                            <ul class="scroll-product">
                                                <li>
                                                    <label class="check">
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <a href="#">
                                                        <b>Samsung</b>
                                                        <span class="quantity">(30)</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <label class="check">
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <a href="#">
                                                        <b>Dell</b>
                                                        <span class="quantity">(30)</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <label class="check">
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <a href="#">
                                                        <b>Polygon</b>
                                                        <span class="quantity">(30)</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <label class="check">
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <a href="#">
                                                        <b>Newment</b>
                                                        <span class="quantity">(30)</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <label class="check">
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <a href="#">
                                                        <b>Asus</b>
                                                        <span class="quantity">(30)</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <label class="check">
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <a href="#">
                                                        <b>Mac</b>
                                                        <span class="quantity">(30)</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <label class="check">
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <a href="#">
                                                        <b>Vaio</b>
                                                        <span class="quantity">(30)</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <label class="check">
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <a href="#">
                                                        <b>Lettuce</b>
                                                        <span class="quantity">(30)</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="tiva-filter-price new-item-content sidebar-block">
                                            <h3 class="title-product">By Price</h3>
                                            <div id="block_price_filter" class="block">
                                                <div class="block-content">
                                                    <div id="slider-range" class="tiva-filter">
                                                        <div class="filter-itemprice-filter">
                                                            <div class="layout-slider">
                                                                <input id="price-filter" name="price" value="0;100" />
                                                            </div>
                                                            <div class="layout-slider-settings"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="sidebar-block by-color">
                                            <h3 class="title-product">By Color</h3>
                                            <div>
                                                <span class="left">
                                                    <label class="color-item1"></label>
                                                    <a href="#">
                                                        <span>Blue
                                                            <span>(30)</span>
                                                        </span>
                                                    </a>
                                                </span>
                                                <span class="right">
                                                    <label class="color-item2"></label>
                                                    <a href="#">
                                                        <span>Green
                                                            <span>(30)</span>
                                                        </span>
                                                    </a>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="left">
                                                    <label class="color-item3"></label>
                                                    <a href="#">
                                                        <span>Yellow
                                                            <span>(30)</span>
                                                        </span>
                                                    </a>
                                                </span>
                                                <span class="right">
                                                    <label class="color-item4"></label>
                                                    <a href="#">
                                                        <span>Brown
                                                            <span>(30)</span>
                                                        </span>
                                                    </a>
                                                </span>

                                            </div>
                                            <div>
                                                <span class="left">
                                                    <label class="color-item5"></label>
                                                    <a href="#">
                                                        <span>Pink
                                                            <span>(30)</span>
                                                        </span>
                                                    </a>
                                                </span>
                                                <span class="right">
                                                    <label class="color-item6"></label>
                                                    <a href="#">
                                                        <span>Red
                                                            <span>(30)</span>
                                                        </span>
                                                    </a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- product tag -->
                                    
                                </div>
                                <div class="col-sm-8 col-lg-9 col-md-8 product-container">
                                    <h1>Lingving Room</h1>
                                    <div class="js-product-list-top firt nav-top">
                                        <div class="d-flex justify-content-around row">
                                            <div class="col col-xs-12">
                                                <ul class="nav nav-tabs">
                                                    <li>
                                                        <a href="#grid" data-toggle="tab"
                                                            class="active show fa fa-th-large"></a>
                                                    </li>
                                                    <li>
                                                        <a href="#list" data-toggle="tab" class="fa fa-list-ul"></a>
                                                    </li>
                                                </ul>
                                                <div class="hidden-sm-down total-products">
                                                    <p>There are 12 products.</p>
                                                </div>
                                            </div>
                                            <div class="col col-xs-12">
                                                <div
                                                    class="d-flex sort-by-row justify-content-lg-end justify-content-md-end">

                                                    <div class="products-sort-order dropdown">
                                                        <select class="select-title">
                                                            <option value="">Sort by</option>
                                                            <option value="">Name, A to Z</option>
                                                            <option value="">Name, Z to A</option>
                                                            <option value="">Price, low to high</option>
                                                            <option value="">Price, high to low</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-content product-items">
                                        <div id="grid" class="related tab-pane fade in active show">
                                            <div class="row">
                                                <div class="container py-5">
                                                    <div class="row g-4">
                                                        @foreach ($products as $product)
                                                            @php
                                                                $translation = $product->translations->first();
                                                                $variant = $product->variants->first();
                                                                $discountPercent = null;
                                                                if ($variant && $variant->price > 0 && $product->base_price > 0) {
                                                                    $discountPercent = round(
                                                                        (($product->base_price - $variant->price) / $product->base_price) * 100,
                                                                    );
                                                                }
                                                            @endphp

                                                            <div class="item text-center col-md-4">
                                                                <div class="product-miniature js-product-miniature item-one first-item">
                                                                    <div class="thumbnail-container border position-relative">
                                                                        {{-- Badge giảm giá --}}
                                                                        @if ($discountPercent)
                                                                            <div class="badge-sale position-absolute" style="top: 10px; left: 10px; background: #dc3545; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; font-weight: bold; z-index: 2;">
                                                                                -{{ $discountPercent }}%
                                                                            </div>
                                                                        @endif

                                                                        <a href="{{ route('client.products.show', $product->id) }}">
                                                                            <img class="img-fluid image-cover"
                                                                                src="{{ asset('storage/' . $product->image) }}" 
                                                                                alt="{{ $translation->name }}">
                                                                            @if ($variant && $variant->image)
                                                                                <img class="img-fluid image-secondary"
                                                                                    src="{{ asset('storage/' . $variant->image) }}" 
                                                                                    alt="hover image">
                                                                            @endif
                                                                        </a>
                                                                        
                                                                        {{-- Variant colors - placeholder cho tương lai --}}
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
                                                                                <a href="{{ route('client.products.show', $product->id) }}">
                                                                                    {{ $translation->name }}
                                                                                </a>
                                                                            </div>
                                                                            
                                                                            {{-- Rating - có thể customize dựa trên dữ liệu thực --}}
                                                                            <div class="rating">
                                                                                <div class="star-content">
                                                                                    @for($i = 1; $i <= 5; $i++)
                                                                                        <div class="star"></div>
                                                                                    @endfor
                                                                                </div>
                                                                            </div>

                                                                            <div class="product-group-price">
                                                                                <div class="product-price-and-shipping">
                                                                                    @if ($discountPercent)
                                                                                        <span class="price">{{ number_format($variant->price, 0, ',', '.') }} đ</span>
                                                                                        <span class="regular-price text-decoration-line-through text-muted ms-2" style="font-size: 0.9em;">
                                                                                            {{ number_format($product->base_price, 0, ',', '.') }} đ
                                                                                        </span>
                                                                                    @else
                                                                                        <span class="price">
                                                                                            {{ number_format($variant->price ?? $product->base_price, 0, ',', '.') }} đ
                                                                                        </span>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="product-buttons d-flex justify-content-center">
                                                                            {{-- Add to Cart Button --}}
                                                                            @auth
                                                                                <form action="{{ route('client.carts.add') }}" method="POST" class="formAddToCart">
                                                                                    @csrf
                                                                                    <input type="hidden" name="variant_id" value="{{ $variant->id }}">
                                                                                    <a class="add-to-cart" href="#" onclick="event.preventDefault(); this.closest('form').submit();"
                                                                                        data-button-action="add-to-cart" title="Thêm vào giỏ">
                                                                                        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                                                                    </a>
                                                                                </form>
                                                                            @else
                                                                                <a class="add-to-cart" href="{{ route('login') }}" title="Đăng nhập để mua hàng"
                                                                                    onclick="return confirm('Bạn cần đăng nhập để thêm vào giỏ hàng!');">
                                                                                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                                                                </a>
                                                                            @endauth

                                                                            {{-- Wishlist Button --}}
                                                                            @auth
                                                                                <form action="{{ route('client.wishlist.toggle', $product->id) }}" method="POST" class="d-inline">
                                                                                    @csrf
                                                                                    <a class="addToWishlist favorite-btn" href="#" data-rel="{{ $product->id }}"
                                                                                        onclick="event.preventDefault(); this.closest('form').submit();" title="Yêu thích">
                                                                                        <i class="fa{{ auth()->user()->wishlists->contains('product_id', $product->id) ? 's' : '' }} fa-heart {{ auth()->user()->wishlists->contains('product_id', $product->id) ? 'text-danger' : '' }}" 
                                                                                        aria-hidden="true"></i>
                                                                                    </a>
                                                                                </form>
                                                                            @else
                                                                                <a class="addToWishlist" href="{{ route('login') }}" 
                                                                                title="Đăng nhập để yêu thích">
                                                                                    <i class="fa fa-heart" aria-hidden="true"></i>
                                                                                </a>
                                                                            @endauth

                                                                            {{-- Quick View / Xem chi tiết --}}
                                                                            <a href="{{ route('client.products.show', $product->id) }}" 
                                                                            class="quick-view" data-link-action="quickview" title="Xem chi tiết">
                                                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                @push('scripts')
                                                <script>
                                                    document.querySelectorAll('.favorite-btn').forEach(button => {
                                                        button.addEventListener('click', function() {
                                                            const icon = this.querySelector('i');
                                                            icon.classList.toggle('fa-regular');
                                                            icon.classList.toggle('fa-solid');
                                                        });
                                                    });
                                                </script>
                                                @endpush

                                               
                                              
                                               
                                                
                                            </div>
                                        </div>
                                        <div id="list" class="related tab-pane fade">
                                            <div class="row">
                                                <div class="item col-md-12">
                                                    <div class="product-miniature item-one first-item">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="thumbnail-container border">
                                                                    <a href="product-detail.html">
                                                                        <img class="img-fluid image-cover"
                                                                            src="img/product/1.jpg" alt="img">
                                                                        <img class="img-fluid image-secondary"
                                                                            src="img/product/22.jpg" alt="img">
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <div class="product-description">
                                                                    <div class="product-groups">
                                                                        <div class="product-title">
                                                                            <a href="product-detail.html">Nulla et justo
                                                                                non augue</a>
                                                                            <span class="info-stock">
                                                                                <i class="fa fa-check-square-o"
                                                                                    aria-hidden="true"></i>
                                                                                In Stock
                                                                            </span>
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
                                                                                <span class="price">£28.08</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="discription">
                                                                            Lorem ipsum dolor sit amet, consectetur
                                                                            adipiscing elit. Etiam ultricies eget velit
                                                                            vitae bibendum. Cras condimentum libero
                                                                            a lectus ultricies...
                                                                        </div>
                                                                    </div>
                                                                    <div class="product-buttons d-flex">
                                                                        <form action="#" method="post"
                                                                            class="formAddToCart">
                                                                            <a class="add-to-cart" href="#"
                                                                                data-button-action="add-to-cart">
                                                                                <i class="fa fa-shopping-cart"
                                                                                    aria-hidden="true"></i>Add to cart
                                                                            </a>
                                                                        </form>
                                                                        <a class="addToWishlist" href="#" data-rel="1"
                                                                            onclick="">
                                                                            <i class="fa fa-heart"
                                                                                aria-hidden="true"></i>
                                                                        </a>
                                                                        <a href="#" class="quick-view hidden-sm-down"
                                                                            data-link-action="quickview">
                                                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- pagination -->
                                    <div class="pagination">
                                        <div class="js-product-list-top ">
                                            <div class="d-flex justify-content-around row">
                                                <div class="showing col col-xs-12">
                                                    <span>SHOWING 1-3 OF 3 ITEM(S)</span>
                                                </div>
                                                <div class="page-list col col-xs-12">
                                                    <ul>
                                                        <li>
                                                            <a rel="prev" href="#"
                                                                class="previous disabled js-search-link">
                                                                Previous
                                                            </a>
                                                        </li>
                                                        <li class="current active">
                                                            <a rel="nofollow" href="#" class="disabled js-search-link">
                                                                1
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a rel="nofollow" href="#" class="disabled js-search-link">
                                                                2
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a rel="nofollow" href="#" class="disabled js-search-link">
                                                                3
                                                            </a>
                                                        </li>

                                                        <li>
                                                            <a rel="next" href="#" class="next disabled js-search-link">
                                                                Next
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- end col-md-9-1 -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection