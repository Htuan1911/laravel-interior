@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <h2 class="mb-4 fw-bold">📊 Bảng Điều Khiển Thống Kê</h2>

    <!-- Bộ lọc ngày -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-4 col-sm-6">
                    <label class="form-label fw-semibold">Từ ngày</label>
                    <input type="date" name="from" class="form-control" value="{{ $from }}">
                </div>
                <div class="col-md-4 col-sm-6">
                    <label class="form-label fw-semibold">Đến ngày</label>
                    <input type="date" name="to" class="form-control" value="{{ $to }}">
                </div>
                <div class="col-md-4 col-sm-6">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter"></i> Lọc dữ liệu
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tổng quan doanh thu -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-money-bill-wave text-success fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Tổng doanh thu</h6>
                        <h4 class="fw-bold mb-0">
                            @if($totalRevenue > 0)
                                {{ number_format($totalRevenue, 0, ',', '.') }} VNĐ
                            @else
                                0 VNĐ
                            @endif
                        </h4>
                        <small class="text-muted">
                            Từ {{ \Carbon\Carbon::parse($from)->format('d/m/Y') }} đến {{ \Carbon\Carbon::parse($to)->format('d/m/Y') }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-shopping-cart text-primary fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Tổng đơn hàng</h6>
                        <h4 class="fw-bold mb-0">{{ $totalOrders ?? 0 }}</h4>
                        <small class="text-muted">Đã hoàn thành</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-clock text-danger fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Đơn chưa hoàn thành</h6>
                        <h4 class="fw-bold mb-0">{{ $pendingOrders ?? 0 }}</h4>
                        <small class="text-muted">
                            Từ {{ \Carbon\Carbon::parse($from)->format('d/m/Y') }} đến {{ \Carbon\Carbon::parse($to)->format('d/m/Y') }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-box-open text-warning fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Sản phẩm tồn kho</h6>
                        <h4 class="fw-bold mb-0">{{ $totalStock ?? 0 }}</h4>
                        <small class="text-muted">Số lượng hiện tại</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Biểu đồ doanh thu -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="card-title fw-semibold"><i class="fas fa-chart-line me-2"></i>Doanh thu theo ngày</h5>
            <canvas id="revenueChart" style="max-height: 400px;"></canvas>
        </div>
    </div>

    <div class="row g-3">
        <!-- Top sản phẩm bán chạy -->
        <div class="col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-success text-white">
                    <i class="fas fa-fire me-2"></i>Top 5 sản phẩm bán chạy
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                      <thead class="table-light">
    <tr>
        <th>Top</th>
        <th>Ảnh</th>
        <th>Sản phẩm</th>
        <th>Biến thể</th>
        <th>SKU</th>
        <th>Đã bán</th>
    </tr>
</thead>

                       <tbody>
@forelse($topSelling as $index => $item)
    <tr>
        <td>{{ $index + 1 }}</td>
        <td>
            @if($item->variant_image)
                <img src="{{ asset('storage/' . $item->variant_image) }}" width="60" height="60" style="object-fit:cover;" class="rounded">
            @else
                <span class="text-muted">N/A</span>
            @endif
        </td>
        <td>{{ $item->product_name }}</td>
        <td>{{ $item->variant_name ?? 'N/A' }}</td>
        <td>{{ $item->sku }}</td>
        <td>{{ $item->total_sold }}</td>
    </tr>
@empty
    <tr>
        <td colspan="6" class="text-center text-muted">Không có dữ liệu</td>
    </tr>
@endforelse
</tbody>

                    </table>
                </div>
            </div>
        </div>

        <!-- Tồn kho cao bán ít -->
        <div class="col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-warning text-dark">
                    <i class="fas fa-boxes me-2"></i>Top sản phẩm bán ít
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                       <thead class="table-light">
    <tr>
        <th>Top</th>
        <th>Ảnh</th>
        <th>Sản phẩm</th>
        <th>Biến thể</th>
        <th>Còn</th>
        <th>Đã bán</th>
    </tr>
</thead>

                      <tbody>
@forelse($lowSoldHighStock as $index => $item)
    <tr>
        <td>{{ $index + 1 }}</td>
        <td>
            @if($item->variant_image)
                <img src="{{ asset('storage/' . $item->variant_image) }}" width="60" height="60" style="object-fit:cover;" class="rounded">
            @else
                <span class="text-muted">N/A</span>
            @endif
        </td>
        <td>{{ $item->product_name }}</td>
        <td>{{ $item->variant_name ?? 'N/A' }}</td>
        <td>{{ $item->stock }}</td>
        <td>{{ $item->total_sold }}</td>
    </tr>
@empty
    <tr>
        <td colspan="6" class="text-center text-muted">Không có dữ liệu</td>
    </tr>
@endforelse
</tbody>

                    </table>
                </div>
            </div>
        </div>

        <!-- Sản phẩm yêu thích -->
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <i class="fas fa-heart me-2"></i>Top sản phẩm được yêu thích
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Top</th>
                                <th>Sản phẩm</th>
                                <th>Lượt yêu thích</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mostWished as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->product_name }}</td>
                                    <td>{{ $item->wishlist_count }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">Không có dữ liệu</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
<style>
.card {
    border: none;
    border-radius: 10px;
    transition: transform 0.2s;
}
.card:hover {
    transform: translateY(-5px);
}
.card-header {
    border-radius: 10px 10px 0 0;
}
.table th, .table td {
    vertical-align: middle;
}
.table-hover tbody tr:hover {
    background-color: rgba(0, 0, 0, 0.05);
}
img.rounded {
    border-radius: 8px;
    border: 1px solid #dee2e6;
}

</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
window.onload = function () {
    const ctx = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($labels) !!},
            datasets: [{
                label: 'Doanh thu (VNĐ)',
                data: {!! json_encode($dailyRevenue->pluck('total')) !!},
                borderColor: '#4bc0c0',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                tension: 0.4,
                fill: true,
                pointRadius: 5,
                pointHoverRadius: 8,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#4bc0c0',
                pointBorderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        font: {
                            size: 14
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleFont: { size: 14 },
                    bodyFont: { size: 12 },
                    callbacks: {
                        label: function (context) {
                            return new Intl.NumberFormat('vi-VN').format(context.raw) + ' VNĐ';
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    },
                    ticks: {
                        callback: function (value) {
                            return new Intl.NumberFormat('vi-VN').format(value);
                        }
                    }
                }
            }
        }
    });
}
</script>
@endsection
