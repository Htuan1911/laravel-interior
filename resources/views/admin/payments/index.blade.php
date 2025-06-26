@extends('layouts.admin')

@section('title', 'Danh sách thanh toán')

@section('content')
    <h1>Danh sách thanh toán</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
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
            @foreach ($payments as $payment)
                <tr>
                    <td>{{ $payment->id }}</td>
                    <td>{{ $payment->user->name ?? 'Không rõ' }}</td>
                    <td>#{{ $payment->order->id ?? 'Không rõ' }}</td>
                    <td>{{ number_format($payment->amount, 0, ',', '.') }}₫</td>
                    <td>{{ strtoupper($payment->method) }}</td>
                    <td>{{ ucfirst($payment->status) }}</td>
                    <td>{{ $payment->paid_at ?? 'Chưa thanh toán' }}</td>
                    <td>
                        <a href="{{ route('admin.payments.show', $payment->id) }}" class="btn btn-sm btn-info">Xem</a>
                        <a href="{{ route('admin.payments.edit', $payment->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
