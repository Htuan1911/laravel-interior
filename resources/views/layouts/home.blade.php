<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Nội thất cao cấp')</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        :root {
            --bg-color: #ffffff;
            --primary-color: #8B5E3C;
            --accent-color: #6B8E23;
            --text-heading: #2F2F2F;
            --text-body: #4F4F4F;
            --cta-color: #C1440E;
            --shadow-color: rgba(0, 0, 0, 0.2);
        }

        body {
            background-color: var(--bg-color);
            font-family: 'Inter', sans-serif;
            color: var(--text-body);
        }

        header {
            background-color: white;
            border-bottom: 1px solid #ddd;
            box-shadow: 0 3px 8px var(--shadow-color);
        }

        .navbar-brand {
            color: var(--primary-color);
            font-weight: 700;
            font-size: 24px;
        }

        footer {
            background-color: #000;
            color: white;
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
            box-shadow: 0 4px 10px var(--shadow-color);
            transition: 0.3s;
            height: 100%;
        }

        .product-card:hover {
            transform: translateY(-5px);
        }

        .product-image {
            height: 200px;
            object-fit: contain;
            width: 100%;
        }

        .product-name {
            font-size: 16px;
            font-weight: 600;
            margin: 10px 0 5px;
        }

        .product-price {
            font-size: 16px;
            font-weight: 700;
            color: red;
        }

        .text-brown {
            color: var(--primary-color) !important;
        }

        #searchBox {
            position: absolute;
            top: 50px;
            left: 0;
            background-color: white;
            width: 400px;
            max-width: 90vw;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            border-radius: 40px;
            padding: 10px 15px;
            display: none;
        }

        #searchBox input {
            border: none;
            outline: none;
            flex-grow: 1;
        }

        #toggleSearch {
            background: transparent;
            border: none;
            color: #555;
        }
    </style>

    @yield('styles')
</head>
<body>
<header class="bg-white shadow-sm sticky-top">
    <nav class="navbar navbar-expand-lg navbar-light container">
        <a class="navbar-brand fw-bold text-brown me-4" href="{{ route('home') }}">
            <i class="fas fa-couch me-2"></i>StyleHouse
        </a>

        <!-- Tìm kiếm -->
        <div class="me-auto position-relative">
            <button id="toggleSearch"><i class="fas fa-search"></i> Tìm Kiếm</button>
            <div id="searchBox">
                <form action="#" method="GET" class="d-flex align-items-center">
                    <input type="text" name="keyword" placeholder="Tìm sản phẩm...">
                    <button class="btn btn-sm btn-primary ms-2"><i class="fas fa-search"></i></button>
                </form>
            </div>
        </div>

        <!-- Menu -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarMain">
            <ul class="navbar-nav align-items-center mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="{{ route('home') }}"><i class="fas fa-home me-1"></i>Trang chủ</a></li>
                <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-box"></i> Sản phẩm</a></li>
                <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-pen"></i> Bài viết</a></li>
                <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-phone"></i> Liên hệ</a></li>
                <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-shopping-cart"></i> Giỏ hàng</a></li>
            </ul>

            @auth
                <a class="btn btn-outline-dark btn-sm ms-2" href="#"><i class="fas fa-user"></i> Tài khoản</a>
            @else
                <a class="btn btn-primary btn-sm ms-2" href="#"><i class="fas fa-sign-in-alt"></i> Đăng nhập</a>
                <a class="btn btn-outline-primary btn-sm ms-2" href="#"><i class="fas fa-user-plus"></i> Đăng ký</a>
            @endauth
        </div>
    </nav>
</header>

@yield('banner')
<main class="container py-4">
    @yield('content')
</main>

<footer>
    <div class="container text-center">
        <p>&copy; {{ date('Y') }} NoiThatPlus. All rights reserved.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
<script>
    const toggleSearch = document.getElementById('toggleSearch');
    const searchBox = document.getElementById('searchBox');

    toggleSearch.addEventListener('click', () => {
        searchBox.style.display = searchBox.style.display === 'block' ? 'none' : 'block';
    });

    document.addEventListener('click', (e) => {
        if (!searchBox.contains(e.target) && !toggleSearch.contains(e.target)) {
            searchBox.style.display = 'none';
        }
    });
</script>
</body>
<x-chatbot />
</html>
