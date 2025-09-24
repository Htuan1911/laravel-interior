<header>
    <!-- header left mobie -->
    <div class="header-mobile d-md-none">
        <div class="mobile hidden-md-up text-xs-center d-flex align-items-center justify-content-around">

            <!-- menu left -->
            <div id="mobile_mainmenu" class="item-mobile-top">
                <i class="fa fa-bars" aria-hidden="true"></i>
            </div>

            <!-- logo -->
            <div class="mobile-logo">
                <a href="{{ url('/client') }}">
                    <img class="logo-mobile img-fluid" src="/img/home/logo-mobie.png" alt="Prestashop_Furnitica">
                </a>
            </div>

            <!-- menu right -->
            <div class="mobile-menutop" data-target="#mobile-pagemenu">
                <i class="zmdi zmdi-more"></i>
            </div>
        </div>

        <!-- search -->
        <div id="mobile_search" class="d-flex">
            {{-- <div id="mobile_search_content">
                <form method="get" action="#">
                    <input type="text" name="s" value="" placeholder="Search">
                    <button type="submit">
                        <i class="fa fa-search"></i>
                    </button>
                </form>
            </div> --}}
            <form method="GET" action="{{ route('client.products.index') }}">
                <input type="text" name="keyword" placeholder="Tìm kiếm sản phẩm..."
                    value="{{ request('keyword') }}" />
                <button type="submit">Tìm kiếm</button>
            </form>

            <div class="desktop_cart">
                <div class="blockcart block-cart cart-preview tiva-toggle">
                    <div class="header-cart tiva-toggle-btn">
                        <span class="cart-products-count">1</span>
                        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                    </div>
                    <div class="dropdown-content">
                        <div class="cart-content">
                            <table>
                                <tbody>
                                    <tr>
                                        <td class="product-image">
                                            <a href="product-detail.html">
                                                <img src="/img/product/5.jpg" alt="Product">
                                            </a>
                                        </td>
                                        <td>
                                            <div class="product-name">
                                                <a href="product-detail.html">Organic Strawberry Fruits</a>
                                            </div>
                                            <div>
                                                2 x
                                                <span class="product-price">£28.98</span>
                                            </div>
                                        </td>
                                        <td class="action">
                                            <a class="remove" href="#">
                                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr class="total">
                                        <td colspan="2">Total:</td>
                                        <td>£92.96</td>
                                    </tr>

                                    <tr>
                                        <td colspan="3" class="d-flex justify-content-center">
                                            <div class="cart-button">
                                                <a href="{{ route('client.carts.index') }}" title="View Cart">View
                                                    Cart</a>
                                                <a href="#" title="Checkout">Checkout</a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- header desktop -->
    <div class="header-top d-xs-none ">
        <div class="container">
            <div class="row">
                <!-- logo -->
                <div class="col-sm-2 col-md-2 d-flex align-items-center">
                    <div id="logo">
                        <a href="{{ url('/client') }}">
                            <img class="img-fluid" src="/img/home/logo2.png              " alt="logo">
                        </a>
                    </div>
                </div>

                <!-- menu -->
                <div class="main-menu col-sm-4 col-md-5 align-items-center justify-content-center navbar-expand-md">
                    <div class="menu navbar collapse navbar-collapse">
                        <ul class="menu-top navbar-nav">
                            <li class="nav-link">
                                <a href="{{ url('/client') }}" class="parent">Trang Chủ</a>

                            </li>
                            <li>
                                <a href="{{ route('client.blog.index') }}" class="parent">Bài Viết</a>

                            </li>
                            <li>
                                <a href="{{ route('client.products.index') }}" class="parent">Sản Phẩm</a>

                            </li>
                            <li>
                                <a href="{{ route('client.contact.form') }}" class="parent">Liên Hệ</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- search-->
                <div id="search_widget" class="col-sm-6 col-md-5 align-items-center justify-content-end d-flex">
                    <form method="get" action="#">
                        <input type="text" name="s" value="" placeholder="Tìm kiếm ..."
                            class="ui-autocomplete-input" autocomplete="off">
                        <button type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </form>

                    <!-- acount  -->
                    <div id="block_myaccount_infos" class="hidden-sm-down dropdown">
                        @auth
                            <div class="myaccount-title">

                                <a href="#acount" data-toggle="collapse" class="acount d-flex align-items-center">
                                    {{-- Avatar --}}
                                    @if (auth()->user()->avatar)
                                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="avatar"
                                            class="rounded-circle mr-2"
                                            style="width: 25px; height: 25px; object-fit: cover;">
                                    @else
                                        <img src="https://via.placeholder.com/32" alt="avatar" class="rounded-circle mr-2"
                                            style="width: 25px; height: 25px; object-fit: cover;">
                                    @endif

                                    {{-- Tên --}}
                                    <span>{{ auth()->user()->name }}</span>
                                    <i class="fa fa-angle-down ml-1" aria-hidden="true"></i>
                                </a>
                            </div>
                        @else
                            <div class="myaccount-title">
                                <a href="{{ route('login') }}" class="acount">
                                    <i class="fa fa-user" aria-hidden="true"></i>

                                    <i class="fa fa-angle-down" aria-hidden="true"></i>
                                </a>
                            </div>
                        @endauth


                        <div id="acount" class="collapse">
                            <div class="account-list-content">
                                <div>
                                    <a class="login" href="{{ route('client.account.info') }}" rel="nofollow"
                                        title="Log in to your customer account">
                                        <i class="fa fa-cog"></i>
                                        <span>Tài khoản</span>
                                    </a>
                                </div>
                                @guest
                                    <div>
                                        <a class="login" href="{{ route('login') }}" rel="nofollow"
                                            title="Log in to your customer account">
                                            <i class="fa fa-sign-in"></i>
                                            <span>Đăng nhâp</span>
                                        </a>
                                    </div>
                                    <div>
                                        <a class="register" href="{{ route('register') }}" rel="nofollow"
                                            title="Register Account">
                                            <i class="fa fa-user"></i>
                                            <span>Đăng kí</span>
                                        </a>
                                    </div>
                                @endguest
                                <div>
                                    <a class="check-out" href="{{ route('client.account.orders') }}" rel="nofollow"
                                        title="Checkout">
                                        <i class="fa fa-check" aria-hidden="true"></i>
                                        <span>Lịch sử đơn hàng</span>
                                    </a>
                                </div>
                                {{-- <div>
                                    <a href="{{ route('client.account.vouchers') }}" title=" vouchers">
                                        <i class="fa fa-ticket"></i>
                                        <span>Vouchers</span>
                                    </a>
                                </div> --}}
                                <div>
                                    <a href="{{ route('client.account.wishlist') }}" title="My Wishlists">
                                        <i class="fa fa-heart"></i>
                                        <span>Yêu thích</span>
                                    </a>
                                </div>
                                <div>
                                    <a href="{{ route('client.compare.index') }}" title="Comparison">
                                        <i class="fa fa-exchange"></i>
                                        <span>so sánh</span>
                                    </a>
                                </div>
                                <div>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>

                                    <a class="logout" href="#" rel="nofollow"
                                        title="Log out from your account"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fa fa-sign-out"></i>
                                        <span>Đăng xuất</span>
                                    </a>
                                </div>



                            </div>
                        </div>
                    </div>
                    <div class="desktop_cart">
                        <div class="blockcart block-cart cart-preview tiva-toggle">
                            <div class="header-cart tiva-toggle-btn">
                                <span class="cart-products-count">
                                    {{ isset($cart) && $cart->items ? $cart->items->count() : 0 }}
                                </span>
                                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                            </div>
                            <div class="dropdown-content">
                                <div class="cart-content">
                                    <table>
                                        <tbody>
                                            @php $total = 0; @endphp

                                            @if (isset($cart) && $cart->items && $cart->items->count())
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
                                                        $image = $variant->image ?? ($product->image ?? 'default.jpg');
                                                        $price = $variant->price ?? 0;
                                                        $subtotal = $price * $item->quantity;
                                                        $total += $subtotal;
                                                    @endphp
                                                    <tr>
                                                        <td class="product-image">
                                                            <a
                                                                href="{{ route('client.products.show', $product->id ?? 0) }}">
                                                                <img src="{{ asset('storage/' . $image) }}"
                                                                    alt="{{ $productName }}"
                                                                    style="width: 60px; height: 60px; object-fit: cover;">
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <div class="product-name">
                                                                <a
                                                                    href="{{ route('client.products.show', $product->id ?? 0) }}">
                                                                    {{ $productName }}
                                                                </a>
                                                            </div>
                                                            <div>
                                                                {{ $item->quantity }} x
                                                                <span class="product-price">
                                                                    {{ number_format($price, 0, ',', '.') }} đ
                                                                </span>
                                                            </div>
                                                        </td>
                                                        <td class="action">
                                                            <form
                                                                action="{{ route('client.carts.remove', $item->id) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Bạn có chắc muốn xoá sản phẩm này không?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="remove btn btn-link p-0"
                                                                    style="color: #dc3545;">
                                                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach

                                                <tr class="total">
                                                    <td colspan="2">Tổng cộng:</td>
                                                    <td>{{ number_format($total, 0, ',', '.') }} đ</td>
                                                </tr>

                                                <tr>
                                                    <td colspan="3" class="d-flex justify-content-center">
                                                        <div class="cart-button">
                                                            <a href="{{ route('client.carts.index') }}"
                                                                title="View Cart">Xem giỏ hàng</a>
                                                            <a href="{{ route('client.carts.index') }}"
                                                                title="Checkout">Thanh toán</a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @else
                                                <tr>
                                                    <td colspan="3" class="text-center">Giỏ hàng trống.</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>


                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
