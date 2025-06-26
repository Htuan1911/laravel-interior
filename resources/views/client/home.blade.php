@extends('layouts.master')

@section('title', 'Trang chủ')

@section('content')
    <h1 class="mb-4">Sản phẩm mới nhất</h1>
    <div class="row">
        @foreach ($products as $product)
            <div class="col-md-3 mb-4">
                <div class="product-card">
                    <img src="{{ $product->image_url }}" class="img-fluid mb-2" alt="{{ $product->name }}">
                    <h5>{{ $product->name }}</h5>
                    <p>{{ number_format($product->price) }} đ</p>
                    <a href="#" class="btn btn-cta btn-sm">Xem chi tiết</a>
                </div>
            </div>
        @endforeach
    </div>
@endsection
