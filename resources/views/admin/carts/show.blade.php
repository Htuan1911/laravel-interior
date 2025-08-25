@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Chi tiết giỏ hàng</h4>
        <a href="{{ route('admin.carts.index') }}" class="btn btn-secondary">← Quay lại danh sách</a>
    </div>

    <div class="table-responsive shadow-sm border rounded">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light text-center">
                <tr>
                    <th>Ảnh</th>
                    <th>Sản phẩm</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Tạm tính</th>

                </tr>
            </thead>
            <tbody>
               @forelse($items as $item)
    @php
        $variant = $item->variant;
        $product = $variant?->product;
        $name = $product?->translations->first()->name ?? '---';
        $price = $variant?->price ?? 0;
        $image = $variant?->image ?? $product?->image;
        $subtotal = $price * $item->quantity;
    @endphp
    <tr class="text-center">
        <td>
            @if($image)
                <img src="{{ asset('storage/' . $image) }}" width="60" height="60" class="rounded border" style="object-fit: cover;">
            @else
                <span class="text-muted">Không ảnh</span>
            @endif
        </td>
        <td>
            <strong>{{ $name }}</strong>
            @if($variant)
                <div class="text-muted small">
                    Biến thể:
                    @php
                        $variantInfo = [];
                        if (!empty($variant->color)) $variantInfo[] = 'Màu: '.$variant->color;
                        if (!empty($variant->size)) $variantInfo[] = 'Size: '.$variant->size;
                        if (!empty($variant->material)) $variantInfo[] = 'Chất liệu: '.$variant->material;
                        if (!empty($variant->style)) $variantInfo[] = 'Kiểu dáng: '.$variant->style;
                    @endphp
                    {{ implode(' | ', $variantInfo) }}
                </div>
            @endif
        </td>
        <td>{{ number_format($price, 0, ',', '.') }} đ</td>
        <td>{{ $item->quantity }}</td>
        <td class="text-success fw-bold">{{ number_format($subtotal, 0, ',', '.') }} đ</td>
    </tr>
@empty
    <tr>
        <td colspan="6" class="text-center text-muted py-4">
            <i class="bi bi-cart-x fs-3"></i><br>
            Không có sản phẩm nào trong giỏ hàng.
        </td>
    </tr>
@endforelse

            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $items->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection

