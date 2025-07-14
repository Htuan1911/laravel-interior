@extends('layouts.master')

@section('title', 'Trang chủ')

@section('styles')
<style>
    .banner-slider {
        position: relative;
        height: 400px;
        margin-bottom: 40px;
        overflow: hidden;
    }

    .banner-slide {
        position: absolute;
        top: 0; /* Căn cùng 1 vị trí */
        bottom: 0;
        margin: auto;
        transition: all 0.8s ease;
        border-radius: 10px;
        overflow: hidden;
    }

    .banner-slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 10px;
    }

    .banner-center {
        left: 20%;
        width: 60%;
        height: 100%;
        z-index: 2;
        box-shadow: 10px 20px 10px rgba(0,0,0,0.5);
    }

    .banner-left {
        left: 0;
        width: 25%;
        height: 85%;
        opacity: 0.5;
        z-index: 1;
    }

    .banner-right {
        right: 0;
        width: 25%;
        height: 85%;
        opacity: 0.5;
        z-index: 1;
    }

    .banner-controls {
        position: absolute;
        top: 45%;
        width: 100%;
        z-index: 3;
        display: flex;
        justify-content: space-between;
        padding: 0 20px;
    }

    .banner-controls button {
        background: rgba(0,0,0,0.4);
        border: none;
        color: white;
        padding: 10px 15px;
        border-radius: 50%;
        font-size: 20px;
        cursor: pointer;
    }
</style>

@endsection

@section('content')

    <div class="banner-slider" id="bannerSlider">
        <div class="banner-slide banner-left" id="leftSlide">
            <img src="{{ asset('images/banner4.jpg') }}" alt="Banner Left">
        </div>
        <div class="banner-slide banner-center" id="centerSlide">
            <img src="{{ asset('images/banner1.jpg') }}" alt="Banner Center">
        </div>
        <div class="banner-slide banner-right" id="rightSlide">
            <img src="{{ asset('images/banner2.jpg') }}" alt="Banner Right">
        </div>

        <div class="banner-controls">
            <button onclick="prevBanner()">&#8592;</button>
            <button onclick="nextBanner()">&#8594;</button>
        </div>
    </div>


    <div class="container py-5">
        <h2 class="mb-4">Sản phẩm mới nhất</h2>
        <div class="row">
            @foreach($products as $product)
                <div class="col-md-3 mb-4">
                    <div class="product-card">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->translation->name ?? 'No name' }}" class="img-fluid mb-3">
                        <h5>{{ $product->translation->name ?? 'Chưa có tên' }}</h5>
                        <p class="text-danger fw-bold">Giá: {{ number_format($product->base_price) }} đ</p>
                        <a href="{{ route('product.show', $product->id) }}" class="btn btn-outline-primary btn-sm">Xem chi tiết</a>
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">Thêm vào giỏ</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@section('scripts')
<script>
    const banners = [
        "{{ asset('images/banner1.jpg') }}",
        "{{ asset('images/banner2.jpg') }}",
        "{{ asset('images/banner3.jpg') }}",
        "{{ asset('images/banner4.jpg') }}"
    ];

    let current = 0;

    function updateSlides() {
        const left = document.getElementById('leftSlide');
        const center = document.getElementById('centerSlide');
        const right = document.getElementById('rightSlide');

        const total = banners.length;
        const prevIndex = (current - 1 + total) % total;
        const nextIndex = (current + 1) % total;
        const currentIndex = current;

        left.querySelector('img').src = banners[prevIndex];
        center.querySelector('img').src = banners[currentIndex];
        right.querySelector('img').src = banners[nextIndex];
    }

    function prevBanner() {
        current = (current - 1 + banners.length) % banners.length;
        updateSlides();
    }

    function nextBanner() {
        current = (current + 1) % banners.length;
        updateSlides();
    }


    setInterval(() => {
        nextBanner();
    }, 3500);

    // Gọi ban đầu
    updateSlides();
</script>
@endsection
