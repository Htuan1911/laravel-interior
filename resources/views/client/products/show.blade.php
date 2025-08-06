@extends('layouts.show')

@section('content-dead')

    <style>
        .colors span {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: inline-block;
            margin: 0 4px;
            cursor: pointer;
            border: 2px solid #ccc;
        }

        .blue {
            background-color: blue;
        }

        .red {
            background-color: red;
        }

        .yellow {
            background-color: yellow;
        }

        .green {
            background-color: green;
        }

        .brown {
            background-color: brown;
        }

        .pink {
            background-color: pink;
        }

        .black {
            background-color: black;
        }

        .purple {
            background-color: purple;
        }

        .cream {
            background-color: #ccc
        }

        /* màu đặc biệt có dấu cách */
        .dark-blue {
            background-color: #023b2f;
        }

        .gray {
            background-color: gray;
        }
    </style>

    <div class="main-content">
        <div id="wrapper-site">
            <div id="content-wrapper">
                <div id="main">
                    <div class="page-home">

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
                                                <span>Living Room</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <span>Sofa</span>
                                            </a>
                                        </li>
                                    </ol>
                                </div>
                            </div>
                        </nav>
                        <div class="container">
                            <div class="content">
                                <div class="row">
                                    <div class="sidebar-3 sidebar-collection col-lg-3 col-md-3 col-sm-4">

                                        <!-- category -->
                                        <div class="sidebar-block">
                                            <div class="title-block">Categories</div>
                                            <div class="block-content">
                                                <div class="cateTitle hasSubCategory open level1">
                                                    <span class="arrow collapse-icons collapsed" data-toggle="collapse"
                                                        data-target="#livingroom">
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
                                                        data-target="#diningroom">
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
                                                        data-target="#bedroom">
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
                                                        data-target="#kitchen">
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
                                                <div class="cateTitle hasSubCategory open level1">
                                                    <span class="arrow collapsed collapse-icons" data-toggle="collapse"
                                                        data-target="#bathroom">
                                                        <i class="zmdi zmdi-minus"></i>
                                                        <i class="zmdi zmdi-plus"></i>
                                                    </span>
                                                    <a class="cateItem" href="#">Exterior</a>
                                                    <div class="subCategory collapse" id="bathroom">
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
                                            </div>
                                        </div>


                                        <!-- Newest Products -->
                                        <div class="sidebar-block">
                                            <div class="title-block">
                                                Newest Products
                                            </div>
                                            <div class="product-content tab-content">
                                                @if (isset($newestProducts) && $newestProducts->count())
                                                    <div class="row">
                                                        @foreach ($newestProducts as $item)
                                                            @php
                                                                $translation = $item->translations->first();
                                                                $variant = $item->variants->first();
                                                            @endphp
                                                            <div class="item col-md-12">
                                                                <div class="product-miniature item-one first-item d-flex">
                                                                    <div class="thumbnail-container border"
                                                                        style="width: 100%; aspect-ratio: 5 / 4; overflow: hidden; border-radius: 8px;">
                                                                        <a href="{{ route('client.products.show', $item->id) }}">
                                                                            <img class="img-fluid"
                                                                                src="{{ asset('storage/' . ($variant->image ?? ($item->image ?? 'default.jpg'))) }}"
                                                                                alt="{{ $translation->name ?? 'Product Image' }}"
                                                                                style="width: 100%; height: 100%; object-fit: cover;">
                                                                        </a>
                                                                    </div>

                                                                    <div class="product-description">
                                                                        <div class="product-groups">
                                                                            <div class="product-title">
                                                                                <a
                                                                                    href="{{ route('client.products.show', $item->id) }}">
                                                                                    {{ $translation->name ?? 'Nulla et justo augue' }}
                                                                                </a>
                                                                            </div>
                                                                            <div class="rating">
                                                                                <div class="star-content">
                                                                                    @for ($i = 1; $i <= 5; $i++)
                                                                                        <div class="star"></div>
                                                                                    @endfor
                                                                                </div>
                                                                            </div>
                                                                            <div class="product-group-price">
                                                                                <div class="product-price-and-shipping">
                                                                                    <span class="price">
                                                                                        {{ number_format($variant->price ?? ($item->base_price ?? 0), 0, ',', '.') }}
                                                                                        đ
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="product-buttons d-flex justify-content-center">
                                                                            <form action="{{ route('client.carts.add') }}"
                                                                                method="POST" class="formAddToCart">
                                                                                @csrf
                                                                                <input type="hidden" name="variant_id"
                                                                                    value="{{ $variant->id ?? '' }}">
                                                                                <input type="hidden" name="quantity" value="1">
                                                                                <button type="submit" class="add-to-cart"
                                                                                    data-button-action="add-to-cart">
                                                                                    <i class="fa fa-shopping-cart"
                                                                                        aria-hidden="true"></i>
                                                                                </button>
                                                                            </form>
                                                                            @auth
                                                                                <form
                                                                                    action="{{ route('client.wishlist.toggle', $product->id) }}"
                                                                                    method="POST" class="d-inline">
                                                                                    @csrf
                                                                                    <a class="addToWishlist wishlistProd_{{ $product->id }}"
                                                                                        href="#"
                                                                                        onclick="event.preventDefault(); this.closest('form').submit();"
                                                                                        data-rel="{{ $product->id }}" title="Yêu thích">
                                                                                        <i class="fa fa-heart{{ auth()->user()->wishlists->contains('product_id', $product->id) ? ' text-danger' : '' }}"
                                                                                            aria-hidden="true"></i>
                                                                                    </a>
                                                                                </form>
                                                                            @else
                                                                                <a class="addToWishlist" href="{{ route('login') }}">
                                                                                    <i class="fa-regular fa-heart"
                                                                                        aria-hidden="true"></i>
                                                                                </a>
                                                                            @endauth
                                                                            <a href="{{ route('client.products.show', $item->id) }}"
                                                                                class="quick-view hidden-sm-down"
                                                                                data-link-action="quickview"
                                                                                data-product-id="{{ $item->id }}"
                                                                                onclick="openQuickView(event, this)">
                                                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <div class="row">
                                                        <div class="item col-md-12">
                                                            <p>Không có sản phẩm mới nào.</p>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-sm-8 col-lg-9 col-md-9">
                                        <div class="main-product-detail">
                                            <h2>{{ $product->translations[0]->name }}</h2>
                                            <div class="product-single row">
                                                {{-- Hình ảnh sản phẩm --}}
                                                <div class="product-detail col-xs-12 col-md-5 col-sm-5">
                                                    <div class="page-content" id="content">
                                                        <div class="images-container">
                                                            @php
                                                                $variant = $product->variants->first();
                                                            @endphp
                                                            {{-- Ảnh chính --}}
                                                            <div class="mb-3">
                                                                <img id="main-image"
                                                                    src="{{ asset('storage/' . ($variant->image ?? $product->image)) }}"
                                                                    class="img-fluid rounded w-100"
                                                                    style="object-fit: contain; max-height: 400px;"
                                                                    alt="{{ $product->translations[0]->name }}">
                                                            </div>
                                                            {{-- Ảnh biến thể --}}
                                                            @if ($product->variants->count() > 1)
                                                                <ul class="product-tab nav nav-tabs d-flex">
                                                                    @foreach ($product->variants as $v)
                                                                        @if ($v->image)
                                                                            <li class="col">
                                                                                <a href="javascript:void(0)"
                                                                                    onclick="document.getElementById('main-image').src = '{{ asset('storage/' . $v->image) }}'">
                                                                                    <img src="{{ asset('storage/' . $v->image) }}"
                                                                                        alt="{{ $v->variant_name }}"
                                                                                        style="width: 80px; height: 80px; object-fit: cover; cursor: pointer;">
                                                                                </a>
                                                                            </li>
                                                                        @endif
                                                                    @endforeach
                                                                </ul>
                                                            @endif
                                                            <div class="layer hidden-sm-down" data-toggle="modal"
                                                                data-target="#product-modal">
                                                                <i class="fa fa-expand"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="product-info col-xs-12 col-md-7 col-sm-7">
                                                    <div class="detail-description">
                                                        <div class="price-del">
                                                            <span id="variant-price" class="price text-danger fw-bold">
                                                                {{ number_format($variant->price ?? $product->base_price, 0, ',', '.') }}
                                                                đ
                                                            </span>

                                                            @php
                                                                $sizes = $product->variants
                                                                    ->pluck('size')
                                                                    ->unique()
                                                                    ->filter()
                                                                    ->values();
                                                            @endphp

                                                            <div class="option has-border d-lg-flex size-color">
                                                                <div class="size">
                                                                    <span class="size">Size:</span>
                                                                    <select id="sizeSelect">
                                                                        <option value="">Choose your size</option>
                                                                        @foreach ($sizes as $size)
                                                                            <option value="{{ $size }}">
                                                                                {{ strtoupper($size) }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="colors">
                                                                    <a class="title">Color:</a>
                                                                    @foreach ($product->variants as $v)
                                                                        @if ($v->color)
                                                                            @php
                                                                                $colorClass = strtolower(
                                                                                    preg_replace(
                                                                                        '/\s+/',
                                                                                        '-',
                                                                                        $v->color,
                                                                                    ),
                                                                                );
                                                                            @endphp
                                                                            <span class="{{ $colorClass }}"
                                                                                data-color="{{ $v->color }}"
                                                                                data-size="{{ $v->size }}"
                                                                                data-image="{{ asset('storage/' . $v->image) }}"
                                                                                data-price="{{ $v->price }}"
                                                                                data-variant-id="{{ $v->id }}"
                                                                                onclick="handleSelection(this)"
                                                                                title="{{ $v->color }}"></span>
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                            </div>



                                                            <span class="float-right">
                                                                <span class="availb">Availability: </span>
                                                                <span class="check">
                                                                    <i class="fa fa-check-square-o"
                                                                        aria-hidden="true"></i>IN STOCK
                                                                </span>
                                                            </span>
                                                        </div>

                                                        <p><strong>Vật liệu:</strong>
                                                            {{ $variant->material ?? 'Đang cập nhật' }}</p>
                                                        <p><strong>Kích thước:</strong>
                                                            {{ $variant->size ?? 'Đang cập nhật' }}</p>
                                                        <p><strong>Danh mục:</strong>
                                                            {{ $product->category->translations[0]->name ?? '---' }}</p>

                                                        {{-- Tăng giảm số lượng và nút mua --}}
                                                        <div class="has-border cart-area">
                                                            <div class="product-quantity">
                                                                <div class="qty">
                                                                    <div class="input-group">
                                                                        <div class="quantity">
                                                                            <span class="control-label">QTY : </span>
                                                                            <input type="text" name="qty"
                                                                                id="quantity_wanted" value="1"
                                                                                class="input-group form-control" readonly>
                                                                            <span class="input-group-btn-vertical">
                                                                                <button
                                                                                    class="btn btn-touchspin js-touchspin bootstrap-touchspin-up"
                                                                                    type="button"
                                                                                    onclick="increaseQty()">+</button>
                                                                                <button
                                                                                    class="btn btn-touchspin js-touchspin bootstrap-touchspin-down"
                                                                                    type="button"
                                                                                    onclick="decreaseQty()">−</button>
                                                                            </span>
                                                                        </div>
                                                                        <span class="add">
                                                                            <form action="{{ route('client.carts.add') }}"
                                                                                method="POST" class="d-inline">
                                                                                @csrf
                                                                                <input type="hidden" name="variant_id"
                                                                                    id="variant-id"
                                                                                    value="{{ $variant->id }}">
                                                                                <input type="hidden" name="quantity"
                                                                                    id="add-cart-qty" value="1">
                                                                                <button
                                                                                    class="btn btn-primary add-to-cart add-item"
                                                                                    data-button-action="add-to-cart"
                                                                                    type="submit">
                                                                                    <i class="fa fa-shopping-cart"
                                                                                        aria-hidden="true"></i>
                                                                                    <span>Add to cart</span>
                                                                                </button>
                                                                            </form>
                                                                            @auth
                                                                                <form
                                                                                    action="{{ route('client.wishlist.toggle', $product->id) }}"
                                                                                    method="POST" class="d-inline">
                                                                                    @csrf
                                                                                    <a class="addToWishlist wishlistProd_{{ $product->id }}"
                                                                                        href="#"
                                                                                        onclick="event.preventDefault(); this.closest('form').submit();"
                                                                                        data-rel="{{ $product->id }}"
                                                                                        title="Yêu thích">
                                                                                        <i class="fa fa-heart{{ auth()->user()->wishlists->contains('product_id', $product->id) ? ' text-danger' : '' }}"
                                                                                            aria-hidden="true"></i>
                                                                                    </a>
                                                                                </form>
                                                                            @else
                                                                                <a class="addToWishlist"
                                                                                    href="{{ route('login') }}"
                                                                                    title="Đăng nhập để yêu thích">
                                                                                    <i class="fa fa-heart"
                                                                                        aria-hidden="true"></i>
                                                                                </a>
                                                                            @endauth

                                                                            {{-- Nút So sánh --}}
                                                                            <form
                                                                                action="{{ route('client.compare.add', $product->id) }}"
                                                                                method="POST" class="d-inline">
                                                                                @csrf
                                                                                <button type="submit"
                                                                                    class="btn btn-outline-secondary add-to-compare"
                                                                                    title="So sánh sản phẩm">
                                                                                    <i class="fa fa-balance-scale"
                                                                                        aria-hidden="true"></i>
                                                                                </button>
                                                                            </form>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        {{-- Các nút chia sẻ, gửi email, in ấn --}}
                                                        <div class="d-flex2 has-border">
                                                            <div class="btn-group">
                                                                <a href="#"><i
                                                                        class="zmdi zmdi-share"></i><span>Share</span></a>
                                                                <a href="#" class="email"><i class="fa fa-envelope"
                                                                        aria-hidden="true"></i><span>SEND TO A
                                                                        FRIEND</span></a>
                                                                <a href="#" class="print"><i
                                                                        class="zmdi zmdi-print"></i><span>Print</span></a>
                                                            </div>
                                                        </div>

                                                        {{-- Đánh giá và bình luận --}}
                                                        <div class="rating-comment has-border d-flex">





                                                            <div class="review-description d-flex">
                                                                <span>REVIEW :</span>
                                                                <div class="rating">
                                                                    <div class="star-content">
                                                                  <span>{{ $averageRating }} / 5</span>
                                                                        <div class="star"></div>
                                                                      
                                                                    </div>
                                                                </div>
                                                            </div>


{{--                                                             
                                                            <div class="read after-has-border">
                                                                <a href="#review">
                                                                    <i class="fa fa-commenting-o color"
                                                                        aria-hidden="true"></i>
                                                                        <span>READ REVIEWS
                                                                        (3)</span></a>
                                                            </div>
                                                            <div class="apen after-has-border">
                                                                <a href="#review"><i class="fa fa-pencil color"
                                                                        aria-hidden="true"></i><span>WRITE A
                                                                        REVIEW</span></a>
                                                            </div> --}}
                                                        </div>

                                                        <div class="content">
                                                            <p>SKU: <span class="content2"><a
                                                                        href="#">{{ $product->sku ?? 'e-02154' }}</a></span>
                                                            </p>
                                                            <p>Categories: <span class="content2"><a
                                                                        href="#">{{ $product->category->translations[0]->name ?? 'Clothing' }}</a></span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Tab nội dung --}}
                                            <div class="review">
                                                <ul class="nav nav-tabs">
                                                    <li class="active"><a data-toggle="tab" href="#description"
                                                            class="active show">Description</a></li>
                                                    <li><a data-toggle="tab" href="#tag">Product Tags</a></li>
                                                    <li>
                                                        <a data-toggle="tab" href="#review">Reviews ({{ $reviewCount }})</a>
                                                    </li>
                                                </ul>
                                                <div class="tab-content">
                                                    <div id="description" class="tab-pane fade in active show">
                                                        <div id="short-description" class="d-block">
                                                            {!! nl2br(Str::limit($product->translations[0]->description ?? 'Chưa có mô tả', 300)) !!}
                                                            @if (strlen($product->translations[0]->description ?? '') > 300)
                                                                <span id="dots">...</span>
                                                                <span id="more" style="display: none;">
                                                                    {!! nl2br(substr($product->translations[0]->description, 300)) !!}
                                                                </span>
                                                                <br>
                                                                <a href="javascript:void(0)" id="toggle-description"
                                                                    class="btn btn-link p-0">Xem thêm</a>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div id="tag" class="tab-pane fade">
                                                        <p>
                                                            @foreach ($product->tags ?? ['Jacket', 'Overcoat', 'Luxury', 'men', 'summer', 'autumn'] as $tag)
                                                                <a href="#">{{ $tag }}</a>,
                                                            @endforeach
                                                        </p>
                                                    </div>
                                                    
                                                    
                                               
                                                    <div id="review" class="tab-pane fade">
                                                        <div class="tab-pane fade show active" id="reviews">
    <h5>Đánh giá sản phẩm</h5>

    @php
        $allReviews = collect();

        foreach ($product->variants as $variant) {
            $allReviews = $allReviews->merge($variant->reviews);
        }
    @endphp

    @if ($allReviews->isEmpty())
        <p>Chưa có đánh giá nào cho sản phẩm này.</p>
    @else
        @foreach ($allReviews as $review)
     <div class="border p-3 mb-3 rounded">
    <strong>{{ $review->user->name ?? 'Người dùng' }}</strong>

    {{-- ⭐ Hiển thị số sao --}}
    <div class="text-warning">
        @for ($i = 1; $i <= 5; $i++)
            @if ($i <= $review->rating)
                <i class="bi bi-star-fill"></i>
            @else
                <i class="bi bi-star"></i>
            @endif
        @endfor
    </div>

    {{-- 💬 Hiển thị bình luận --}}
    <p class="mt-2">{{ $review->comment }}</p>
