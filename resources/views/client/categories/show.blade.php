@extends('layouts.master')

@section('content')
<div class="container py-4">
    <h3 class="mb-4 text-primary">Danh mục: {{ $category->name }}</h3>

    <div class="row row-cols-1 row-cols-md-4 g-4">
        @foreach ($products as $product)
            @include('client.partials.product-card', ['product' => $product])
        @endforeach
        @if ($products->isEmpty())
            <p class="text-muted">Không có sản phẩm nào trong danh mục này.</p>
        @endif
    </div>
</div>
@endsection