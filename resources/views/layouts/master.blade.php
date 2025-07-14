<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Nội thất cao cấp')</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

<style>
        :root {
            --bg-color: #F9F6F1;
            --primary-color: #8B5E3C;
            --accent-color: #6B8E23;
            --text-heading: #2F2F2F;
            --text-body: #4F4F4F;
            --cta-color: #C1440E;
        }

        body {
            background-color: #ffffff; /* đổi từ var(--bg-color) sang trắng */
            color: var(--text-body);
            font-family: 'Inter', sans-serif;
        }

        header {
            background-color: white;
            border-bottom: 1px solid #ddd;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1); /* thêm bóng cho header */
        }

        .navbar-brand {
            color: var(--primary-color);
            font-weight: 700;
            font-size: 24px;
        }

        footer {
            background-color: #000;
            color: #fff;
            padding: 30px 0;
        }

        .btn-cta {
            background-color: var(--cta-color);
            color: white;
            border: none;
        }

        .btn-cta:hover {
            opacity: 0.9;
        }

        .product-card {
            border: 1px solid #eee;
            border-radius: 8px;
            padding: 15px;
            background-color: white;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
            transition: 0.3s;
        }

        .product-card h5 {
            color: var(--text-heading);
        }

        a {
            text-decoration: none;
        }
<<<<<<< HEAD

        /* Dropdown xổ khi hover */
        .nav-item.dropdown:hover .dropdown-menu {
            display: block;
            margin-top: 0;
            /* Giảm giật */
        }

        /* Hover để hiển thị dropdown */
        .nav-item.dropdown:hover .dropdown-menu {
            display: block;
        }

        /* Tuỳ chỉnh style dropdown */
        .dropdown-menu.custom-room-menu {
            background-color: #111;
            /* Nền đen đậm */
            border: 1px solid #444;
            padding: 0;
            min-width: 200px;
        }

        /* Mỗi mục bên trong */
        .dropdown-menu.custom-room-menu .dropdown-item {
            color: #fff;
            padding: 12px 20px;
            border-bottom: 1px solid #444;
            font-size: 15px;
        }

        /* Hover */
        .dropdown-menu.custom-room-menu .dropdown-item:hover {
            background-color: #222;
            color: #ffd700;
            /* Vàng hoặc đổi màu nổi bật */
        }

        /* Bỏ border cuối cùng */
        .dropdown-menu.custom-room-menu .dropdown-item:last-child {
            border-bottom: none;
        }

</style>

    @yield('styles')
</head>


<!-- Các file JS khác ở đây -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Scripts riêng của từng trang (nếu có) -->
@stack('scripts')

<body>
    

<<<<<<< HEAD
    <!-- Header -->
    <header class="bg-light shadow-sm py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand fw-bold text-primary fs-4" href="{{ url('/client') }}">
                NoiThatStyleHouse
            </a>

            <nav>
                <ul class="nav align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('client.products.index') }}">Sản phẩm</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="roomDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Phòng
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="roomDropdown">
                            <li><a class="dropdown-item" href="">Phòng khách</a></li>
                            <li><a class="dropdown-item" href="">Phòng ăn</a></li>
                            <li><a class="dropdown-item" href="">Phòng ngủ</a></li>
                            <li><a class="dropdown-item" href="">Phòng làm việc</a></li>
                            <li><a class="dropdown-item" href="">Tủ bếp</a></li>
                            <li><a class="dropdown-item" href="">Ngoại thất</a></li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('client.blog.index') }}">Tin tức</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('client.contact.form') }}">Liên hệ</a>
                    </li>


                    {{-- ❤️ Yêu thích --}}
                 <li class="nav-item">
                    <a class="nav-link" href="{{ route('client.wishlist.index') }}">
                    <i class="fa-regular fa-heart"></i>
                   <span class="d-none d-md-inline">Yêu thích</span>
                 </a>
                </li>


                    {{-- 🛒 Giỏ hàng --}}
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="{{ route('client.carts.index') }}">
                            <i class="fa-solid fa-cart-shopping"></i>
                            <span class="d-none d-md-inline"></span>

                            {{-- Badge số lượng (nếu cần) --}}
                            @if (session('cart_count') && session('cart_count') > 0)
                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ session('cart_count') }}
                                </span>
                            @endif
                        </a>
                    </li>

                    @auth
                        {{-- Avatar & Dropdown --}}
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{ asset('images/avatar.png') }}" alt="avatar" class="rounded-circle"
                                    width="32" height="32">
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="userDropdown">
                                <li class="dropdown-item text-muted">Xin chào, {{ auth()->user()->name }}</li>
                                <li><a class="dropdown-item" href="{{ route('client.account.info') }}">Tài khoản</a></li>
                                <li><a class="dropdown-item" href="{{ route('client.account.orders') }}">Đơn mua</a></li>
                                <li><a class="dropdown-item" href="{{ route('client.account.wishlist') }}">Yêu thích</a>
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">Đăng xuất</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        {{-- Chưa đăng nhập: hiển thị Đăng nhập và Đăng ký --}}
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Đăng nhập</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">Đăng ký</a>
                            </li>
                        @endif
                    @endauth
                </ul>
            </nav>
        </div>
    </header>



    <!-- Nội dung chính -->
    <main class="container py-4">
        @yield('content')
        @yield('account_content')
    </main>
    @section('content')
