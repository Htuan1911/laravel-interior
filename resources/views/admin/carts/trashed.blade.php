@extends('layouts.admin')

@section('content')
<h2 class="mb-3">Giỏ hàng đã xoá (Thùng rác)</h2>

<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Người dùng</th>
            <th>Trạng thái</th>
            <th>Ngày xoá</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @forelse($carts as $cart)
            <tr>
                <td>{{ $cart->id }}</td>
                <td>{{ $cart->user->name ?? 'N/A' }}<br><small>{{ $cart->user->email ?? '' }}</small></td>
                <td>{{ ucfirst($cart->status) }}</td>
                <td>{{ $cart->deleted_at->format('d/m/Y H:i') }}</td>
                <td>
                    <form action="{{ route('admin.carts.restore', $cart->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-sm btn-success">Khôi phục</button>
                    </form>
                    <form action="{{ route('admin.carts.forceDelete', $cart->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Xoá vĩnh viễn?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Xoá vĩnh viễn</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" class="text-center">Không có giỏ hàng nào đã xoá.</td></tr>
        @endforelse
    </tbody>
</table>

{{ $carts->links('pagination::bootstrap-5') }}

<a href="{{ route('admin.carts.index') }}" class="btn btn-secondary mt-3">← Quay lại</a>
@endsection
