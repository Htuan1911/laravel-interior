<nav class="navbar navbar-dark bg-dark sticky-top flex-md-nowrap p-2 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">Admin Panel</a>
    <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-link btn btn-link text-white text-decoration-none p-0 m-0">
                    Đăng xuất
                </button>
            </form>
        </li>
    </ul>
</nav>
