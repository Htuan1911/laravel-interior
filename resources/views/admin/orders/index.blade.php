@extends('layouts.admin')
@section('title', 'Danh sách đơn hàng')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Danh sách đơn hàng</h4>
        <a href="{{ route('admin.orders.create') }}" class="btn btn-success">+ Thêm mới</a>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Người dùng</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->user->name ?? 'N/A' }}</td>
                    <td>{{ number_format($order->total, 0, ',', '.') }} đ</td>
                    <td>{{ $order->status }}</td>
                    <td class="d-flex justify-content-center gap-1">
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-info">Xem</a>
                        <a href="{{ route('admin.orders.editStatus', $order->id) }}" class="btn btn-sm btn-warning">Trạng thái</a>
                        <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Xóa</button>
                        </form>
                    </td>
                </tr>
                @endforeach

                @if ($orders->isEmpty())
                <tr>
                    <td colspan="5">Không có đơn hàng nào.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
