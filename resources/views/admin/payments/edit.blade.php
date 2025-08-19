@extends('layouts.admin')

@section('title', 'Cập nhật thanh toán')

@section('content')
    <h1>Cập nhật thanh toán #{{ $payment->id }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @php
        // Lấy trạng thái mới nhất từ đơn hàng
        $latestStatus = strtolower($payment->order?->latest_status ?? 'pending');
        $paymentStatus = strtolower($payment->status ?? 'unpaid');

        // Logic khóa form: KHÔNG cho cập nhật nếu:
        // - Đơn hàng đã từ "paid", "shipped", "completed" và thanh toán cũng là "paid"/"success"
        // - Hoặc đơn hàng đã bị hủy
        // - Ngoại lệ: nếu đơn hàng đang "shipped" nhưng chưa thanh toán (COD) thì vẫn mở
        $isLocked = (
            (
                in_array($latestStatus, ['paid', 'shipped', 'completed']) &&
                in_array($paymentStatus, ['paid', 'success'])
            )
            || $latestStatus === 'cancelled'
        );
    @endphp

    <form action="{{ route('admin.payments.update', $payment->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Trạng thái thanh toán</label>

            @if ($isLocked)
                <input type="text" class="form-control" value="{{ ucfirst($payment->status) }}" disabled>
                <div class="form-text text-danger">Không thể thay đổi vì đơn hàng đã {{ $latestStatus == 'cancelled' ? 'bị hủy' : 'hoàn tất và đã thanh toán' }}.</div>
            @else
                <select name="status" class="form-control">
                    @foreach ($statuses as $status)
                        <option value="{{ $status }}" {{ $payment->status == $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
            @endif
        </div>

        <button class="btn btn-primary" {{ $isLocked ? 'disabled' : '' }}>Cập nhật</button>
        <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
@endsection