</div>
        @endforeach
    @endif
</div>

                                                    </div>
                                                  
                                                </div>
                                            </div>

                                            {{-- Sản phẩm liên quan --}}
                                            @if ($relatedProducts->count())
                                                <div class="related">
                                                    <div class="title-tab-content text-center">
                                                        <div class="title-product justify-content-start">
                                                            <h2>Sản phẩm cùng danh mục</h2>
                                                        </div>
                                                    </div>
                                                    <div class="tab-content">
                                                        <div class="row">
                                                            @foreach ($relatedProducts as $item)
                                                                @php
                                                                    $translation = $item->translations->first();
                                                                    $variant = $item->variants->first();
                                                                @endphp
                                                                <div class="item text-center col-md-4">
                                                                    <div
                                                                        class="product-miniature js-product-miniature item-one first-item">
                                                                        <div class="thumbnail-container border">
                                                                            <a
                                                                                href="{{ route('client.products.show', $item->id) }}">
                                                                                <img class="img-fluid image-cover"
                                                                                    src="{{ asset('storage/' . $item->image) }}"
                                                                                    alt="{{ $translation->name }}"
                                                                                    style="height: 180px; object-fit: cover;">
                                                                                @if ($variant && $variant->image)
                                                                                    <img class="img-fluid image-secondary"
                                                                                        src="{{ asset('storage/' . $variant->image) }}"
                                                                                        alt="{{ $translation->name }}">
                                                                                @endif
                                                                            </a>
                                                                        </div>
                                                                        <div class="product-description">
                                                                            <div class="product-groups">
                                                                                <div class="product-title">
                                                                                    <a
                                                                                        href="{{ route('client.products.show', $item->id) }}">{{ $translation->name }}</a>
                                                                                </div>
                                                                                <div class="rating">
                                                                                    <div class="star-content">
                                                                                        @for ($i = 1; $i <= 5; $i++)
                                                                                            <div class="star"></div>
                                                                                        @endfor
                                                                                    </div>
                                                                                </div>
                                                                                <div class="product-group-price">
                                                                                    <div class="product-price-and-shipping">
                                                                                        <span
                                                                                            class="price">{{ number_format($variant->price ?? $item->base_price, 0, ',', '.') }}
                                                                                            đ</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div
                                                                                class="product-buttons d-flex justify-content-center">
                                                                                {{-- Nút Thêm vào giỏ hàng --}}
                                                                                <form action="{{ route('client.carts.add') }}"
                                                                                    method="POST" class="formAddToCart">
                                                                                    @csrf
                                                                                    <input type="hidden" name="variant_id"
                                                                                        value="{{ $variant->id ?? '' }}">
                                                                                    <input type="hidden" name="quantity" value="1">
                                                                                    <button type="submit" class="add-to-cart"
                                                                                        data-button-action="add-to-cart">
                                                                                        <i class="fa fa-shopping-cart"
                                                                                            aria-hidden="true"></i>
                                                                                    </button>
                                                                                </form>
                                                                                {{-- Nút Yêu thích --}}
                                                                                @auth
                                                                                    <form
                                                                                        action="{{ route('client.wishlist.toggle', $product->id) }}"
                                                                                        method="POST" class="d-inline">
                                                                                        @csrf
                                                                                        <a class="addToWishlist wishlistProd_{{ $product->id }}"
                                                                                            href="#"
                                                                                            onclick="event.preventDefault(); this.closest('form').submit();"
                                                                                            data-rel="{{ $product->id }}"
                                                                                            title="Yêu thích">
                                                                                            <i class="fa fa-heart{{ auth()->user()->wishlists->contains('product_id', $product->id) ? ' text-danger' : '' }}"
                                                                                                aria-hidden="true"></i>
                                                                                        </a>
                                                                                    </form>
                                                                                @else
                                                                                    <a class="addToWishlist"
                                                                                        href="{{ route('login') }}">
                                                                                        <i class="fa-regular fa-heart"
                                                                                            aria-hidden="true"></i>
                                                                                    </a>
                                                                                @endauth
                                                                                {{-- Nút Xem nhanh --}}
                                                                                <a href="{{ route('client.products.show', $item->id) }}"
                                                                                    class="quick-view hidden-sm-down"
                                                                                    data-link-action="quickview"
                                                                                    data-product-id="{{ $item->id }}"
                                                                                    onclick="openQuickView(event, this)">
                                                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>



                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- Script Xem thêm / Thu gọn và Tăng giảm số lượng --}}
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const btn = document.getElementById('toggle-description');
            const shortDesc = document.getElementById('short-description');
            const fullDesc = document.getElementById('full-description');
            let expanded = false;

            btn.addEventListener('click', function () {
                expanded = !expanded;
                if (expanded) {
                    shortDesc.style.display = 'none';
                    fullDesc.style.display = 'block';
                    btn.textContent = 'Thu gọn';
                } else {
                    shortDesc.style.display = 'block';
                    fullDesc.style.display = 'none';
                    btn.textContent = 'Xem thêm';
                }
            });
        });

        let quantity = 1;

        function increaseQty() {
            quantity++;
            updateQtyDisplay();
        }

        function decreaseQty() {
            quantity = Math.max(1, quantity - 1);
            updateQtyDisplay();
        }

        function updateQtyDisplay() {
            document.getElementById('quantity_wanted').value = quantity;
            document.getElementById('add-cart-qty').value = quantity;
            // Nếu bạn thêm nút "Mua ngay" với id="buy-now-qty", hãy thêm dòng sau:
            // document.getElementById('buy-now-qty').value = quantity;
        }

        document.addEventListener('DOMContentLoaded', () => {
            updateQtyDisplay();
        });


        document.addEventListener('DOMContentLoaded', function () {
            const btn = document.getElementById('toggle-description');
            const dots = document.getElementById('dots');
            const moreText = document.getElementById('more');

            if (btn) {
                btn.addEventListener('click', function () {
                    if (moreText.style.display === "none") {
                        moreText.style.display = "inline";
                        dots.style.display = "none";
                        btn.textContent = "Thu gọn";
                    } else {
                        moreText.style.display = "none";
                        dots.style.display = "inline";
                        btn.textContent = "Xem thêm";
                    }
                });
            }
        });

        let selectedColor = null;
        let selectedSize = null;

        // Khi chọn màu
        function handleSelection(el) {
            selectedColor = el.getAttribute('data-color');

            // Tô viền
            document.querySelectorAll('.colors span').forEach(span => span.classList.remove('active'));
            el.classList.add('active');

            updateVariant();
        }

        // Khi chọn size
        document.getElementById('sizeSelect').addEventListener('change', function () {
            selectedSize = this.value;
            updateVariant();
        });

        // Hàm tìm variant phù hợp và cập nhật giao diện
        function updateVariant() {
            const allVariants = document.querySelectorAll('.colors span');

            let matchedVariant = null;

            allVariants.forEach(v => {
                const color = v.getAttribute('data-color');
                const size = v.getAttribute('data-size');

                if (color === selectedColor && size === selectedSize) {
                    matchedVariant = v;
                }
            });

            if (matchedVariant) {
                const price = matchedVariant.getAttribute('data-price');
                const image = matchedVariant.getAttribute('data-image');
                const variantId = matchedVariant.getAttribute('data-variant-id');

                // Cập nhật ảnh
                document.getElementById('main-image').src = image;

                // Cập nhật giá
                document.getElementById('variant-price').innerText = parseInt(price).toLocaleString('vi-VN') + ' đ';

                // Cập nhật variant_id hidden
                const input = document.getElementById('variant-id');
                if (input) input.value = variantId;

            }
        }
    </script>
@endpush