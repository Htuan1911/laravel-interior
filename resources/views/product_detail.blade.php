@extends('layouts.master')

@section('title', $product->translation->name ?? 'Chi tiết sản phẩm')

@section('styles')
<style>
    .product-detail {
        background: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }
    .product-detail img {
        max-width: 100%;
        border-radius: 10px;
    }
</style>
@endsection

@section('content')
<div class="product-detail container">
    <div class="row">
        <div class="col-md-6">
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->translation->name ?? 'Sản phẩm' }}">
        </div>
        <div class="col-md-6">
            <h2>{{ $product->translation->name ?? 'Không có tên' }}</h2>
            <p><strong>Giá:</strong> {{ number_format($product->base_price) }} đ</p>
            <p><strong>Chất liệu:</strong> {{ $product->translation->material ?? 'Không rõ' }}</p>
            <p><strong>Phong cách:</strong> {{ $product->translation->style ?? 'Không rõ' }}</p>
            <p><strong>Bảo hành:</strong> {{ $product->warranty_months }} tháng</p>
            <p><strong>Mô tả:</strong></p>
            <div>{{ $product->translation->description ?? 'Không có mô tả' }}</div>

            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-4">
                @csrf
                <button type="submit" class="btn btn-primary">🛒 Thêm vào giỏ hàng</button>
            </form>
        </div>
    </div>
</div>
@endsection