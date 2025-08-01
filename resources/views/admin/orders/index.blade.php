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
    @elseif (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            @if ($orders->count())
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Người dùng</th>
                                <th>SĐT</th>
                                <th>Tổng tiền</th>
                                <th>Ngày đặt</th>
                                <th>Trạng thái đơn hàng</th>
                                <th>Thanh toán</th>
                                <th>Phương thức thanh toán</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                    @php
                                        // Trạng thái đơn hàng từ DB
                                        $latestStatus = strtolower($order->statusLogs?->last()?->new_status ?? $order->status);

                                        $statusBadge = match($latestStatus) {
                                            'pending'   => 'secondary', // Chờ xử lý
                                            'confirmed' => 'info',      // Đã xác nhận, chờ giao
                                            'shipping'  => 'primary',   // Đang giao hàng
                                            'completed' => 'success',   // Hoàn tất đơn hàng
                                            'cancelled' => 'danger',    // Đơn bị hủy
                                            default     => 'secondary',
                                        };

                                        $translatedStatus = match($latestStatus) {
                                            'pending'   => 'Chờ xử lý',
                                            'confirmed' => 'Đã xác nhận',
                                            'shipping'  => 'Đang giao hàng',
                                            'completed' => 'Hoàn tất',
                                            'cancelled' => 'Đã hủy',
                                            default     => ucfirst($latestStatus),
                                        };

                                        // Trạng thái thanh toán
                                        $paymentStatus = strtolower($order->payment?->status ?? 'unpaid');
                                        $paymentMethod = strtolower($order->payment?->method ?? 'cod');

                                        $paymentBadge = match($paymentStatus) {
                                            'paid', 'success' => 'success',
                                            'pending'         => 'warning',
                                            'failed'          => 'danger',
                                            default           => 'secondary',
                                        };

                                        $paymentText = match($paymentStatus) {
                                            'paid', 'success' => 'Đã thanh toán',
                                            'pending'         => 'Chưa thanh toán',
                                            'failed'          => 'Thanh toán thất bại',
                                            default           => 'Chưa thanh toán',
                                        };

                                        $paymentMethod = $order->payment?->method ?? 'Không rõ';

                                        // Khóa sửa nếu đơn hàng đã xác nhận trở lên và đã thanh toán, hoặc bị huỷ
                                      $isLocked = (in_array($latestStatus, ['confirmed', 'shipping', 'completed']) &&
                                                  (in_array($paymentStatus, ['paid', 'success']) || $paymentMethod === 'cod')
                                                ) || $latestStatus === 'cancelled';


                                        $disableDelete =
                                            // Đơn đang giao, hoàn tất hoặc đã hủy thì không được xóa
                                            in_array(strtolower($order->status), ['shipping', 'completed', 'cancelled'])

                                            // Hoặc đơn đã thanh toán online (trừ COD)
                                            || (
                                                in_array(strtolower($order->payment?->status ?? ''), ['paid', 'success']) &&
                                                strtolower($order->payment?->method ?? '') !== 'cod'
                                            );


                                    @endphp


                                <tr>
                                    <td>#{{ $order->id }}</td>
                                    <td>{{ $order->user->name ?? 'Không rõ' }}</td>
                                    <td>{{ $order->shipping_phone }}</td>
                                    <td>{{ number_format($order->total_amount, 0, ',', '.') }}₫</td>
                                    <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $statusBadge }}">
                                            {{ $translatedStatus }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $paymentBadge }}">
                                            {{ $paymentText }}
                                        </span>
                                    </td>
                                    <td>{{ ucfirst($paymentMethod) }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            @if ($order->trashed())
                                                <form action="{{ route('admin.orders.restore', $order->id) }}" method="POST" onsubmit="return confirm('Khôi phục đơn hàng này?')" class="d-inline-block">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success" title="Khôi phục">
                                                        <i class="fas fa-undo"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-info" title="Xem chi tiết">
                                                    <i class="fas fa-eye"></i>
                                                </a>

                                                @unless($isLocked)
                                                    <a href="{{ route('admin.orders.editStatus', $order->id) }}" class="btn btn-sm btn-warning" title="Cập nhật trạng thái">
                                                        <i class="fas fa-sync-alt"></i>
                                                    </a>
                                                @endunless

                                                <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Xóa đơn hàng này?')" class="d-inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Xóa"
                                                        {{ $disableDelete ? 'disabled' : '' }}>
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            @endif
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
<script>
    setInterval(function() {
        fetch('/run-scheduler')
            .then(response => response.json())
            .then(data => console.log('Đã gọi schedule:', data.status));
    }, 15000); // gọi mỗi 15 giây
</script>

@endsection

