@extends('layouts.admin')

@section('title', 'Sửa trạng thái đơn hàng')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Sửa trạng thái cho đơn hàng #{{ $order->id }}</h4>
    </div>
    <div class="card-body">
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
            $latestStatus = strtolower($order->status ?? 'pending');
            $paymentStatus = strtolower(optional($order->payment)->status ?? 'unpaid');

            // Logic khóa form thanh toán
            $isLockedPayment = (
                (
                    in_array($latestStatus, ['paid', 'shipped', 'completed']) &&
                    in_array($paymentStatus, ['paid', 'success'])
                )
                || $latestStatus === 'cancelled'
            );
        @endphp

        <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Chọn trạng thái đơn hàng --}}
            <div class="mb-3">
                <label class="form-label">Trạng thái đơn hàng</label>
                <select name="status" id="status" class="form-control">
                    <option value="pending"   {{ $order->status == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                    <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                    <option value="shipping"  {{ $order->status == 'shipping' ? 'selected' : '' }}>Đang giao hàng</option>
                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Hoàn tất</option>
                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Đã huỷ</option>
                </select>
            </div>

            {{-- Trạng thái thanh toán --}}
            {{-- <div class="mb-3">
                <label class="form-label">Trạng thái thanh toán</label>

                @if ($isLockedPayment)
                    <input type="text" class="form-control" value="{{ ucfirst($paymentStatus) }}" disabled>
                    <div class="form-text text-danger">
                        Không thể thay đổi vì đơn hàng đã 
                        {{ $latestStatus == 'cancelled' ? 'bị hủy' : 'hoàn tất và đã thanh toán' }}.
                    </div>
                @else
                    <select name="payment_status" class="form-control">
                        @if(!in_array($paymentStatus, ['paid', 'success']))
                            <option value="unpaid" {{ in_array($paymentStatus, ['unpaid', 'pending']) ? 'selected' : '' }}>
                                Chưa thanh toán
                            </option>
                            <option value="paid">Đã thanh toán</option>
                        @else
                            <option value="paid" selected>Đã thanh toán</option>
                        @endif
                    </select>
                    @if (in_array($paymentStatus, ['paid', 'success']))
                        <div class="form-text text-warning">
                            Không thể đổi từ "Đã thanh toán" sang "Chưa thanh toán".
                        </div>
                    @endif
                @endif
            </div> --}}

            {{-- Lý do huỷ --}}
            <div class="mb-3" id="cancelReasonWrapper" 
                style="{{ $order->status == 'cancelled' ? '' : 'display:none;' }}">
                <label class="form-label">Lý do huỷ</label>

                @if($order->status == 'cancelled')
                    <textarea class="form-control" rows="3" readonly>{{ $order->cancel_reason }}</textarea>
                @else
                    <textarea name="cancel_reason" class="form-control" rows="3"
                        placeholder="Nhập lý do huỷ đơn hàng">{{ old('cancel_reason') }}</textarea>
                @endif
            </div>

            <button type="submit" class="btn btn-success">Cập nhật</button>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const statusSelect = document.getElementById('status');
    const cancelReasonWrapper = document.getElementById('cancelReasonWrapper');

    const toggleCancelReason = () => {
        if ("{{ $order->status }}" !== 'cancelled') {
            cancelReasonWrapper.style.display =
                (statusSelect.value === 'cancelled') ? 'block' : 'none';
        }
    };

    toggleCancelReason();
    statusSelect.addEventListener('change', toggleCancelReason);
});
</script>
@endsection