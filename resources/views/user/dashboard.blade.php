{{-- <!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang Người Dùng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Xin chào, {{ Auth::user()->name }}!</h1>
        <p>Bạn đang đăng nhập với vai trò: {{ Auth::user()->role->name }}</p>

        <a href="{{ route('logout') }}" class="btn btn-danger"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Đăng xuất
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
</body>
</html> --}}