<div class="container py-5">
    <h1 class="mb-4 text-center">Sản phẩm mới nhất</h1>
    <div class="row">
        @foreach ($products as $product)
            <div class="col-md-3 mb-4">
                <div class="product-card">
                @if($product->image && file_exists(public_path('storage/' . $product->image)))
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->translation->name }}" class="product-image">
                @else
                    <img src="{{ asset('images/default-product.jpg') }}" alt="No image" class="product-image">
                @endif                  
                <div class="product-name">{{ $product->translation->name }}</div>
                    <div class="product-price">{{ number_format($product->base_price, 0, ',', '.') }} đ</div>

                    <div class="mt-3">
                        <a href="{{ route('product.show', $product->id) }}" class="btn btn-outline-primary btn-sm">Xem chi tiết</a>
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-warning btn-sm">Thêm vào giỏ</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

    <!-- Footer -->
    <footer class="bg-dark text-white pt-5 pb-3 mt-5">
        <div class="container">
            <div class="row">
                <!-- Cột 1: Giới thiệu -->
                <div class="col-md-4">
                    <h5>Về NoiThatPlus</h5>
                    <p>Chúng tôi chuyên cung cấp nội thất cao cấp cho không gian sống hiện đại và tiện nghi.</p>
                </div>

                <!-- Cột 2: Liên kết nhanh -->
                <div class="col-md-4">
                    <h5>Liên kết</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ url('/') }}" class="text-white text-decoration-none">Trang chủ</a></li>
                        <li><a href="{{ url('/san-pham') }}" class="text-white text-decoration-none">Sản phẩm</a></li>
                        <li><a href="{{ url('/bai-viet') }}" class="text-white text-decoration-none">Bài viết</a></li>
                        <li><a href="{{ url('/lien-he') }}" class="text-white text-decoration-none">Liên hệ</a></li>

                    </ul>
                </div>

                <!-- Cột 3: Thông tin liên hệ -->
                <div class="col-md-4">
                    <h5>Liên hệ</h5>
                    <p>Email: support@noithatplus.vn</p>
                    <p>Điện thoại: 0909 999 999</p>
                    <p>Địa chỉ: 123 Nguyễn Trãi, Quận 1, TP.HCM</p>
                </div>
            </div>

            <hr class="bg-secondary">

            <!-- Copyright -->
            <div class="text-center">
                <p class="mb-0">&copy; {{ date('Y') }} NoiThatPlus. All rights reserved.</p>
            </div>
        </div>
    </footer>


    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    @yield('scripts')
    <script>
    document.getElementById('toggleSearch').addEventListener('click', function (e) {
        e.stopPropagation();
        const searchBox = document.getElementById('searchBox');
        searchBox.classList.toggle('d-none');
    });

    document.addEventListener('click', function (e) {
        const searchBox = document.getElementById('searchBox');
        const toggleButton = document.getElementById('toggleSearch');
        if (!searchBox.contains(e.target) && !toggleButton.contains(e.target)) {
            searchBox.classList.add('d-none');
        }
    });
    </script>
</body>

</html>
