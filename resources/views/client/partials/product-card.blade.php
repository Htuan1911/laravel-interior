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

<div class="col">
    <div class="card h-100 border-0 shadow-sm">
        @if ($discountPercent)
            <div class="badge bg-warning text-dark position-absolute top-0 end-0 m-2">-{{ $discountPercent }}%</div>
        @endif

        <div class="product-image-wrapper">
            <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $translation->name }}" style="height: 200px; object-fit: cover;">
            @if ($variant && $variant->image)
                <img src="{{ asset('storage/' . $variant->image) }}" class="card-img-top d-none" alt="hover image" style="height: 200px; object-fit: cover;" id="hover-{{ $product->id }}">
            @endif
        </div>

        <div class="card-body text-center">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <a href="{{ route('client.products.show', $product->id) }}" class="product-title flex-grow-1 text-decoration-none text-dark">
                    {{ $translation->name }}
                </a>
                <button class="btn btn-light p-1 border-0 favorite-btn" title="Yêu thích">
                    <i class="fa-regular fa-heart text-danger"></i>
                </button>
            </div>

            @if ($discountPercent)
                <div class="product-price mb-1">{{ number_format($variant->price, 0, ',', '.') }} đ</div>
                <div class="product-old-price text-muted text-decoration-line-through mb-2">{{ number_format($product->base_price, 0, ',', '.') }} đ</div>
            @else
                <div class="product-price mb-2">{{ number_format($variant->price ?? $product->base_price, 0, ',', '.') }} đ</div>
            @endif
        </div>

        <div class="card-footer bg-transparent border-0 p-3">
            <div class="d-flex gap-2">
                <form action="{{ route('client.carts.add') }}" method="POST" class="flex-grow-1">
                    @csrf
                    <input type="hidden" name="variant_id" value="{{ $product->variants->first()->id }}">
                    <button type="submit" class="btn btn-outline-dark btn-sm w-100">Thêm vào giỏ</button>
                </form>
                <a href="{{ route('client.products.show', $product->id) }}" class="btn btn-dark btn-sm w-100">Xem thêm</a>
            </div>
        </div>
    </div>
</div>

<style>
    .card-img-top {
        transition: transform 0.3s ease;
    }
    .card:hover .card-img-top {
        transform: scale(1.05);
    }
    .product-image-wrapper {
        position: relative;
        overflow: hidden;
    }
    .product-image-hover {
        position: absolute;
        top: 0;
        left: 0;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .card:hover .product-image-hover {
        opacity: 1;
    }
    @media (max-width: 768px) {
        .card-img-top {
            height: 150px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.card');
        cards.forEach(card => {
            card.addEventListener('mouseover', () => {
                const hoverImg = card.querySelector('.product-image-hover');
                if (hoverImg) hoverImg.classList.remove('d-none');
            });
            card.addEventListener('mouseout', () => {
                const hoverImg = card.querySelector('.product-image-hover');
                if (hoverImg) hoverImg.classList.add('d-none');
            });
        });
    });
</script>