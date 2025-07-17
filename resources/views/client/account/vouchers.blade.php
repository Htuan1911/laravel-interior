@extends('layouts.master')

@section('account_content')
<h4>Danh sách mã giảm giá</h4>

@if($coupons->isEmpty())
    <div class="alert alert-info">Hiện tại bạn chưa có mã giảm giá nào.</div>
@else
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Mã</th>
                <th>Loại giảm</th>
                <th>Giá trị</th>
                <th>HSD</th>
                {{-- <th>Sử dụng</th> --}}
                <th>Chi tiết</th>
            </tr>
        </thead>
        <tbody>
        @foreach($coupons as $coupon)
            <tr>
                <td><strong>{{ $coupon->code }}</strong></td>
                <td>
                    @if($coupon->discount_percent)
                        Giảm theo %
                    @else
                        Giảm cố định
                    @endif
                </td>
                <td>
                    @if($coupon->discount_percent)
                        {{ $coupon->discount_percent }}%
                    @else
                        {{ number_format($coupon->discount_amount) }} đ
                    @endif
                </td>
                <td>
                    {{ $coupon->expires_at ? \Carbon\Carbon::parse($coupon->expires_at)->format('d/m/Y H:i') : 'Không giới hạn' }}
                </td>
                {{-- <td>
                    {{ $coupon->used_count }} / {{ $coupon->max_uses }}
                </td> --}}
                <td>
                    <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#couponModal{{ $coupon->id }}">Xem</button>

                    <!-- Modal -->
                    <div class="modal fade" id="couponModal{{ $coupon->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5>Chi tiết mã: {{ $coupon->code }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Giảm:</strong> 
                                        @if($coupon->discount_percent)
                                            {{ $coupon->discount_percent }}%
                                        @else
                                            {{ number_format($coupon->discount_amount) }} đ
                                        @endif
                                    </p>
                                    <p><strong>Áp dụng cho đơn từ:</strong> {{ number_format($coupon->min_order_amount) }} đ</p>
                                    {{-- <p><strong>Số lượt sử dụng:</strong> {{ $coupon->used_count }} / {{ $coupon->max_uses }}</p> --}}
                                    <p><strong>Ngày hết hạn:</strong> 
                                        {{ $coupon->expires_at ? \Carbon\Carbon::parse($coupon->expires_at)->format('d/m/Y H:i') : 'Không giới hạn' }}
                                    </p>
                                    <p><strong>Trạng thái:</strong> {{ $coupon->is_active ? 'Đang hoạt động' : 'Ngưng áp dụng' }}</p>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif
@endsection
