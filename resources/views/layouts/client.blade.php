<!DOCTYPE html>
<html>
<head>
    <title>Trang chủ - Wood Workshop</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        .banner { position: relative; text-align: center; }
        .banner-text { position: absolute; top: 30%; left: 10%; color: white; }
        .policies { display: flex; justify-content: space-around; padding: 20px; background: #f7f7f7; }
        .policy { text-align: center; }
        .section { padding: 30px; }
        .product-list { display: flex; gap: 20px; flex-wrap: wrap; }
        .product-card { width: 200px; border: 1px solid #ccc; padding: 10px; text-align: center; }
    </style>
</head>
<body>
    <header>
        <!-- Menu điều hướng -->
        <nav>
            <a href="{{ route('home') }}">Trang chủ</a>
            <a href="#">Sản phẩm</a>
            <a href="#">Tin tức</a>
            <a href="#">Liên hệ</a>
            <a href="#">Giới thiệu</a>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer style="text-align:center; padding:20px;">
        Copyright © ShareCode.vn
    </footer>
</body>
</html>
