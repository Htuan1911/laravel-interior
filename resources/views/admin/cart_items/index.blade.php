@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h4 class="mb-3">🗑️ Thùng rác sản phẩm trong giỏ</h4>

    <table class="table table-bordered table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>Ảnh</th>
                <th>Sản phẩm</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Tạm tính</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
           @forelse($cart->items as $item)

                @php
                    $variant = $item->variant;
                    $product = $variant?->product;
                    $name = $product?->translations->first()->name ?? '---';
                    $price = $variant?->price ?? 0;
                    $image = $variant?->image ?? $product?->image;
                    $subtotal = $price * $item->quantity;
                @endphp
                <tr>
                    <td>
                        @if($image)
                            <img src="{{ asset('storage/' . $image) }}" width="60" height="60" style="object-fit:cover;" class="rounded">
                        @else
                            <span class="text-muted">Không ảnh</span>
                        @endif
                    </td>
                    <td>{{ $name }}</td>
                    <td>{{ number_format($price, 0, ',', '.') }} đ</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($subtotal, 0, ',', '.') }} đ</td>
                    <td>
                        <form method="POST" action="{{ route('admin.carts.items.restore', $item->id) }}">
                            @csrf
                            <button class="btn btn-sm btn-success">Khôi phục</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">Không có sản phẩm nào trong thùng rác.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $items->links('pagination::bootstrap-5') }}
    </div>

    <a href="{{ route('admin.carts.index') }}" class="btn btn-secondary mt-3">← Quay lại danh sách giỏ hàng</a>
</div>
@endsection
