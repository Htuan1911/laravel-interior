@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">🛒 Danh sách giỏ hàng</h4>
    </div>

   <form method="GET" class="row g-2 mb-4">
    <div class="col-md-4">
        <input type="text" name="search" class="form-control" placeholder="Tìm tên hoặc email"
            value="{{ request('search') }}">
    </div>
    <div class="col-md-2 d-flex gap-2">
        <button class="btn btn-primary">Lọc</button>
        @if(request('search'))
            <a href="{{ route('admin.carts.index') }}" class="btn btn-secondary">Quay lại</a>
        @endif
    </div>
</form>

    @forelse($carts as $cart)
        <form class="mb-4 p-3 border rounded shadow-sm bg-white" method="POST" action="{{ route('admin.carts.destroy', $cart->id) }}" onsubmit="return confirm('Bạn có chắc chắn muốn xoá?')">
            @csrf
            @method('DELETE')

            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-1">🧾 Giỏ hàng #{{ $cart->id }} - <span class="badge bg-info text-dark">{{ ucfirst($cart->status) }}</span></h6>
                    <p class="mb-1">👤 <strong>{{ $cart->user->name ?? 'N/A' }}</strong> ({{ $cart->user->email ?? '---' }})</p>
                    <small class="text-muted">📅 {{ $cart->created_at->format('d/m/Y H:i') }}</small>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.carts.show', $cart->id) }}" class="btn btn-outline-primary btn-sm">Xem</a>

                </div>
            </div>
        </form>
    @empty
        <div class="alert alert-warning">Không có giỏ hàng nào.</div>
    @endforelse

    <div class="d-flex justify-content-center mt-4">
        {{ $carts->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
