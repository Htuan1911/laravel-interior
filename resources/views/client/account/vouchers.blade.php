@extends('layouts.cart')

@section('cart-content')
    <div class="container py-5">
        <h3>Danh sách mã giảm giá</h3>

        @if($coupons->isEmpty())
            <div class="alert alert-info">Hiện tại bạn chưa có mã giảm giá nào.</div>
        @else
            @foreach ($coupons as $coupon)
                <div class="card mb-4">
                    <div class="card-header">
                        <strong>Mã:</strong> {{ $coupon->code }} |
                        <strong>Loại:</strong> 
                        @if($coupon->discount_percent)
                            Giảm theo %
                        @else
                            Giảm cố định
                        @endif
                        |
                        <strong>Giá trị:</strong> 
                        @if($coupon->discount_percent)
                            {{ $coupon->discount_percent }}%
                        @else
                            {{ number_format($coupon->discount_amount, 0, ',', '.') }} đ
                        @endif
                        |
                        <strong>HSD:</strong> 
                        {{ $coupon->expires_at ? \Carbon\Carbon::parse($coupon->expires_at)->format('d/m/Y H:i') : 'Không giới hạn' }}
                    </div>

                    <div class="card-body">
                        <p><strong>Áp dụng cho đơn hàng tối thiểu:</strong> 
                            {{ number_format($coupon->min_order_amount ?? 0, 0, ',', '.') }} đ
                        </p>
                        <p><strong>Trạng thái:</strong> 
                            {{ $coupon->is_active ? 'Đang hoạt động' : 'Ngưng áp dụng' }}
                        </p>
                        {{-- 
                        <p><strong>Đã dùng:</strong> {{ $coupon->used_count }} / {{ $coupon->max_uses }}</p> 
                        --}}
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endsection
