@extends('layouts.client')

@section('contentproduct')
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

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
                                            <div class="title-block">Danh mục</div>
                                            <div class="block-content">
                                                @foreach ($categories as $category)
                                                    @php
                                                        $translatedName =
                                                            $category->translations->first()->name ?? 'Danh mục';
                                                        $active = request('category_id') == $category->id;
                                                        $hasChildren =
                                                            $category->children && $category->children->count() > 0;
                                                    @endphp

                                                    <div
                                                        class="cateTitle hasSubCategory level1 {{ $active ? 'open' : '' }}">
                                                        @if ($hasChildren)
                                                            <span
                                                                class="arrow collapse-icons {{ $active ? '' : 'collapsed' }}"
                                                                data-toggle="collapse"
                                                                data-target="#category{{ $category->id }}"
                                                                aria-expanded="{{ $active ? 'true' : 'false' }}"
                                                                role="status">
                                                                <i class="zmdi zmdi-minus"></i>
                                                                <i class="zmdi zmdi-plus"></i>
                                                            </span>
                                                        @endif

                                                        <a class="cateItem {{ $active ? 'active' : '' }}"
                                                            href="{{ route('client.products.index', ['category_id' => $category->id]) }}">
                                                            {{ $translatedName }}
                                                        </a>

                                                        @if ($hasChildren)
                                                            <div class="subCategory collapse {{ $active ? 'show' : '' }}"
                                                                id="category{{ $category->id }}"
                                                                aria-expanded="{{ $active ? 'true' : 'false' }}"
                                                                role="status">
                                                                @foreach ($category->children as $child)
                                                                    <div class="cateTitle">
                                                                        <a href="{{ route('client.products.index', ['category_id' => $child->id]) }}"
                                                                            class="cateItem">
                                                                            {{ $child->translations->first()->name ?? 'Danh mục con' }}
                                                                        </a>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>




                                        <!-- best seller -->
                                        <div class="sidebar-block">
                                            <!-- Bộ lọc theo Kích thước -->
                                            <div class="new-item-content">
                                                <h3 class="title-product">Kích thước</h3>
                                                <ul class="scroll-product">
                                                    @php
                                                        $selectedSizes = request()->input('size');
                                                        if (!is_array($selectedSizes)) {
                                                            $selectedSizes = [$selectedSizes]; // ép thành mảng nếu là string
                                                        }
                                                    @endphp

                                                    @foreach ($sizes as $size)
                                                        <li>
                                                            <label class="check">
                                                                <input type="checkbox" name="size[]"
                                                                    value="{{ $size }}"
                                                                    onchange="window.location.href='{{ request()->fullUrlWithQuery(['size' => $size]) }}'"
                                                                    {{ in_array($size, $selectedSizes) ? 'checked' : '' }}>
                                                                <span class="checkmark"></span>
                                                            </label>
                                                            <a href="{{ request()->fullUrlWithQuery(['size' => $size]) }}">
                                                                <b>{{ $size }}</b>
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>


                                            <!-- Bộ lọc theo Chất liệu -->
                                            {{-- <div class="new-item-content">
                                                <h3 class="title-product">By Material</h3>
                                                <ul class="scroll-product">
                                                    @foreach ($materials as $material)
                                                        <li>
                                                            <label class="check">
                                                                <input type="checkbox" name="material[]"
                                                                    value="{{ $material }}"
                                                                    {{ collect(request()->input('material'))->contains($material) ? 'checked' : '' }}>
                                                                <span class="checkmark"></span>
                                                            </label>
                                                            <a href="{{ request()->fullUrlWithQuery(['material' => $material]) }}"
                                                                class="material-link">
                                                                <b>{{ ucfirst($material) }}</b>
                                                                <span class="quantity">
                                                                    ({{ $allProducts->filter(function ($product) use ($material) {
                                                                            return $product->variants->contains('material', $material);
                                                                        })->count() }})
                                                                </span>
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div> --}}






                                            {{-- PRICE FILTER --}}
                                            <form method="GET" action="{{ route('client.products.index') }}"
                                                class="mb-4">
                                                <h6 class="border-bottom pb-2 fw-bold text-uppercase">Giá</h6>
                                                <div class="row g-2 mb-2">
                                                    <div class="col-6">
                                                        <input type="number" name="price_min" class="form-control"
                                                            placeholder="Từ" value="{{ request('price_min') }}">
                                                    </div>
                                                    <div class="col-6">
                                                        <input type="number" name="price_max" class="form-control"
                                                            placeholder="Đến" value="{{ request('price_max') }}">
                                                    </div>
                                                </div>

                                                <button type="submit" class="btn btn-outline-primary btn-sm w-100">
                                                    <i class="bi bi-funnel-fill"></i> Lọc theo giá
                                                </button>
                                            </form>





                                            <!-- Bộ lọc theo Màu sắc -->
                                            {{-- <div class="sidebar-block by-color">
                                                <h3 class="title-product">By Color</h3>
                                                <div>
                                                    @foreach ($colors as $color)
                                                        <span class="left"
                                                            style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
                                                            <label class="color-item1"
                                                                style="background-color: {{ strtolower($color) }}; width: 20px; height: 20px; display: inline-block; border: 1px solid #ccc; border-radius: 50%;"></label>
                                                            <a
                                                                href="{{ request()->fullUrlWithQuery(['color' => $color]) }}">
                                                                <span>
                                                                    {{ ucfirst($color) }}
                                                                    ({{ $allProducts->filter(function ($product) use ($color) {
                                                                            return $product->variants->contains('color', $color);
                                                                        })->count() }})
                                                                </span>
                                                            </a>
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </div> --}}
                                        </div>

                                        <!-- product tag -->

                                    </div>
                                    <div class="col-sm-8 col-lg-9 col-md-8 product-container">
                                        <h1>Tất cả sản phẩm</h1>
                                        <div class="js-product-list-top firt nav-top">
                                            <div class="d-flex justify-content-around row">
                                                <div class="col col-xs-12">
                                                    <ul class="nav nav-tabs">
                                                        <li>
                                                            <a href="#grid" data-toggle="tab"
                                                                class="active show fa fa-th-large"></a>
                                                        </li>
                                                        
                                                    </ul>
                                                    <div class="hidden-sm-down total-products">
                                                        <p>Có {{ $products->count() }} sản phẩm trong trang này.</p>
                                                    </div>



                                                </div>
                                                <div class="col col-xs-12">
                                                    <div
                                                        class="d-flex sort-by-row justify-content-lg-end justify-content-md-end">

                                                        <div class="products-sort-order dropdown">
                                                            <form method="GET" id="sortForm">
                                                                <select class="select-title" name="sort"
                                                                    onchange="document.getElementById('sortForm').submit();">
                                                                    <option value="">Sort by</option>
                                                                    <option value="name_asc"
                                                                        {{ request('sort') == 'name_asc' ? 'selected' : '' }}>
                                                                        Name, A to Z</option>
                                                                    <option value="name_desc"
                                                                        {{ request('sort') == 'name_desc' ? 'selected' : '' }}>
                                                                        Name, Z to A</option>
                                                                    <option value="price_asc"
                                                                        {{ request('sort') == 'price_asc' ? 'selected' : '' }}>
                                                                        Price, low to high</option>
                                                                    <option value="price_desc"
                                                                        {{ request('sort') == 'price_desc' ? 'selected' : '' }}>
                                                                        Price, high to low</option>
                                                                </select>
                                                            </form>
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
                                                                    if (
                                                                        $variant &&
                                                                        $variant->price > 0 &&
                                                                        $product->base_price > 0
                                                                    ) {
                                                                        $discountPercent = round(
                                                                            (($product->base_price - $variant->price) /
                                                                                $product->base_price) *
                                                                                100,
                                                                        );
                                                                    }
                                                                @endphp

                                                                <div class="item text-center col-md-4">
                                                                    <div
                                                                        class="product-miniature js-product-miniature item-one first-item">
                                                                        <div
                                                                            class="thumbnail-container border position-relative">
                                                                            {{-- Badge giảm giá --}}
                                                                            @if ($discountPercent)
                                                                                <div class="badge-sale position-absolute"
                                                                                    style="top: 10px; left: 10px; background: #dc3545; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; font-weight: bold; z-index: 2;">
                                                                                    -{{ $discountPercent }}%
                                                                                </div>
                                                                            @endif

                                                                            <a
                                                                                href="{{ route('client.products.show', $product->id) }}">
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
                                                                                    <a href="#" class="color beige"
                                                                                        title="Beige"></a>
                                                                                    <a href="#" class="color orange"
                                                                                        title="Orange"></a>
                                                                                    <a href="#" class="color green"
                                                                                        title="Green"></a>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="product-description">
                                                                            <div class="product-groups">
                                                                                <div class="product-title">
                                                                                    <a
                                                                                        href="{{ route('client.products.show', $product->id) }}">
                                                                                        {{ $translation->name }}
                                                                                    </a>
                                                                                </div>

                                                                                {{-- Rating - có thể customize dựa trên dữ liệu
                                                                        thực --}}
                                                                                {{-- <div class="rating">
                                                                                    <div class="star-content">
                                                                                        @for ($i = 1; $i <= 5; $i++)
                                                                                            <div class="star">
                                                                                            </div>
                                                                                        @endfor
                                                                                    </div>
                                                                                </div> --}}

                                                                                <div class="product-group-price">
                                                                                    <div
                                                                                        class="product-price-and-shipping">
                                                                                        @if ($discountPercent)
                                                                                            <span
                                                                                                class="price">{{ number_format($variant->price, 0, ',', '.') }}
                                                                                                đ</span>
                                                                                            <span
                                                                                                class="regular-price text-decoration-line-through text-muted ms-2"
                                                                                                style="font-size: 0.9em;">
                                                                                                {{ number_format($product->base_price, 0, ',', '.') }}
                                                                                                đ
                                                                                            </span>
                                                                                        @else
                                                                                            <span class="price">
                                                                                                {{ number_format($variant->price ?? $product->base_price, 0, ',', '.') }}
                                                                                                đ
                                                                                            </span>
                                                                                        @endif
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div
                                                                                class="product-buttons d-flex justify-content-center">
                                                                                {{-- Add to Cart Button --}}
                                                                                <form
                                                                                    action="{{ route('client.carts.add') }}"
                                                                                    method="POST" class="formAddToCart">
                                                                                    @csrf
                                                                                    <input type="hidden"
                                                                                        name="variant_id"
                                                                                        value="{{ $variant->id ?? '' }}">
                                                                                    <input type="hidden" name="quantity"
                                                                                        value="1">
                                                                                    <button type="submit"
                                                                                        class="add-to-cart"
                                                                                        data-button-action="add-to-cart">
                                                                                        <i class="fa fa-shopping-cart"
                                                                                            aria-hidden="true"></i>
                                                                                    </button>
                                                                                </form>

                                                                                {{-- Wishlist Button --}}

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

                                                                                {{-- Quick View / Xem chi tiết --}}
                                                                                <a href="{{ route('client.products.show', $product->id) }}"
                                                                                    class="quick-view"
                                                                                    data-link-action="quickview"
                                                                                    title="Xem chi tiết">
                                                                                    <i class="fa fa-eye"
                                                                                        aria-hidden="true"></i>
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
                                                                                <a href="product-detail.html">Nulla et
                                                                                    justo
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
                                                                            <a class="addToWishlist" href="#"
                                                                                data-rel="1" onclick="">
                                                                                <i class="fa fa-heart"
                                                                                    aria-hidden="true"></i>
                                                                            </a>
                                                                            <a href="#"
                                                                                class="quick-view hidden-sm-down"
                                                                                data-link-action="quickview">
                                                                                <i class="fa fa-eye"
                                                                                    aria-hidden="true"></i>
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
                                            <div class="js-product-list-top">
                                                <div class="d-flex justify-content-around row">

                                                    <div class="showing col col-xs-12">
                                                        <span>
                                                            Có {{ $products->lastPage() }} trang
                                                        </span>
                                                    </div>


                                                    <!-- Hiển thị các trang -->
                                                    <div class="page-list col col-xs-12">
                                                        <ul>
                                                            {{-- Nút Previous --}}
                                                            <li>
                                                                <a href="{{ $products->previousPageUrl() ?? '#' }}"
                                                                    class="previous js-search-link {{ $products->onFirstPage() ? 'disabled' : '' }}">
                                                                    Quay Lại
                                                                </a>
                                                            </li>

                                                            {{-- Các trang --}}
                                                            @for ($i = 1; $i <= $products->lastPage(); $i++)
                                                                <li
                                                                    class="{{ $i == $products->currentPage() ? 'current active' : '' }}">
                                                                    <a href="{{ $products->url($i) }}"
                                                                        class="js-search-link">
                                                                        {{ $i }}
                                                                    </a>
                                                                </li>
                                                            @endfor

                                                            {{-- Nút Next --}}
                                                            <li>
                                                                <a href="{{ $products->nextPageUrl() ?? '#' }}"
                                                                    class="next js-search-link {{ $products->hasMorePages() ? '' : 'disabled' }}">
                                                                    Tiếp
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
