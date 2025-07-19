@extends('layouts.master')

@section('title', $product->translation->name ?? 'Chi tiết sản phẩm')




@section('styles')
<style>
    .product-detail {
        background: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1); /* tăng đổ bóng */
    }
    .product-detail img {
        max-width: 100%;
        border-radius: 10px;
    }
    .product-card {
        border: 1px solid #eee;
        border-radius: 8px;
        padding: 15px;
        background-color: white;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        transition: 0.3s;
        height: 100%;
    }
    .product-image {
        height: 200px;
        object-fit: cover;
        width: 100%;
        border-radius: 8px;
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
    .shadow-box {
    background: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
}
</style>
@endsection

@section('content')

<div class="product-detail container mb-5">
    <div class="row">
        <div class="col-md-6">
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->translation->name ?? 'Sản phẩm' }}">
        </div>
        <div class="col-md-6">
            <h2>{{ $product->translation->name ?? 'Không có tên' }}</h2>

            {{-- Đánh giá sao --}}
            <div class="rating mb-2">
                <strong>Đánh giá:</strong>
                <span class="text-warning">★★★★☆</span>
                <small>(124 lượt đánh giá)</small>
            </div>

            <p><strong>Giá:</strong> {{ number_format($product->base_price, 0, ',', '.') }} đ</p>
            <p><strong>Chất liệu:</strong> {{ $product->translation->material ?? 'Không rõ' }}</p>
            <p><strong>Phong cách:</strong> {{ $product->translation->style ?? 'Không rõ' }}</p>
            <p><strong>Bảo hành:</strong> {{ $product->warranty_months }} tháng</p>

            <p><strong>Mô tả:</strong></p>
            <div>{{ $product->translation->description ?? 'Không có mô tả' }}</div>

            {{-- Form chọn số lượng và mua --}}
    @php
    $cartAddRoute = \Illuminate\Support\Facades\Route::has('cart.add') 
        ? route('cart.add', $product->id) 
        : null;
        @endphp

        <form action="{{ $cartAddRoute ?? '#' }}" method="POST" class="mt-4 d-flex align-items-center" style="gap: 10px;">
            @csrf
            <input type="number" name="quantity" min="1" value="1" class="form-control w-auto" style="width: 80px;" required>

            <button type="submit" class="btn btn-success btn-sm" {{ is_null($cartAddRoute) ? 'disabled' : '' }}>
                <i class="fas fa-cart-plus me-1"></i> Thêm vào giỏ
            </button>

            <button type="submit" name="buy_now" value="1" class="btn btn-danger btn-sm" {{ is_null($cartAddRoute) ? 'disabled' : '' }}>
                <i class="fas fa-bolt me-1"></i> Mua ngay
            </button>
        </form>

        @if(is_null($cartAddRoute))
            <div class="text-danger mt-2">⚠️ Chức năng giỏ hàng chưa khả dụng</div>
        @endif

        </div>
    </div>
</div>

{{-- Bình luận --}}
<h4>Bình Luận</h4>
@if(Auth::check())
<div class="comment-box shadow-box mb-5">
    Bình Luận

    <h5 class="mb-3">Viết bình luận</h5>
    <form method="POST" action="{{ route('product.comment', $product->id) }}">
        @csrf
        <div class="mb-3">
            <textarea name="content" class="form-control" rows="3" placeholder="Nội dung bình luận" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Gửi bình luận</button>
    </form>
</div>
@else
<div class="comment-box shadow-box mb-5">
    <div class="alert alert-warning">
        Vui lòng <a href="#">đăng nhập</a> để gửi bình luận.
    </div>
</div>
@endif



{{-- Sản phẩm liên quan --}}
@if(isset($relatedProducts) && $relatedProducts->count())
<div class="shadow-box mb-5 p-4">
    <h4 class="mb-4">Sản phẩm liên quan</h4>
    <div class="row">
        @foreach($relatedProducts as $related)
            <div class="col-md-3 mb-4">
                <div class="product-card">
                    <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->translation->name }}" class="product-image">
                    <div class="product-name">{{ $related->translation->name }}</div>
                    <div class="product-price">{{ number_format($related->base_price, 0, ',', '.') }} đ</div>
                    <a href="{{ route('product.show', $related->id) }}" class="btn btn-outline-primary btn-sm mt-2">Xem chi tiết</a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endif

@endsection
