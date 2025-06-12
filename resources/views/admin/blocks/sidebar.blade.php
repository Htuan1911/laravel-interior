<div class="d-flex flex-column p-3 text-white bg-dark" style="height: 100vh;">
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link text-white">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('admin.products_without_variants.index') }}" class="nav-link text-white">
                <i class="fas fa-box"></i> Quản lý sản phẩm chưa có biến thể
            </a>
        </li>
        <li>
            <a href="{{ route('admin.products.index') }}" class="nav-link text-white">
                <i class="fas fa-box"></i> Quản lý sản phẩm có biến thể
            </a>
        </li>
        <li>
            <a href="{{ route('admin.variants.index') }}" class="nav-link text-white">
                <i class="fas fa-box"></i> Quản lý biến thể
            </a>
        </li>
        <li>
            <a href="{{ route('admin.categories.index') }}" class="nav-link text-white">
                <i class="fas fa-box"></i> Quản lý danh mục
            </a>
        </li>

    {{-- <div class="d-flex justify-content-center mt-3">
        <form action="{{ route('logout') }}" method="post">
            @csrf
            <button type="submit" class="btn btn-danger w-90">
                <i class="fas fa-sign-out-alt"></i> Đăng xuất
            </button>
        </form>
    </div> --}}
</div>
