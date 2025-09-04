@extends('layouts.cart')

@section('cart-content')
<div class="container py-4">
    <h3 class="mb-4">💖 Sản phẩm yêu thích</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        @forelse ($wishlists as $item)
            @php
                $product = $item->product;
                $name = $product?->translations->first()?->name ?? '---';
                $variant = $product->variants->first();
                $price = $variant?->price ?? $product?->price ?? 0;
                $image = $variant?->image ?? $product?->image;
            @endphp

            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="{{ $image ? asset('storage/' . $image) : 'https://via.placeholder.com/300x200?text=No+Image' }}" class="card-img-top" style="height: 220px; object-fit: cover;">

                    <div class="card-body d-flex flex-column justify-content-between">
                        <h5 class="card-title">{{ $name }}</h5>
                        <p class="card-text fw-bold text-danger">{{ number_format($price, 0, ',', '.') }} ₫</p>

                        <div class="d-flex justify-content-between">
                            <form action="{{ route('client.wishlist.toggle', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    ❌ Bỏ yêu thích
                                </button>
                            </form>

                            <form action="{{ route('client.carts.add') }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="variant_id" value="{{ $product->variants->first()->id }}">
                                <button type="submit" class="btn btn-outline-dark btn-sm">Thêm vào giỏ</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <p class="text-muted">Bạn chưa có sản phẩm yêu thích nào.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
