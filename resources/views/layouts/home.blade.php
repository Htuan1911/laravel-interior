<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Nội thất cao cấp')</title>

@section('content')

<!-- Banner -->
<div id="bannerCarousel" class="carousel slide mb-5" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="{{ asset('images/banner 1.jpg') }}" class="d-block w-100" alt="Banner 1">
            <div class="carousel-caption d-none d-md-block text-center bg-dark bg-opacity-75 p-4 rounded shadow-lg">
                <h1 class="display-4 fw-bold mb-3 text-white">SỰ KẾT HỢP MỚI MẺ</h1>
                <p class="mb-3 text-white-50">Chúng tôi luôn kết hợp các sản phẩm đẹp mắt, phù hợp và ấn tượng.</p>
                <a href="#" class="btn btn-primary btn-lg">CHI TIẾT</a>
            </div>
        </div>
        <div class="carousel-item">
            <img src="{{ asset('images/banner 2.jpg') }}" class="d-block w-100" alt="Banner 2">
            <div class="carousel-caption d-none d-md-block text-center bg-dark bg-opacity-75 p-4 rounded shadow-lg">
                <h1 class="display-4 fw-bold mb-3 text-white">THIẾT KẾ ĐỘC ĐÁO</h1>
                <p class="mb-3 text-white-50">Khám phá phong cách nội thất hiện đại và sáng tạo.</p>
                <a href="#" class="btn btn-primary btn-lg">KHÁM PHÁ</a>
            </div>
        </div>
        <div class="carousel-item">
            <img src="{{ asset('images/banner 3.jpg') }}" class="d-block w-100" alt="Banner 3">
            <div class="carousel-caption d-none d-md-block text-center bg-dark bg-opacity-75 p-4 rounded shadow-lg">
                <h1 class="display-4 fw-bold mb-3 text-white">ƯU ĐÃI ĐẶC BIỆT</h1>
                <p class="mb-3 text-white-50">Nhận ngay ưu đãi khi mua sắm hôm nay!</p>
                <a href="#" class="btn btn-primary btn-lg">MUA NGAY</a>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<!-- Chính sách -->
<div class="container mb-5">
    <div class="row text-center py-4 bg-light rounded shadow-sm">
        <div class="col-md-3 col-6 mb-3">
            <h5 class="text-primary">Phương thức đổi trả</h5>
            <small>Trong 30 ngày</small>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <h5 class="text-primary">Miễn phí giao hàng</h5>
            <small>Toàn quốc</small>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <h5 class="text-primary">Hỗ trợ trực tuyến</h5>
            <small>24/7</small>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <h5 class="text-primary">Ưu đãi & khuyến mại</h5>
            <small>Giảm giá lớn</small>
        </div>
    </div>
</div>

<!-- Danh mục sản phẩm -->
<div class="container mb-5">
    <h2 class="mb-4 text-primary">Danh mục sản phẩm</h2>
    <div class="row row-cols-1 row-cols-md-4 g-3">
        @forelse($categories as $category)
            <div class="col">
                <a href="{{ route('client.categories.show', $category->id) }}" class="btn btn-outline-primary w-100 py-3 text-decoration-none">
                    {{ $category->name }}
                </a>
            </div>
        @empty
            <p class="text-muted">Không có danh mục nào.</p>
        @endforelse
    </div>
</div>

<!-- Sản phẩm nổi bật -->
<div class="container mb-5">
    <h2 class="mb-4 text-primary">Sản phẩm nổi bật</h2>
    <div class="row row-cols-1 row-cols-md-4 g-4">
        @forelse($products as $product)
            <div class="col">
                <div class="card h-100 border-0 shadow-sm d-flex flex-column product-card">
                    <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/placeholder.jpg') }}" class="card-img-top" alt="{{ $product->name }}">
                    <div class="card-body text-center d-flex flex-column flex-grow-1">
                        <h5 class="card-title mb-2">{{ $product->name }}</h5>
                        <p class="card-text text-danger fw-bold mb-3">{{ number_format($product->base_price, 0, ',', '.') }}đ</p>
                        <div class="mt-auto">
                            <a href="{{ route('client.products.show', $product->id) }}" class="btn btn-primary btn-sm w-100">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">Không có sản phẩm nào.</p>
        @endforelse
    </div>
</div>

<!-- Sản phẩm khuyến mãi -->
<div class="container mb-5">
    <h2 class="mb-4 text-primary">Sản phẩm khuyến mãi</h2>
    <div class="row row-cols-1 row-cols-md-4 g-4">
        @forelse($promotions as $product)
            <div class="col">
                <div class="card h-100 border-0 shadow-sm d-flex flex-column product-card">
                    <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/placeholder.jpg') }}" class="card-img-top" alt="{{ $product->name }}">
                    <div class="card-body text-center d-flex flex-column flex-grow-1">
                        <h5 class="card-title mb-2">{{ $product->name }}</h5>
                        <p class="card-text text-danger fw-bold mb-3">{{ number_format($product->base_price, 0, ',', '.') }}đ</p>
                        <div class="mt-auto">
                            <span class="badge bg-warning text-dark w-100 py-2">Khuyến mãi</span>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">Không có sản phẩm khuyến mãi nào.</p>
        @endforelse
    </div>
</div>

<!-- Sản phẩm bán chạy -->
<div class="container mb-5">
    <h2 class="mb-4 text-primary">Sản phẩm bán chạy</h2>
    <div class="row row-cols-1 row-cols-md-2 g-3">
        @forelse($bestSellers as $product)
            <div class="col">
                <div class="list-group-item d-flex align-items-center bg-light shadow-sm p-3">
                    <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/placeholder.jpg') }}" alt="{{ $product->name }}" class="me-3 rounded" style="width: 80px; height: 80px; object-fit: cover;">
                    <div class="text-start">
                        <strong>{{ $product->name }}</strong><br>
                        <span class="text-danger fw-bold">{{ number_format($product->base_price, 0, ',', '.') }}đ</span>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">Không có sản phẩm bán chạy nào.</p>
        @endforelse
    </div>
</div>

<!-- Style -->
<style>
    .carousel-item img {
        height: 400px;
        object-fit: cover;
        width: 100%;
    }

    .card-img-top {
        height: 200px;
        object-fit: cover;
    }

    .product-card {
        transition: all 0.3s ease-in-out;
        background-color: #ffffff;
        border-radius: 10px;
    }

    .product-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        border: 1px solid #0d6efd20;
        background-color: #f8f9fa;
    }

    .card-title {
        font-size: 1rem;
        font-weight: 600;
    }

    @media (max-width: 768px) {
        .carousel-item img {
            height: 250px;
        }

        .card-img-top {
            height: 150px;
        }

        .product-card:hover {
            transform: none;
            box-shadow: none;
            border: none;
            background-color: #f01313ff;
        }
    }
</style>


@endsection
