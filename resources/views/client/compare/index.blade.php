@extends('layouts.show')

@section('content-dead')
<div class="container my-5">
    <h2 class="mb-4 text-center fw-bold">So sánh sản phẩm</h2>
    <p class="text-center mb-4">Bạn có thể so sánh các sản phẩm để tìm ra lựa chọn tốt nhất cho mình.</p>

    {{-- Breadcrumb --}}
    {{-- Thông báo session --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($products->isEmpty())
        <div class="alert alert-warning text-center">
            Chưa có sản phẩm nào trong danh sách so sánh.
            <br>
            <a href="{{ url('/') }}" class="btn btn-primary mt-3">Quay lại mua sắm</a>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-compare text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="text-start">Sản phẩm</th>
                        @foreach ($products as $product)
                            @php
                                $translation = $product->translations->first();
                                $firstVariant = $product->variants->first();
                            @endphp
                            <td>
                                <div class="compare-product-card">
                                    <a href="{{ route('client.products.show', $product->id) }}">
                                        <img class="img-fluid mb-2"
                                             style="height: 150px; object-fit: contain;"
                                             src="{{ asset('storage/' . $product->image) }}"
                                             alt="{{ $translation->name ?? 'Sản phẩm' }}">
                                    </a>
                                    <h5>{{ $translation->name ?? 'Sản phẩm' }}</h5>
                                    <p class="text-danger fw-bold">
                                        @php
                                            $prices = $product->variants->pluck('price')->filter()->unique()->sort();
                                        @endphp
                                        {{ $prices->isNotEmpty() ? $prices->implode(' - ') . ' đ' : 'Liên hệ' }}
                                    </p>
                                    <a href="{{ route('client.products.show', $product->id) }}" class="btn btn-success btn-sm">
                                        <i class="bi bi-eye"></i> Xem chi tiết
                                    </a>
                                </div>
                            </td>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th class="text-start">Danh mục</th>
                        @foreach ($products as $product)
                            <td>{{ $product->category->translations->first()->name ?? '-' }}</td>
                        @endforeach
                    </tr>

                    <tr>
                        <th class="text-start">Bảo hành</th>
                        @foreach ($products as $product)
                            <td>{{ $product->warranty_months ? $product->warranty_months . ' tháng' : 'Không bảo hành' }}</td>
                        @endforeach
                    </tr>

                    <tr>
                        <th class="text-start">Màu sắc</th>
                        @foreach ($products as $product)
                            <td>{{ $product->variants->pluck('color')->filter()->unique()->implode(', ') ?? '-' }}</td>
                        @endforeach
                    </tr>

                    <tr>
                        <th class="text-start">Chất liệu</th>
                        @foreach ($products as $product)
                            <td>
                                {{ $product->translations->first()->material ?? $product->variants->pluck('material')->filter()->unique()->implode(', ') ?? '-' }}
                            </td>
                        @endforeach
                    </tr>

                    <tr>
                        <th class="text-start">Kích thước</th>
                        @foreach ($products as $product)
                            <td>{{ $product->dimensions ?? $product->variants->pluck('size')->filter()->unique()->implode(', ') ?? '-' }}</td>
                        @endforeach
                    </tr>

                    <tr>
                        <th class="text-start">Phong cách</th>
                        @foreach ($products as $product)
                            <td>{{ $product->translations->first()->style ?? '-' }}</td>
                        @endforeach
                    </tr>

                    <tr>
                        <th class="text-start">Mô tả</th>
                        @foreach ($products as $product)
                            <td>{{ Str::limit($product->translations->first()->description ?? 'Không có mô tả', 100) }}</td>
                        @endforeach
                    </tr>

                    <tr>
                        <th class="text-start">Hành động</th>
                        @foreach ($products as $product)
                            <td>
                                <form action="{{ route('client.compare.remove', $product->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                                </form>
                            </td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Gợi ý từ AI --}}
        @if(isset($aiSuggestion))
            <div class="ai-suggestion mt-4 p-4 rounded" style="background-color: #e9f7fb; border: 1px solid #cce5ff;">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-robot"></i> Gợi ý từ hệ thống AI
                </h5>
                <blockquote class="blockquote mb-0" style="font-size: 1rem; color: #333;">
                    {{ $aiSuggestion }}
                </blockquote>
            </div>
        @endif

        {{-- Nút hành động --}}
        <div class="mt-4 text-center">
            <form action="{{ route('client.compare.clear') }}" method="POST" class="d-inline-block">
                @csrf
                <button type="submit" class="btn btn-warning">
                    <i class="bi bi-trash"></i> Xóa toàn bộ
                </button>
            </form>
            <a href="{{ url('/') }}" class="btn btn-dark ms-2">
                <i class="bi bi-arrow-left"></i> Về trang chủ
            </a>
            <a href="{{ url('/client/products') }}" class="btn btn-success">
                <i class="fa fa-balance-scale"></i> Thêm sản phẩm so sánh
            </a>
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .table-compare th {
        width: 180px;
        background-color: #f8f9fa;
        font-weight: bold;
    }
    .compare-product-card img {
        border-radius: 8px;
        object-fit: contain;
    }
    .ai-suggestion blockquote {
        border-left: 5px solid #007bff;
        padding-left: 10px;
        font-style: italic;
    }
</style>
@endpush
