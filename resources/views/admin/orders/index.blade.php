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

    {{-- Form tìm kiếm --}}
    <form method="GET" action="{{ route('admin.orders.index') }}" class="mb-3">
        <div class="row g-2">
            <div class="col-md-2">
                <input type="text" name="order_id" value="{{ request('order_id') }}" class="form-control" placeholder="ID đơn hàng">
            </div>
            <div class="col-md-3">
                <input type="text" name="user_name" value="{{ request('user_name') }}" class="form-control" placeholder="Tên người dùng">
            </div>
            <div class="col-md-3">
                <input type="text" name="phone" value="{{ request('phone') }}" class="form-control" placeholder="SĐT">
            </div>          
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">-- Trạng thái đơn hàng --</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                    <option value="shipping" {{ request('status') == 'shipping' ? 'selected' : '' }}>Đang giao hàng</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Hoàn tất</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                </select>
            </div>
            <div class="col-md-1 d-grid">
                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
            </div>          
        </div>
    </form>

    {{-- @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif --}}

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
                                {{-- đoạn xử lý trạng thái giống bạn --}}
                                @php
                                    $latestStatus = strtolower($order->statusLogs?->last()?->new_status ?? $order->status);

                                    $statusBadge = match($latestStatus) {
                                        'pending'   => 'secondary',
                                        'confirmed' => 'info',
                                        'shipping'  => 'primary',
                                        'completed' => 'success',
                                        'cancelled' => 'danger',
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

                                    $paymentStatus = strtolower($order->payment?->status ?? 'unpaid');
                                    $paymentMethodRaw = $order->payment?->method ?? 'cod';
                                    $paymentMethod = strtolower($paymentMethodRaw); // để check điều kiện
                                    $paymentMethodDisplay = ucfirst($paymentMethodRaw); // để hiển thị

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

                                    $isLocked = 
                                                // Đơn đã hoàn tất hoặc bị hủy thì luôn khóa
                                                in_array($latestStatus, ['completed', 'cancelled']) ||

                                                // Đang giao hàng + đã thanh toán hoặc không phải COD → khóa
                                                (
                                                    $latestStatus === 'completed' &&
                                                    (
                                                        in_array($paymentStatus, ['paid', 'success']) ||
                                                        $paymentMethod !== 'cod'
                                                    )
                                                );
                                    $disableDelete = $isLocked
                                                    || (
                                                        $latestStatus === 'cancelled'
                                                        && in_array($paymentStatus, ['paid', 'success'])
                                                        && $paymentMethod !== 'cod'
                                                    )
                                                    || in_array($paymentStatus, ['failed', 'unpaid']);

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

                                               {{-- Chỉ hiện nút sửa khi đơn chưa bị khóa + đã thanh toán --}}
                                               @if (
                                                    !$isLocked &&
                                                    (
                                                        ($paymentMethod === 'cod') || in_array($paymentStatus, ['paid', 'success'])
                                                    )
                                                )
                                                    <a href="{{ route('admin.orders.editStatus', $order->id) }}" class="btn btn-sm btn-warning" title="Cập nhật trạng thái">
                                                        <i class="fas fa-sync-alt"></i>
                                                    </a>
                                                @endif

                                                {{-- <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Xóa đơn hàng này?')" class="d-inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Xóa"
                                                        {{ $disableDelete ? 'disabled' : '' }}>
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form> --}}
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- Thêm phân trang nếu cần --}}
                {{ $orders->withQueryString()->links() }}
            @else
                <div class="alert alert-info mb-0">Chưa có đơn hàng nào.</div>
            @endif
        </div>
    </div>
</div>

@endsection
<script>
document.addEventListener('DOMContentLoaded', function () {
    const statusSelect = document.getElementById('status');

    statusSelect.addEventListener('change', function () {
        if (this.value === 'completed') {
            alert('Đơn hàng hoàn tất → trạng thái thanh toán sẽ tự động thành "Đã thanh toán"');
        }
    });
});
</script>
