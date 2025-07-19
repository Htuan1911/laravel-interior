@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <h4 class="mb-3">🗑️ Danh sách sản phẩm đã xoá khỏi giỏ hàng #{{ $cart->id }}</h4>

    @if($items->count())
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Ảnh</th>
                    <th>Sản phẩm</th>
                    <th>Người dùng</th>
                    <th>Ngày xoá</th>
                    <th class="text-center">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                    @php
                        $variant = $item->variant;
                        $product = $variant?->product;
                        $name = $product?->translations->first()?->name ?? '---';
                        $image = $variant?->image ?? $product?->image;
                        $deleted_at = $item->deleted_at?->format('d/m/Y H:i') ?? '---';
                    @endphp
                    <tr>
                        <td>
                            @if($image)
                                <img src="{{ asset('storage/' . $image) }}" width="60" height="60" class="rounded" style="object-fit: cover;">
                            @else
                                <span class="text-muted">Không ảnh</span>
                            @endif
                        </td>
                        <td>{{ $name }}</td>
                        <td><strong>{{ $cart->user->name ?? 'N/A' }}</strong></td>
                        <td>{{ $deleted_at }}</td>
                        <td class="text-center">
                            <div class="d-flex gap-2 justify-content-center">
                                {{-- Nút khôi phục --}}
                                <form action="{{ route('admin.carts.items.restore', $item->id) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-success btn-sm">♻️ Khôi phục</button>
                                </form>

                                {{-- Nút xoá vĩnh viễn --}}
                                <form action="{{ route('admin.carts.items.forceDelete', $item->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xoá vĩnh viễn sản phẩm này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">🗑️ Xoá vĩnh viễn</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-center">
            {{ $items->links('pagination::bootstrap-5') }}
        </div>
    @else
        <div class="alert alert-warning">Không có sản phẩm nào trong thùng rác.</div>
    @endif

    <a href="{{ route('admin.carts.show', $cart->id) }}" class="btn btn-secondary mt-3">
        ← Quay lại chi tiết giỏ hàng
    </a>
</div>
@endsection
