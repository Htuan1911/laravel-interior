@extends('layouts.admin')

@section('title', 'Chi tiết thanh toán')

@section('content')
    <h1>Chi tiết thanh toán #{{ $payment->id }}</h1>

    <table class="table table-bordered">
        <tr>
            <th>Người dùng</th>
            <td>{{ $payment->user->name ?? 'Không rõ' }}</td>
        </tr>
        <tr>
            <th>Đơn hàng</th>
            <td>#{{ $payment->order->id ?? 'Không rõ' }}</td>
        </tr>
        <tr>
            <th>Số tiền</th>
            <td>{{ number_format($payment->amount, 0, ',', '.') }}₫</td>
        </tr>
        <tr>
            <th>Phương thức</th>
            <td>{{ strtoupper($payment->method) }}</td>
        </tr>
        <tr>
            <th>Trạng thái</th>
            <td>{{ ucfirst($payment->status) }}</td>
        </tr>
        <tr>
            <th>Thời gian thanh toán</th>
            <td>{{ $payment->paid_at ?? 'Chưa thanh toán' }}</td>
        </tr>
        <tr>
            <th>Mã giao dịch</th>
            <td>{{ $payment->transaction_code ?? 'Không có' }}</td>
        </tr>
    </table>

    <a href="{{ route('admin.payments.edit', $payment->id) }}" class="btn btn-warning">Sửa</a>
    <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary">Quay lại</a>
@endsection
