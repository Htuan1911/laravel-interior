@extends('layouts.cart')

@section('cart-content')
    {{-- Thêm Bootstrap Icons nếu chưa có --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        .review-box {
            background-color: #f9f9f9;
            border-left: 4px solid #ffc107;
            padding: 1rem;
            border-radius: 4px;
        }

        .review-box textarea {
            resize: vertical;
        }

        .order-card {
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .order-header {
            background-color: #f2f2f2;
            padding: 10px 15px;
            border-bottom: 1px solid #ddd;
        }

        .order-body {
            padding: 15px;
        }

        .star-label {
            cursor: pointer;
            transition: color 0.2s;
            margin-right: 4px;
        }

        .star-label i {
            font-size: 1.4rem;
        }

        .rating-stars input[type="radio"] {
            display: none;
        }

        .rating-stars input[type="radio"]:checked ~ label i {
            color: #ffc107 !important;
        }

        .rating-stars label:hover i,
        .rating-stars label:hover ~ label i {
            color: #ffc107 !important;
        }
    </style>

    <div class="container py-5">
        <h3 class="mb-4">Lịch sử đơn hàng</h3>

        @if ($orders->isEmpty())
            <p>Bạn chưa có đơn hàng nào.</p>
        @else
            @foreach ($orders as $order)
                <div class="order-card">
                 <div class="order-header d-flex justify-content-between align-items-center">
    <div>
        <strong>Mã đơn:</strong> {{ $order->id }} |
        <strong>Tổng:</strong> {{ number_format($order->total_amount, 0, ',', '.') }} đ |
        <strong>Trạng thái:</strong> {{ $order->status_label }} |
        <strong>Phương thức:</strong>
        @switch(optional($order->payment)->method)
            @case('cod')
                Thanh toán khi nhận hàng
                @break
            @case('online')
                Ví MoMo
                @break
            @default
                <span class="text-danger">Không xác định</span>
        @endswitch
    </div>

    @if ($order->status === 'pending')
        <form action="{{ route('client.orders.cancel', $order->id) }}" method="POST"
              onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này không?')">
            @csrf
            @method('PUT')
            <button type="submit" class="btn btn-sm btn-danger">
                <i class="bi bi-x-circle-fill"></i> Hủy đơn
            </button>
        </form>
    @endif
</div>


                    <div class="order-body">
                        <p><strong>Người nhận:</strong> {{ $order->shipping_name }} - {{ $order->shipping_phone }}</p>
                        <p><strong>Địa chỉ:</strong> {{ $order->shipping_address }}</p>

                        <ul class="list-unstyled">
                            @foreach ($order->items as $item)
                                <li class="mb-4 d-flex">
                                    <img src="{{ asset('storage/' . ($item->variant->image ?? 'default.jpg')) }}"
                                         alt="Sản phẩm" width="80" height="80" class="me-3"
                                         style="object-fit: cover; border-radius: 5px;">

                                    <div style="flex-grow: 1;">
                                        <p class="mb-1"><strong>{{ $item->variant_name }}</strong></p>
                                        <p class="mb-1">
                                            SL: {{ $item->quantity }} |
                                            Đơn giá: {{ number_format($item->unit_price, 0, ',', '.') }} đ |
                                            Tổng: {{ number_format($item->total_price, 0, ',', '.') }} đ
                                        </p>

                                        @php
                                            $userReview = $item->reviews()->where('user_id', auth()->id())->first();
                                        @endphp

                                        <div class="review-box mt-3">
                                            @if ($userReview)
                                                <h6 class="mb-2 text-success">
                                                    <i class="bi bi-check-circle-fill"></i> Bạn đã đánh giá sản phẩm này
                                                </h6>
                                                <p><strong>Số sao:</strong>
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= $userReview->rating)
                                                            <i class="bi bi-star-fill text-warning"></i>
                                                        @else
                                                            <i class="bi bi-star text-secondary"></i>
                                                        @endif
                                                    @endfor
                                                </p>
                                                <p><strong>Bình luận:</strong> {{ $userReview->comment }}</p>
                                            @elseif ($order->status === 'completed')
                                                <h6 class="mb-2">Đánh giá sản phẩm</h6>
                                                <form action="{{ route('client.reviews.store') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="order_item_id" value="{{ $item->id }}">

                                                    <div class="mb-2 rating-stars d-flex">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <input type="radio" name="rating" id="star-{{ $item->id }}-{{ $i }}" value="{{ $i }}">
                                                            <label for="star-{{ $item->id }}-{{ $i }}" class="star-label">
                                                                <i class="bi bi-star-fill text-secondary"></i>
                                                            </label>
                                                        @endfor
                                                    </div>

                                                    <div class="mb-2">
                                                        <label for="comment-{{ $item->id }}" class="form-label">Bình luận:</label>
                                                        <textarea name="comment" id="comment-{{ $item->id }}" rows="3" class="form-control"
                                                                  maxlength="500" placeholder="Nhập nhận xét của bạn..."></textarea>
                                                    </div>

                                                    <button type="submit" class="btn btn-warning">
                                                        <i class="bi bi-send"></i> Gửi đánh giá
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endsection
