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
                    <img class="logo-mobile img-fluid" src="img/home/logo-mobie.png" alt="Prestashop_Furnitica">
                </a>
            </div>

            <!-- menu right -->
            <div class="mobile-menutop" data-target="#mobile-pagemenu">
                <i class="zmdi zmdi-more"></i>
            </div>
        </div>

        <!-- search -->
        <div id="mobile_search" class="d-flex">
            <div id="mobile_search_content">
                <form method="get" action="#">
                    <input type="text" name="s" value="" placeholder="Search">
                    <button type="submit">
                        <i class="fa fa-search"></i>
                    </button>
                </form>
            </div>
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
                                                <img src="img/product/5.jpg" alt="Product">
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
                            <img class="img-fluid" src="img/home/logo.png" alt="logo">
                        </a>
                    </div>
                </div>

                <!-- menu -->
                <div class="main-menu col-sm-4 col-md-5 align-items-center justify-content-center navbar-expand-md">
                    <div class="menu navbar collapse navbar-collapse">
                        <ul class="menu-top navbar-nav">
                            <li class="nav-link">
                                <a href="{{ url('/client') }}" class="parent">Home</a>

                            </li>
                            <li>
                                <a href="{{ route('client.blog.index') }}" class="parent">Blog</a>

                            </li>
                            <li>
                                <a href="#" class="parent">Page</a>
                                <div class="dropdown-menu drop-tab">
                                    <ul>
                                        <li class="item container group">
                                            <div class="dropdown-menu dropdown-tab">
                                                <ul>
                                                    <li class="item col-md-4 float-left">
                                                        <span class="menu-title">Category Style</span>
                                                        <div class="menu-content">
                                                            <ul class="col">
                                                                <li>
                                                                    <a href="{{ route('client.products.index') }}">Product
                                                                        Grid </a>
                                                                </li>

                                                            </ul>
                                                        </div>
                                                    </li>
                                                    <li class="item col-md-4 html  float-left">
                                                        <span class="menu-title">Bonus Page</span>
                                                        <div class="menu-content">
                                                            <ul>
                                                                <li>
                                                                    <a href="404.html">404 Page</a>
                                                                </li>
                                                                <li>
                                                                    <a href="about-us.html">About Us Page</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <a href="{{ route('client.contact.form') }}" class="parent">Contact US</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- search-->
                <div id="search_widget" class="col-sm-6 col-md-5 align-items-center justify-content-end d-flex">
                    <form method="get" action="#">
                        <input type="text" name="s" value="" placeholder="Search ..."
                            class="ui-autocomplete-input" autocomplete="off">
                        <button type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </form>

                    <!-- acount  -->
                    <div id="block_myaccount_infos" class="hidden-sm-down dropdown">
                        @auth
                            <div class="myaccount-title">
                                <a href="#acount" data-toggle="collapse" class="acount">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                    <span>{{ auth()->user()->name }}</span>
                                    <i class="fa fa-angle-down" aria-hidden="true"></i>
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
                                        <span>My Account</span>
                                    </a>
                                </div>
                                @guest
                                    <div>
                                        <a class="login" href="{{ route('login') }}" rel="nofollow"
                                            title="Log in to your customer account">
                                            <i class="fa fa-sign-in"></i>
                                            <span>Sign in</span>
                                        </a>
                                    </div>
                                    <div>
                                        <a class="register" href="{{ route('register') }}" rel="nofollow"
                                            title="Register Account">
                                            <i class="fa fa-user"></i>
                                            <span>Register Account</span>
                                        </a>
                                    </div>
                                @endguest
                                <div>
                                    <a class="check-out" href="product-checkout.html" rel="nofollow"
                                        title="Checkout">
                                        <i class="fa fa-check" aria-hidden="true"></i>
                                        <span>Checkout</span>
                                    </a>
                                </div>
                                <div>
                                    <a href="{{ route('client.account.wishlist') }}" title="My Wishlists">
                                        <i class="fa fa-heart"></i>
                                        <span>My Wishlists</span>
                                    </a>
                                </div>
                                <div>
                                    <a href="{{ route('client.account.orders') }}" title="History">
                                        <i class="fa fa-file-alt"></i>
                                        <span>History</span>
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
                                        <span>Sign out</span>
                                    </a>
                                </div>

                                <div id="desktop_currency_selector"
                                    class="currency-selector groups-selector hidden-sm-down">
                                    <ul class="list-inline">
                                        <li>
                                            <a title="Euro" rel="nofollow" href="#">EUR</a>
                                        </li>
                                        <li class="current list-inline-item">
                                            <a title="British Pound Sterling" rel="nofollow" href="#">GBP</a>
                                        </li>
                                    </ul>
                                </div>
                                <div id="desktop_language_selector"
                                    class="language-selector groups-selector hidden-sm-down">
                                    <ul class="list-inline">
                                        <li class="list-inline-item current">
                                            <a href="#">
                                                <img class="img-fluid" src="img/home/home1-flas.jpg" alt="English"
                                                    width="16" height="11">
                                            </a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="#">
                                                <img class="img-fluid" src="img/home/home1-flas2.jpg" alt="Italiano"
                                                    width="16" height="11">
                                            </a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="#">
                                                <img class="img-fluid" src="img/home/home1-flas3.jpg" alt="Français"
                                                    width="16" height="11">
                                            </a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="#">
                                                <img class="img-fluid" src="img/home/home1-flas4.jpg" alt="Español"
                                                    width="16" height="11">
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                                                title="View Cart">View Cart</a>
                                                            <a href="{{ route('client.orders.checkout') }}"
                                                                title="Checkout">Checkout</a>
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
