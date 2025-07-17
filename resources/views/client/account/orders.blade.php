@extends('layouts.master')

@section('account_content')
<h4>Lịch sử đơn hàng</h4>

@if($orders->isEmpty())
    <div class="alert alert-info">Không có đơn hàng nào.</div>
@else
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Mã đơn</th>
                <th>Ngày đặt</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
                <th>Chi tiết</th>
            </tr>
        </thead>
        <tbody>
        @foreach($orders as $order)
            <tr>
                <td>#{{ $order->id }}</td>
                <td>{{ $order->created_at->format('d/m/Y') }}</td>
                <td>{{ number_format($order->total_amount) }} đ</td>
                <td>{{ $order->status }}</td>
                <td>
                    <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#orderModal{{ $order->id }}">Xem</button>
                    
                    <!-- Modal -->
                    <div class="modal fade" id="orderModal{{ $order->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5>Chi tiết đơn hàng #{{ $order->id }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Người nhận:</strong> {{ $order->shipping_name }}</p>
                                    <p><strong>SĐT:</strong> {{ $order->shipping_phone }}</p>
                                    <p><strong>Địa chỉ:</strong> {{ $order->shipping_address }}</p>
                                    <p><strong>Trạng thái:</strong> {{ $order->status }}</p>
                                    <p><strong>Tổng tiền:</strong> {{ number_format($order->total_amount) }} đ</p>
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
