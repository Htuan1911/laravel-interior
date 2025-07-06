@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Chi tiết giỏ hàng #{{ $cart->id }}</h4>
        </div>
        <div class="card-body">
            <p><strong>Người dùng:</strong> {{ $cart->user->name }} ({{ $cart->user->email }})</p>
            <p><strong>Trạng thái:</strong>
                <span class="badge bg-{{ $cart->status === 'ordered' ? 'success' : ($cart->status === 'pending' ? 'warning' : 'secondary') }}">
                    {{ ucfirst($cart->status) }}
                </span>
            </p>
            <p><strong>Tổng tiền:</strong> {{ number_format($cart->totalAmount(), 0, ',', '.') }}đ</p>

            <div class="table-responsive mt-4">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Biến thể</th>
                            <th>Số lượng</th>
                            <th>Đơn giá</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cart->items as $item)
                        <tr>
                            <td>{{ $item->product->name ?? 'Không có sản phẩm' }}</td>
                            <td>{{ $item->variant->variant_name ?? 'Không rõ' }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->price, 0, ',', '.') }}đ</td>
                            <td>{{ number_format($item->price * $item->quantity, 0, ',', '.') }}đ</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <a href="{{ route('admin.carts.index') }}" class="btn btn-secondary mt-3">
                <i class="bi bi-arrow-left"></i> Quay lại danh sách
            </a>
        </div>
    </div>
</div>
@endsection
