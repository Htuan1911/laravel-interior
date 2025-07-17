@extends('layouts.master')

@section('title', 'Trang chủ')

@section('content')
<h1 class="mb-4">Sản phẩm mới nhất</h1>
<div class="row">
    @foreach ($products as $product)
    <div class="col-md-3 mb-4">
        <div class="product-card">
            <img src="{{ $product->image_url }}" class="img-fluid mb-2" alt="{{ $product->name }}">
            <h5>{{ $product->name }}</h5>
            <p>{{ number_format($product->price) }} đ</p>
            <a href="{{ route('client.products.show', $product->id) }}" class="btn btn-cta btn-sm">Xem chi tiết</a>
        </div>
    </div>
    @endforeach
</div>



@auth
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        Tài khoản
    </a>
    <ul class="dropdown-menu" aria-labelledby="accountDropdown">
        <li><a class="dropdown-item" href="{{ route('client.account.info') }}">Thông tin cá nhân</a></li>
        <li><a class="dropdown-item" href="{{ route('client.account.vouchers') }}">Kho voucher</a></li>
        <li><a class="dropdown-item" href="{{ route('client.account.orders') }}">Lịch sử đơn hàng</a></li>
        <li><a class="dropdown-item" href="{{ route('client.account.wishlist') }}">Yêu thích</a></li>
    </ul>
</li>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


@endauth

@endsection