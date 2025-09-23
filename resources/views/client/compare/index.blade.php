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
                    <li class="list-group-item fw-bold row-0">Thông tin</li>
                    <li class="list-group-item row-1">Hình ảnh</li>
                    <li class="list-group-item row-2">Tên sản phẩm</li>
                    <li class="list-group-item row-3">Giá</li>
                    <li class="list-group-item row-4">Danh mục</li>
                    <li class="list-group-item row-5">Bảo hành</li>
                    <li class="list-group-item row-6">Màu sắc</li>
                    <li class="list-group-item row-7">Chất liệu</li>
                    <li class="list-group-item row-8">Kích thước</li>
                    <li class="list-group-item row-9">Phong cách</li>
                    <li class="list-group-item row-10">Mô tả</li>
                    <li class="list-group-item row-11">Hành động</li>
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
                <ul class="list-group shadow-sm rounded-3 product-column">
                    <li class="list-group-item fw-bold text-center bg-light row-0">
                        {{ $translation->name ?? 'Sản phẩm' }}
                    </li>
                    <li class="list-group-item text-center row-1">
                        <a href="{{ route('client.products.show', $product->id) }}">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $translation->name }}"
                                class="img-fluid rounded" style="height: 120px; object-fit: contain;">
                        </a>
                    </li>
                    <li class="list-group-item text-center row-2">
                        {{ $translation->name ?? '-' }}
                    </li>
                    <li class="list-group-item text-center text-danger fw-bold row-3">
                        {{ $prices->isNotEmpty() ? $prices->map(fn($p) => number_format($p, 0, ',', '.') . '
                        ₫')->implode(' - ') : 'Liên hệ' }}
                    </li>
                    <li class="list-group-item text-center row-4">
                        {{ $product->category->translations->first()->name ?? '-' }}
                    </li>
                    <li class="list-group-item text-center row-5">
                        {{ $product->warranty_months ? $product->warranty_months . ' tháng' : 'Không bảo hành' }}
                    </li>
                    <li class="list-group-item text-center row-6">
                        {{ $product->variants->pluck('color')->filter()->unique()->implode(', ') ?? '-' }}
                    </li>
                    <li class="list-group-item text-center row-7">
                        {{ $translation->material ??
                        $product->variants->pluck('material')->filter()->unique()->implode(', ') ?? '-' }}
                    </li>
                    <li class="list-group-item text-center row-8">
                        {{ $product->dimensions ?? $product->variants->pluck('size')->filter()->unique()->implode(', ')
                        ?? '-' }}
                    </li>
                    <li class="list-group-item text-center row-9">
                        {{ $translation->style ?? '-' }}
                    </li>
                    <li class="list-group-item text-center row-10">
                        {{ Str::limit($translation->description ?? 'Không có mô tả', 80) }}
                    </li>
                    <li class="list-group-item text-center row-11">
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
    <div class="ai-suggestion-box mt-5 p-4 border rounded shadow-sm bg-white">
        <div class="d-flex align-items-center mb-3">
            <div class="ai-icon me-2">
                <i class="bi bi-robot fs-4 text-primary"></i>
            </div>
            <h5 class="fw-bold mb-0">Gợi ý từ AI</h5>
        </div>
        <div class="ai-content text-muted">
            <blockquote class="blockquote text-muted">{{ $aiSuggestion }}</blockquote>
        </div>
       
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
<style>
       .ai-suggestion-box {
        background-color: #f9f9f9;
        border-left: 4px solid #0d6efd; /* Màu xanh Bootstrap */
    }

    .ai-icon {
        width: 40px;
        height: 40px;
        background-color: #e9f0ff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .ai-content {
        font-size: 15px;
        line-height: 1.7;
        white-space: pre-line;
    }

    @media (max-width: 576px) {
        .ai-content {
            font-size: 14px;
        }
    }
   .compare-wrapper .list-group-item {
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 0.75rem;
    border: 1px solid #dee2e6;
}
</style>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const maxRow = 12; // từ row-0 đến row-11
        for (let i = 0; i < maxRow; i++) {
            const items = document.querySelectorAll(`.row-${i}`);
            let maxHeight = 0;

            items.forEach(item => {
                item.style.height = "auto"; // reset lại height
                if (item.offsetHeight > maxHeight) {
                    maxHeight = item.offsetHeight;
                }
            });

            items.forEach(item => {
                item.style.height = maxHeight + "px";
            });
        }
    });
</script>

@endsection