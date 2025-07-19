@extends('layouts.master')

@section('content')
    <div class="container py-5">
        <div class="row">
            {{-- Hình ảnh --}}
            <div class="col-md-5">
                @php
                    $variant = $product->variants->first();
                @endphp

                {{-- Ảnh chính --}}
                <div class="mb-3">
                    <img id="main-image" src="{{ asset('storage/' . ($variant->image ?? $product->image)) }}"
                        class="img-fluid rounded w-100" style="object-fit: contain; max-height: 400px;"
                        alt="{{ $product->translations[0]->name }}">
                </div>

                {{-- Ảnh biến thể --}}
                @if ($product->variants->count() > 1)
                    <div class="d-flex flex-wrap gap-2">
                        @foreach ($product->variants as $v)
                            @if ($v->image)
                                <img src="{{ asset('storage/' . $v->image) }}" class="img-thumbnail"
                                    style="width: 80px; height: 80px; object-fit: cover; cursor: pointer;"
                                    alt="{{ $v->variant_name }}"
                                    onclick="document.getElementById('main-image').src = this.src">
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Thông tin sản phẩm --}}
            <div class="col-md-7">
                <h2>{{ $product->translations[0]->name }}</h2>

                {{-- Nút yêu thích (tùy chọn) --}}
                @auth
    <form action="{{ route('client.wishlist.toggle', $product->id) }}" method="POST" class="d-inline">
        @csrf
        <button type="submit" class="btn btn-link p-0 float-end favorite-btn" title="Yêu thích">
            <i class="fa{{ auth()->user()->wishlists->contains('product_id', $product->id) ? 's' : '-regular' }} fa-heart text-danger fs-4"></i>
        </button>
    </form>
@else
    <a href="{{ route('login') }}" class="btn btn-link p-0 float-end favorite-btn" title="Đăng nhập để yêu thích">
        <i class="fa-regular fa-heart text-danger fs-4"></i>
    </a>
@endauth


                <p>
                    <strong>Giá:</strong>
                    <span class="text-danger fw-bold">
                        {{ number_format($variant->price ?? $product->base_price, 0, ',', '.') }} đ
                    </span>
                </p>

                <p><strong>Vật liệu:</strong> {{ $variant->material ?? 'Đang cập nhật' }}</p>
                <p><strong>Kích thước:</strong> {{ $variant->size ?? 'Đang cập nhật' }}</p>

                <p>
                    <strong>Danh mục:</strong>
                    {{ $product->category->translations[0]->name ?? '---' }}
                </p>

                {{-- Mô tả có rút gọn --}}
                <p><strong>Mô tả:</strong></p>
                <div id="short-description">
                    {!! \Illuminate\Support\Str::limit(
                        strip_tags($product->translations[0]->description ?? 'Chưa có mô tả'),
                        150,
                        '...',
                    ) !!}
                </div>

                <div id="full-description" style="display: none;">
                    {!! nl2br($product->translations[0]->description ?? 'Chưa có mô tả') !!}
                </div>

                <button id="toggle-description" class="btn btn-link px-0 text-decoration-none">Xem thêm</button>

                <div class="mt-4 d-flex align-items-center gap-3">
                    {{-- Tăng giảm số lượng --}}
                    <div class="d-flex align-items-center gap-2">
                        <button class="btn btn-outline-secondary" type="button" onclick="decreaseQty()">−</button>
                        <span id="display-qty" class="px-3 fw-bold fs-5">1</span>
                        <button class="btn btn-outline-secondary" type="button" onclick="increaseQty()">+</button>
                    </div>

                    {{-- Mua ngay --}}
                    <form action="{{ route('client.carts.add') }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="variant_id" value="{{ $variant->id }}">
                        <input type="hidden" name="quantity" id="buy-now-qty" value="1">
                        <button type="submit" class="btn btn-danger">Mua ngay</button>
                    </form>

                    {{-- Thêm vào giỏ --}}
                    <form action="{{ route('client.carts.add') }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="variant_id" value="{{ $variant->id }}">
                        <input type="hidden" name="quantity" id="add-cart-qty" value="1">
                        <button type="submit" class="btn btn-outline-dark">Thêm vào giỏ</button>
                    </form>
                </div>


            </div>
        </div>
    </div>

    {{-- Sản phẩm cùng danh mục --}}
    @if ($relatedProducts->count())
        <hr class="my-5">
        <h4 class="mb-4">Sản phẩm cùng danh mục</h4>
        <div class="row">
            @foreach ($relatedProducts as $item)
                @php
                    $translation = $item->translations->first();
                    $variant = $item->variants->first();
                @endphp
                <div class="col-md-3">
                    <div class="card h-100">
                        <a href="{{ route('client.products.show', $item->id) }}">
                            <img src="{{ asset('storage/' . $item->image) }}" class="card-img-top"
                                style="height: 180px; object-fit: cover;" alt="{{ $translation->name }}">
                        </a>
                        <div class="card-body">
                            <h6 class="card-title">
                                <a href="{{ route('client.products.show', $item->id) }}"
                                    class="text-decoration-none text-dark">
                                    {{ $translation->name }}
                                </a>
                            </h6>
                            <p class="text-danger fw-bold mb-0">
                                {{ number_format($variant->price ?? $item->base_price, 0, ',', '.') }} đ
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    {{-- Script Xem thêm / Thu gọn --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('toggle-description');
            const shortDesc = document.getElementById('short-description');
            const fullDesc = document.getElementById('full-description');
            let expanded = false;

            btn.addEventListener('click', function() {
                expanded = !expanded;
                if (expanded) {
                    shortDesc.style.display = 'none';
                    fullDesc.style.display = 'block';
                    btn.textContent = 'Thu gọn';
                } else {
                    shortDesc.style.display = 'block';
                    fullDesc.style.display = 'none';
                    btn.textContent = 'Xem thêm';
                }
            });
        });

        let quantity = 1;

        function increaseQty() {
            quantity++;
            updateQtyDisplay();
        }

        function decreaseQty() {
            quantity = Math.max(1, quantity - 1);
            updateQtyDisplay();
        }

        function updateQtyDisplay() {
            document.getElementById('display-qty').textContent = quantity;
            document.getElementById('buy-now-qty').value = quantity;
            document.getElementById('add-cart-qty').value = quantity;
        }

        // Khởi tạo khi DOM sẵn sàng
        document.addEventListener('DOMContentLoaded', () => {
            updateQtyDisplay();
        });
    </script>
@endsection
