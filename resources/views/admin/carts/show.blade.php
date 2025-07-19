@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">🗑️ Thùng rác sản phẩm trong giỏ hàng #{{ $cart->id }}</h4>
        <a href="{{ route('admin.carts.index') }}" class="btn btn-secondary">← Quay lại danh sách</a>
    </div>

    <div class="mb-3">
        <a href="{{ route('admin.carts.items.trashed', $cart->id) }}" class="btn btn-outline-danger btn-sm">
            🗑️ Xem sản phẩm đã xoá
        </a>
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
                    <tr class="text-center">
                        <td>
                            @if($image)
                                <img src="{{ asset('storage/' . $image) }}" width="60" height="60" class="rounded border" style="object-fit: cover;">
                            @else
                                <span class="text-muted">Không ảnh</span>
                            @endif
                        </td>
                        <td>{{ $name }}</td>
                        <td>{{ number_format($price, 0, ',', '.') }} đ</td>
                        <td>{{ $item->quantity }}</td>
                        <td class="text-success fw-bold">{{ number_format($subtotal, 0, ',', '.') }} đ</td>
                        <td>
                            <form method="POST" action="{{ route('admin.carts.items.destroy', $item->id) }}" class="d-inline-block form-delete">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="Xoá mềm sản phẩm">
                                    🗑️ Xoá
                                </button>
                            </form>
                        </td>
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

@push('scripts')
<script>
    // Confirm xóa bằng JS thay vì confirm() thô
    document.querySelectorAll('.form-delete').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            if (confirm('❗Bạn có chắc chắn muốn xoá sản phẩm này khỏi giỏ hàng không?')) {
                form.submit();
            }
        });
    });

    // Kích hoạt tooltip Bootstrap
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
        new bootstrap.Tooltip(el);
    });
</script>
@endpush
