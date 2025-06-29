<div class="d-flex flex-column p-3 text-white bg-dark" style="height: 100vh; width: 250px;">
    <h4 class="mb-4 text-center">
        <i class="fas fa-cogs me-2"></i> Admin Panel
    </h4>

    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item mb-2">
            <a href="{{ route('admin.dashboard') }}"
                class="nav-link text-white {{ request()->routeIs('admin.dashboard') ? 'active bg-primary' : '' }}">
                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="{{ route('admin.users.index') }}"
                class="nav-link text-white {{ request()->routeIs('admin.users.*') ? 'active bg-primary' : '' }}">
                <i class="fas fa-users me-2"></i> Quản lý tài khoản
            </a>
        </li>
      
         <li class="nav-item mb-2">
            <a href="{{ route('admin.product_options.index') }}"
                class="nav-link text-white {{ request()->routeIs('admin.product_options.*') ? 'active bg-primary' : '' }}">
                <i class="fas fa-random me-2"></i> Quản lý thuộc tính sản phẩm
            </a>
        </li>
         <li class="nav-item mb-2">
            <a href="{{ route('admin.products.index') }}"
                class="nav-link text-white {{ request()->routeIs('admin.products.*') ? 'active bg-primary' : '' }}">
                <i class="fas fa-random me-2"></i> Quản sản phẩm
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="{{ route('admin.categories.index') }}"
                class="nav-link text-white {{ request()->routeIs('admin.categories.*') ? 'active bg-primary' : '' }}">
                <i class="fas fa-list-alt me-2"></i> Quản lý danh mục
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="{{ route('admin.coupons.index') }}"
                class="nav-link text-white {{ request()->routeIs('admin.coupons.*') ? 'active bg-primary' : '' }}">
                <i class="fas fa-ticket-alt me-2"></i> Quản lý mã giảm giá
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="{{ route('admin.orders.index') }}"
                class="nav-link text-white {{ request()->routeIs('admin.orders.*') ? 'active bg-primary' : '' }}">
                <i class="fas fa-shopping-cart me-2"></i> Quản lý đơn hàng
            </a>
        </li>


        <li class="nav-item mb-2">
            <a href="{{ route('admin.payments.index') }}"
                class="nav-link text-white {{ request()->routeIs('admin.payments.*') ? 'active bg-primary' : '' }}">
                <i class="fas fa-credit-card me-2"></i> Quản lý thanh toán
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="{{ route('admin.products.index') }}"
                class="nav-link text-white {{ request()->routeIs('admin.products.*') ? 'active bg-primary' : '' }}">
                <i class="fas fa-boxes me-2"></i> Sản phẩm có biến thể
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="{{ route('admin.products_without_variants.index') }}"
                class="nav-link text-white {{ request()->routeIs('admin.products_without_variants.*') ? 'active bg-primary' : '' }}">
                <i class="fas fa-box-open me-2"></i> Sản phẩm chưa có biến thể
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="{{ route('admin.reviews.index') }}"
                class="nav-link text-white {{ request()->routeIs('admin.reviews.*') ? 'active bg-primary' : '' }}">
                <i class="fas fa-star me-2"></i> Quản lý đánh giá
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="{{ route('admin.users.index') }}"
                class="nav-link text-white {{ request()->routeIs('admin.users.*') ? 'active bg-primary' : '' }}">
                <i class="fas fa-users me-2"></i> Quản lý tài khoản
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="{{ route('admin.variants.index') }}"
                class="nav-link text-white {{ request()->routeIs('admin.variants.*') ? 'active bg-primary' : '' }}">
                <i class="fas fa-random me-2"></i> Quản lý biến thể
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="{{ route('admin.wishlists.index') }}"
                class="nav-link text-white {{ request()->routeIs('admin.wishlists.*') ? 'active bg-primary' : '' }}">
                <i class="fas fa-heart me-2"></i> Quản lý SP yêu thích
            </a>
        </li>
    </ul>
</div>
