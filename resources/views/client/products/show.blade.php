@extends('layouts.master')

@section('content')
    <div class="container py-5">
        <div class="row">
            {{-- Hình ảnh --}}
            <div class="col-md-5">
                <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded"
                    alt="{{ $product->translations[0]->name }}">
            </div>

            {{-- Thông tin sản phẩm --}}
            <div class="col-md-7">
                <h2>{{ $product->translations[0]->name }}</h2>

                <p>
                    <strong>Giá:</strong>
                    @php
                        $variant = $product->variants->first();
                    @endphp
                    <span class="text-danger fw-bold">
                        {{ number_format($variant->price ?? $product->base_price, 0, ',', '.') }} đ
                    </span>
                </p>

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

                {{-- Nút thêm vào giỏ --}}
                <a href="#" class="btn btn-warning mt-3">Thêm vào giỏ</a>
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
    </script>
@endsection
