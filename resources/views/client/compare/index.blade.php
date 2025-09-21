@extends('layouts.show')

@section('content-dead')
<div class="container py-5">
    <h2 class="text-center fw-bold mb-3">🔍 So sánh sản phẩm</h2>
    <p class="text-center text-muted mb-4">Chọn ra sản phẩm phù hợp nhất dựa trên các tiêu chí quan trọng.</p>

    {{-- Thông báo --}}
    @if (session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif

    @if($products->isEmpty())
        <div class="alert alert-warning text-center">
            <p>Chưa có sản phẩm nào trong danh sách so sánh.</p>
            <a href="{{ url('/') }}" class="btn btn-primary mt-3">Quay lại mua sắm</a>
        </div>
    @else
        {{-- Hiển thị danh sách so sánh --}}
        <div class="compare-wrapper table-responsive">
            <div class="row gx-3">
                {{-- Tiêu chí --}}
                <div class="col-md-2 col-12 mb-3">
                    <ul class="list-group shadow-sm sticky-top bg-white rounded-3">
                        <li class="list-group-item fw-bold">Thông tin</li>
                        <li class="list-group-item">Hình ảnh</li>
                        <li class="list-group-item">Tên sản phẩm</li>
                        <li class="list-group-item">Giá</li>
                        <li class="list-group-item">Danh mục</li>
                        <li class="list-group-item">Bảo hành</li>
                        <li class="list-group-item">Màu sắc</li>
                        <li class="list-group-item">Chất liệu</li>
                        <li class="list-group-item">Kích thước</li>
                        <li class="list-group-item">Phong cách</li>
                        <li class="list-group-item">Mô tả</li>
                        <li class="list-group-item">Hành động</li>
                    </ul>
                </div>

                {{-- Danh sách sản phẩm --}}
                @foreach ($products as $product)
                    @php
                        $translation = $product->translations->first();
                        $variant = $product->variants->first();
                        $prices = $product->variants->pluck('price')->filter()->unique()->sort();
                    @endphp
                    <div class="col-md col-6 mb-3">
                        <ul class="list-group shadow-sm rounded-3">
                            <li class="list-group-item fw-bold text-center bg-light">
                                {{ $translation->name ?? 'Sản phẩm' }}
                            </li>
                            <li class="list-group-item text-center">
                                <a href="{{ route('client.products.show', $product->id) }}">
                                    <img src="{{ asset('storage/' . $product->image) }}"
                                         alt="{{ $translation->name }}"
                                         class="img-fluid rounded"
                                         style="height: 120px; object-fit: contain;">
                                </a>
                            </li>
                            <li class="list-group-item text-center">
                                {{ $translation->name ?? '-' }}
                            </li>
                            <li class="list-group-item text-center text-danger fw-bold">
                                {{ $prices->isNotEmpty() ? $prices->map(fn($p) => number_format($p, 0, ',', '.') . ' ₫')->implode(' - ') : 'Liên hệ' }}
                            </li>
                            <li class="list-group-item text-center">
                                {{ $product->category->translations->first()->name ?? '-' }}
                            </li>
                            <li class="list-group-item text-center">
                                {{ $product->warranty_months ? $product->warranty_months . ' tháng' : 'Không bảo hành' }}
                            </li>
                            <li class="list-group-item text-center">
                                {{ $product->variants->pluck('color')->filter()->unique()->implode(', ') ?? '-' }}
                            </li>
                            <li class="list-group-item text-center">
                                {{ $translation->material ?? $product->variants->pluck('material')->filter()->unique()->implode(', ') ?? '-' }}
                            </li>
                            <li class="list-group-item text-center">
                                {{ $product->dimensions ?? $product->variants->pluck('size')->filter()->unique()->implode(', ') ?? '-' }}
                            </li>
                            <li class="list-group-item text-center">
                                {{ $translation->style ?? '-' }}
                            </li>
                            <li class="list-group-item text-center">
                                {{ Str::limit($translation->description ?? 'Không có mô tả', 80) }}
                            </li>
                            <li class="list-group-item text-center">
                                <form action="{{ route('client.compare.remove', $product->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-danger btn-sm">Xóa</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Gợi ý AI --}}
        @if(isset($aiSuggestion))
            <div class="mt-4 p-4 bg-light border rounded shadow-sm">
                <h5 class="fw-bold mb-2"><i class="bi bi-robot"></i> Gợi ý từ AI</h5>
                <blockquote class="blockquote text-muted">{{ $aiSuggestion }}</blockquote>
            </div>
        @endif

        {{-- Hành động --}}
        <div class="mt-5 text-center">
            <form action="{{ route('client.compare.clear') }}" method="POST" class="d-inline-block me-2">
                @csrf
                <button type="submit" class="btn btn-outline-warning">
                    <i class="bi bi-trash"></i> Xóa toàn bộ
                </button>
            </form>
            <a href="{{ url('/') }}" class="btn btn-outline-secondary me-2">
                <i class="bi bi-arrow-left"></i> Về trang chủ
            </a>
            <a href="{{ url('/client/products') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> Thêm sản phẩm
            </a>
        </div>
    @endif
</div>
@endsection