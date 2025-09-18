<div class="d-flex flex-column p-3 text-white bg-dark" style="height: 100vh; width: 250px;">
    <h4 class="mb-4 text-center">
        <i class="fas fa-cogs me-2"></i> Admin Panel
    </h4>

    <ul class="nav nav-pills flex-column mb-auto">

        {{-- Dashboard --}}
        <li class="nav-item mb-2">
            <a href="{{ route('admin.dashboard') }}"
               class="nav-link text-white {{ request()->routeIs('admin.dashboard') ? 'active bg-primary' : '' }}">
                <i class="fas fa-chart-line me-2"></i> Dashboard
            </a>
        </li>

        {{-- Quản lý tài khoản --}}
        <li class="nav-item mb-2">
            <a href="{{ route('admin.users.index') }}"
               class="nav-link text-white {{ request()->routeIs('admin.users.*') ? 'active bg-primary' : '' }}">
                <i class="fas fa-user-cog me-2"></i> Tài khoản
            </a>
        </li>

        {{-- Quản lý danh mục --}}
        <li class="nav-item mb-2">
            <a href="{{ route('admin.categories.index') }}"
               class="nav-link text-white {{ request()->routeIs('admin.categories.*') ? 'active bg-primary' : '' }}">
                <i class="fas fa-sitemap me-2"></i> Danh mục
            </a>
        </li>

        {{-- Quản lý thuộc tính --}}
        <li class="nav-item mb-2">
            <a href="{{ route('admin.product_options.index') }}"
               class="nav-link text-white {{ request()->routeIs('admin.product_options.*') ? 'active bg-primary' : '' }}">
                <i class="fas fa-tags me-2"></i> Thuộc tính
            </a>
        </li>

        {{-- Quản lý sản phẩm --}}
        <li class="nav-item mb-2">
            <a href="{{ route('admin.products.index') }}"
               class="nav-link text-white {{ request()->routeIs('admin.products.*') ? 'active bg-primary' : '' }}">
                <i class="fas fa-boxes me-2"></i> Sản phẩm
            </a>
        </li>

        {{-- Quản lý SP yêu thích --}}
        {{-- <li class="nav-item mb-2">
            <a href="{{ route('admin.wishlists.index') }}"
               class="nav-link text-white {{ request()->routeIs('admin.wishlists.*') ? 'active bg-primary' : '' }}">
                <i class="fas fa-heart me-2"></i> Sản phẩm yêu thích
            </a>
        </li> --}}

        {{-- Quản lý mã giảm giá --}}
        <li class="nav-item mb-2">
            <a href="{{ route('admin.coupons.index') }}"
               class="nav-link text-white {{ request()->routeIs('admin.coupons.*') ? 'active bg-primary' : '' }}">
                <i class="fas fa-percentage me-2"></i> Mã giảm giá
            </a>
        </li>

        {{-- Quản lý đơn hàng --}}
        <li class="nav-item mb-2">
            <a href="{{ route('admin.orders.index') }}"
               class="nav-link text-white {{ request()->routeIs('admin.orders.*') ? 'active bg-primary' : '' }}">
                <i class="fas fa-receipt me-2"></i> Đơn hàng
            </a>
        </li>

        {{-- Quản lý thanh toán --}}
        {{-- <li class="nav-item mb-2">
            <a href="{{ route('admin.payments.index') }}"
               class="nav-link text-white {{ request()->routeIs('admin.payments.*') ? 'active bg-primary' : '' }}">
                <i class="fas fa-wallet me-2"></i> Thanh toán
            </a>
        </li> --}}

        {{-- Quản lý đánh giá --}}
        <li class="nav-item mb-2">
            <a href="{{ route('admin.reviews.index') }}"
               class="nav-link text-white {{ request()->routeIs('admin.reviews.*') ? 'active bg-primary' : '' }}">
                <i class="fas fa-star me-2"></i> Đánh giá
            </a>
        </li>
     {{-- <li class="nav-item mb-2">
    <a href="{{ route('admin.carts.index') }}"
        class="nav-link text-white {{ request()->routeIs('admin.carts.*') ? 'active bg-primary' : '' }}">
        <i class="fas fa-shopping-cart me-2"></i> Quản lý giỏ hàng
    </a>
</li>   --}}

    <li class="nav-item mb-2">
            <a href="{{ route('admin.posts.index') }}"
               class="nav-link text-white {{ request()->routeIs('admin.posts.*') ? 'active bg-primary' : '' }}">
                <i class="fas fa-star me-2"></i> Bài Viết 
            </a>
    </li>
    <li class="nav-item mb-2">
            <a href="{{ route('admin.post_categories.index') }}"
               class="nav-link text-white {{ request()->routeIs('admin.post_categories.*') ? 'active bg-primary' : '' }}">
                <i class="fas fa-star me-2"></i> Danh Mục Bài Viết 
            </a>
    </li>

    </ul>
</div>
