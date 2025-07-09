@extends('layouts.master')

@section('content')
    <div class="container py-5">
        <div class="row">
            {{-- Sidebar: Bộ lọc --}}
            <div class="col-md-3">
                {{-- Loại sản phẩm --}}
                <div class="card mb-4">
                    <div class="card-header bg-warning text-white">
                        <strong>Loại sản phẩm</strong>
                    </div>
                    <ul class="list-group list-group-flush p-2">
                        <li class="form-check">
                            <input class="form-check-input" type="checkbox" id="all">
                            <label class="form-check-label" for="all">Tất cả</label>
                        </li>
                        <li class="form-check">
                            <input class="form-check-input" type="checkbox" id="ban">
                            <label class="form-check-label" for="ban">Bàn</label>
                        </li>
                        <li class="form-check">
                            <input class="form-check-input" type="checkbox" id="ghe">
                            <label class="form-check-label" for="ghe">Ghế</label>
                        </li>
                        <li class="form-check">
                            <input class="form-check-input" type="checkbox" id="sofa">
                            <label class="form-check-label" for="sofa">Sofa</label>
                        </li>
                    </ul>
                </div>

                {{-- Mức giá --}}
                <div class="card mb-4">
                    <div class="card-header bg-warning text-white">
                        <strong>Mức giá</strong>
                    </div>
                    <ul class="list-group list-group-flush p-2">
                        <li class="form-check">
                            <input class="form-check-input" type="checkbox" id="price1">
                            <label class="form-check-label" for="price1">Dưới 5 triệu</label>
                        </li>
                        <li class="form-check">
                            <input class="form-check-input" type="checkbox" id="price2">
                            <label class="form-check-label" for="price2">5 – 10 triệu</label>
                        </li>
                        <li class="form-check">
                            <input class="form-check-input" type="checkbox" id="price3">
                            <label class="form-check-label" for="price3">10 – 20 triệu</label>
                        </li>
                        <li class="form-check">
                            <input class="form-check-input" type="checkbox" id="price4">
                            <label class="form-check-label" for="price4">Trên 20 triệu</label>
                        </li>
                    </ul>
                </div>

                {{-- Sản phẩm bán chạy --}}
                <div class="card">
                    <div class="card-header bg-warning text-white">
                        <strong>Sản phẩm bán chạy</strong>
                    </div>
                    <div class="list-group list-group-flush">
                        <div class="list-group-item">
                            <p class="mb-1">Bàn Mara Walnut</p>
                            <small class="text-danger fw-bold">3.700.000đ</small><br>
                            <span class="text-warning">★★★★★</span>
                        </div>
                        <div class="list-group-item">
                            <p class="mb-1">Ghế Nosh Grey</p>
                            <small class="text-danger fw-bold">1.500.000đ</small><br>
                            <span class="text-warning">★★★★★</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Danh sách sản phẩm --}}
            <div class="col-md-9">
                <div class="row g-4">
                    @foreach ($products as $product)
                        @php
                            $translation = $product->translations->first();
                            $variant = $product->variants->first();
                            $discountPercent = null;
                            if ($variant && $variant->price > 0 && $product->base_price > 0) {
                                $discountPercent = round(
                                    (($product->base_price - $variant->price) / $product->base_price) * 100,
                                );
                            }
                        @endphp
                        <div class="col-md-4">
                            <div class="card h-100 position-relative">
                                @if ($discountPercent)
                                    <span class="badge bg-primary position-absolute top-0 start-0 m-2">
                                        -{{ $discountPercent }}%
                                    </span>
                                @endif
                                <a href="{{ route('client.products.show', $product->id) }}">
                                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top"
                                        style="height: 200px; object-fit: cover;" alt="{{ $translation->name }}">
                                </a>
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <a href="{{ route('client.products.show', $product->id) }}"
                                            class="text-decoration-none text-dark">
                                            {{ $translation->name }}
                                        </a>
                                    </h5>
                                    @if ($discountPercent)
                                        <p class="card-text text-danger fw-bold mb-1">
                                            {{ number_format($variant->price, 0, ',', '.') }} đ
                                        </p>
                                        <p class="card-text text-muted text-decoration-line-through">
                                            {{ number_format($product->base_price, 0, ',', '.') }} đ
                                        </p>
                                    @else
                                        <p class="card-text text-danger fw-bold">
                                            {{ number_format($variant->price ?? $product->base_price, 0, ',', '.') }} đ
                                        </p>
                                    @endif

                                    <div class="text-warning mb-2">
                                        ★★★★★ <small class="text-muted">({{ rand(5, 30) }} đánh giá)</small>
                                    </div>

                                    <a href="#" class="btn btn-warning w-100">Thêm vào giỏ</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Phân trang --}}
                {{-- <div class="mt-4">{{ $products->links() }}</div> --}}
            </div>
        </div>
    </div>
@endsection
