@extends('layouts.admin')

@section('title', 'Danh sách thanh toán')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3">Danh sách thanh toán</h1>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover table-bordered align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Người dùng</th>
                        <th>Đơn hàng</th>
                        <th>Số tiền</th>
                        <th>Phương thức</th>
                        <th>Trạng thái</th>
                        <th>Thời gian thanh toán</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($payments as $payment)
                        <tr>
                            <td>{{ $payment->id }}</td>
                            <td>{{ $payment->user->name ?? 'Không rõ' }}</td>
                            <td>
                                @if ($payment->order)
                                    <a href="{{ route('admin.orders.show', $payment->order->id) }}" target="_blank">
                                        #{{ $payment->order->id }}
                                    </a>
                                @else
                                    <span class="text-muted">Không rõ</span>
                                @endif
                            </td>
                            <td class="text-end text-primary">
                                {{ number_format($payment->amount, 0, ',', '.') }}₫
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ strtoupper($payment->method) }}</span>
                            </td>
                            <td>
                                @php
                                    $badgeClass = match($payment->status) {
                                        'pending' => 'warning',
                                        'completed' => 'success',
                                        'failed' => 'danger',
                                        default => 'secondary'
                                    };
                                @endphp
                                <span class="badge bg-{{ $badgeClass }}">{{ ucfirst($payment->status) }}</span>
                            </td>
                            <td>
                                {{ $payment->paid_at ? \Carbon\Carbon::parse($payment->paid_at)->format('d/m/Y H:i') : 'Chưa thanh toán' }}
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.payments.show', $payment->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.payments.edit', $payment->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">Không có dữ liệu thanh toán.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
