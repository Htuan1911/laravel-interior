@extends('layouts.admin')

@section('title', 'Danh sách đơn hàng')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="h3 mb-0">Danh sách đơn hàng</h1>
            <a href="{{ route('admin.orders.create') }}" class="btn btn-success">
                <i class="fas fa-plus-circle me-1"></i> Thêm đơn hàng mới
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                @if ($orders->count())
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle text-center">
                            <thead class="table-dark">
                                <tr>
                                    <th style="width: 60px;">ID</th>
                                    <th>Người dùng</th>
                                    <th>Tổng tiền</th>
                                    <th style="width: 130px;">Trạng thái</th>
                                    <th style="width: 160px;">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>#{{ $order->id }}</td>
                                        <td>{{ $order->user->name ?? 'Không rõ' }}</td>
                                        <td>{{ number_format($order->total, 0, ',', '.') }}₫</td>
                                        <td>
                                            @php
                                                $status = $order->status;
                                                $badgeClass = match ($status) {
                                                    'pending' => 'secondary',
                                                    'processing' => 'warning',
                                                    'completed' => 'success',
                                                    'cancelled' => 'danger',
                                                    default => 'dark',
                                                };
                                            @endphp
                                            <span class="badge bg-{{ $badgeClass }}">{{ ucfirst($status) }}</span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.orders.show', $order->id) }}"
                                                   class="btn btn-sm btn-info" title="Xem chi tiết">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.orders.editStatus', $order->id) }}"
                                                   class="btn btn-sm btn-warning" title="Cập nhật trạng thái">
                                                    <i class="fas fa-sync-alt"></i>
                                                </a>
                                                <form action="{{ route('admin.orders.destroy', $order->id) }}"
                                                      method="POST" class="d-inline-block"
                                                      onsubmit="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Xoá">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info mb-0">Chưa có đơn hàng nào.</div>
                @endif
            </div>
        </div>
    </div>
@endsection
