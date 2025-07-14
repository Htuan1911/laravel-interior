@extends('layouts.master')

@section('content')
    <style>
        .product-card {
            background: #fff;
            border: 1px solid #eaeaea;
            border-radius: 6px;
            overflow: hidden;
            transition: all 0.3s ease-in-out;
            position: relative;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .product-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
        }

        .product-image-wrapper {
            position: relative;
            width: 100%;
            height: 220px;
            /* Thu nhỏ chiều cao ảnh */
            overflow: hidden;
        }

        .product-image,
        .product-image-hover {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: opacity 0.4s ease-in-out;
        }

        .product-image-hover {
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0;
        }

        .product-card:hover .product-image-hover {
            opacity: 1;
        }

        .product-info {
            padding: 14px;
            flex-grow: 1;
        }

        .product-title {
            font-size: 15px;
            font-weight: 500;
            color: #222;
            margin-bottom: 6px;
            display: block;
            text-decoration: none;
            line-height: 1.4;
        }

        .product-price {
            font-weight: bold;
            color: #d70018;
            font-size: 14px;
        }

        .product-old-price {
            text-decoration: line-through;
            color: #999;
            font-size: 12px;
        }

        .product-actions {
            position: absolute;
            bottom: 14px;
            left: 50%;
            transform: translateX(-50%) translateY(10px);
            opacity: 0;
            display: flex;
            gap: 8px;
            width: 85%;
            transition: all 0.3s ease;
            justify-content: space-between;
        }

        .product-card:hover .product-actions {
            transform: translateX(-50%) translateY(0);
            opacity: 1;
        }

        .product-actions .btn {
            font-size: 13px;
            padding: 6px 10px;
            flex: 1;
        }

        .badge-sale {
            position: absolute;
            top: 10px;
            left: 10px;
            background: #d70018;
            color: #fff;
            padding: 4px 8px;
            font-size: 12px;
            border-radius: 4px;
        }

        .favorite-btn {
            background: transparent;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .favorite-btn i {
            font-size: 16px;
        }

        .favorite-btn:hover i {
            color: #d70018;
        }
    </style>

    <div class="container py-5">
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

                <div class="col-lg-3 col-md-4 col-sm-6 d-flex">
                    <div class="product-card w-100 h-100">
                        @if ($discountPercent)
                            <div class="badge-sale">-{{ $discountPercent }}%</div>
                        @endif

                        <div class="product-image-wrapper">
                            <img src="{{ asset('storage/' . $product->image) }}" class="product-image"
                                alt="{{ $translation->name }}">
                            @if ($variant && $variant->image)
                                <img src="{{ asset('storage/' . $variant->image) }}" class="product-image-hover"
                                    alt="hover image">
                            @endif
                        </div>

                        <div class="product-info">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <a href="{{ route('client.products.show', $product->id) }}"
                                    class="product-title flex-grow-1">
                                    {{ $translation->name }}
                                </a>
                                <button class="btn btn-light p-1 border-0 favorite-btn" title="Yêu thích">
                                    <i class="fa-regular fa-heart text-danger"></i>
                                </button>
                            </div>

                            @if ($discountPercent)
                                <div class="product-price">{{ number_format($variant->price, 0, ',', '.') }} đ</div>
                                <div class="product-old-price">{{ number_format($product->base_price, 0, ',', '.') }} đ
                                </div>
                            @else
                                <div class="product-price">
                                    {{ number_format($variant->price ?? $product->base_price, 0, ',', '.') }} đ
                                </div>
                            @endif
                        </div>

                        <div class="product-actions">
                            <form action="{{ route('client.carts.add') }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="variant_id" value="{{ $product->variants->first()->id }}">
                                <button type="submit" class="btn btn-outline-dark btn-sm">Thêm vào giỏ</button>
                            </form>

                            <a href="{{ route('client.products.show', $product->id) }}" class="btn btn-dark btn-sm">Xem
                                thêm</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.querySelectorAll('.favorite-btn').forEach(button => {
            button.addEventListener('click', function() {
                const icon = this.querySelector('i');
                icon.classList.toggle('fa-regular');
                icon.classList.toggle('fa-solid');
            });
        });
    </script>
@endpush
