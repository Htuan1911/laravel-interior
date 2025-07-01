<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Nội thất cao cấp')</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap hoặc Tailwind tùy bạn -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    
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
            background-color: var(--bg-color);
            font-family: 'Inter', sans-serif;
            color: var(--text-body);
        }

        header {
            background-color: white;
            border-bottom: 1px solid #ddd;
        }

        .navbar-brand {
            color: var(--primary-color);
            font-weight: 700;
            font-size: 24px;
        }

        footer {
            background-color: var(--primary-color);
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
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        .product-card h5 {
            color: var(--text-heading);
        }

        a {
            text-decoration: none;
        }
    </style>

    @yield('styles')
</head>
<body>

    <!-- Header -->
    <header>
        <nav class="navbar navbar-expand-lg container">
            <a class="navbar-brand" href="">NoiThatStyleHouse</a>
            <div class="collapse navbar-collapse justify-content-end">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="">Sản phẩm</a></li>
                    <li class="nav-item"><a class="nav-link" href="">Bài viết</a></li>
                    <li class="nav-item"><a class="nav-link" href="">Liên hệ</a></li>
                    @auth
                        <li class="nav-item"><a class="nav-link" href="">Đăng xuất</a></li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="">Đăng nhập</a></li>
                    @endauth
                </ul>
            </div>
        </nav>
    </header>

    <!-- Nội dung chính -->
    <main class="container py-4">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        <div class="container text-center">
            <p>&copy; {{ date('Y') }} NoiThatPlus. All rights reserved.</p>
        </div>
    </footer>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
