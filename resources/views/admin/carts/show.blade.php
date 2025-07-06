@extends('layouts.admin')

@section('content')
<h2 class="mb-3">Chi tiết giỏ hàng #{{ $cart->id }}</h2>

<div class="mb-3">
    <p><strong>Người dùng:</strong> {{ $cart->user->name ?? 'N/A' }} - {{ $cart->user->email ?? '' }}</p>
    <p><strong>Trạng thái hiện tại:</strong> {{ ucfirst($cart->status) }}</p>
</div>

<form method="POST" action="{{ route('admin.carts.updateStatus', $cart->id) }}" class="row g-3 mb-4">
    @csrf @method('PUT')
    <div class="col-md-4">
        <select name="status" class="form-select">
            <option value="pending" {{ $cart->status == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="ordered" {{ $cart->status == 'ordered' ? 'selected' : '' }}>Ordered</option>
            <option value="abandoned" {{ $cart->status == 'abandoned' ? 'selected' : '' }}>Abandoned</option>
        </select>
    </div>
    <div class="col-md-2">
        <button class="btn btn-primary">Cập nhật</button>
    </div>
</form>

<h5>Sản phẩm trong giỏ:</h5>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Sản phẩm</th>
            <th>Biến thể</th>
            <th>Số lượng</th>
            <th>Giá</th>
        </tr>
    </thead>
    <tbody>
        @forelse($cart->items as $item)
            <tr>
                <td>{{ $item->variant->product->name ?? 'N/A' }}</td>
                <td>{{ $item->variant->name ?? 'Không rõ' }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->price) }} đ</td>
            </tr>
        @empty
            <tr><td colspan="4" class="text-center">Không có sản phẩm.</td></tr>
        @endforelse
    </tbody>
</table>

<a href="{{ route('admin.carts.index') }}" class="btn btn-secondary mt-3">← Quay lại</a>
@endsection
