@extends('layouts.cart')

@section('cart-content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    {{-- Thêm Bootstrap Icons nếu chưa có --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        .review-box {
            background-color: #f9f9f9;
            border: 1px solid #000;
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
            color: #ccc;
        }

        .rating-stars {
            display: flex;
            flex-direction: row-reverse;
        }

        .rating-stars input[type="radio"] {
            display: none;
        }

        .rating-stars input[type="radio"]:checked~label i,
        .rating-stars input[type="radio"]:checked+label i {
            color: #ffc107 !important;
        }

        .rating-stars label:hover i,
        .rating-stars label:hover~label i {
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
                            <strong>Trạng thái đơn hàng:</strong> {{ $order->status_label }} |
                            <strong>Trạng thái thanh toán:</strong>
                            @if (optional($order->payment)->status === 'paid')
                                <span class="text-success">Đã thanh toán</span>
                            @elseif(optional($order->payment)->status === 'pending')
                                <span class="text-danger">Chưa thanh toán</span>
                            @elseif(optional($order->payment)->status === 'failed')
                                <span class="text-danger">Thanh toán thất bại</span>
                            @else
                                <span class="text-muted">Không xác định</span>
                            @endif
                            |
                            <strong>Phương thức:</strong>
                            @switch(optional($order->payment)->method)
                                @case('cod')
                                    Thanh toán khi nhận hàng
                                @break

                                @case('momo')
                                    Ví MoMo
                                @break

                                @case('vnpay')
                                    Ví VNPAY
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

                        @if (in_array($order->status, ['completed', 'cancelled']))
                            <a href="{{ route('client.orders.reorder', $order->id) }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-cart-plus"></i> Mua lại
                            </a>
                        @endif
                    </div>

                    <div class="order-body">
                        <p><strong>Người nhận:</strong> {{ $order->shipping_name }} - {{ $order->shipping_phone }}</p>
                        <p><strong>Địa chỉ:</strong> {{ $order->shipping_address }}</p>

                        <ul class="list-unstyled">
                            @foreach ($order->items as $item)
                                @php
                                    $variant = $item->variant;
                                    $product = $variant ? $variant->product : null;
                                    $productName =
                                        $product && $product->translations && $product->translations->first()
                                            ? $product->translations->first()->name
                                            : '--- Sản phẩm không tồn tại ---';

                                    $userReview = $item
                                        ->reviews()
                                        ->where('user_id', auth()->id())
                                        ->first();
                                @endphp

                                <li class="mb-4 d-flex">
                                    {{-- Hình ảnh sản phẩm --}}
                                    <img src="{{ asset('storage/' . ($variant->image ?? ($product->image ?? 'default.jpg'))) }}"
                                        alt="{{ $productName }}" width="80" height="80" class="me-3"
                                        style="object-fit: cover; border-radius: 5px;">

                                    <div style="flex-grow: 1;">
                                        {{-- Tên sản phẩm --}}
                                        <p class="mb-1"><strong>{{ $productName }}</strong></p>

                                        {{-- Biến thể --}}
                                        @if ($item->variant_name)
                                            <p class="mb-1 text-muted">Biến thể: {{ $item->variant_name }}</p>
                                        @endif

                                        {{-- Số lượng + Giá --}}
                                        <p class="mb-1">
                                            SL: {{ $item->quantity }} |
                                            Đơn giá: {{ number_format($item->unit_price, 0, ',', '.') }} đ |
                                            Tổng: {{ number_format($item->total_price, 0, ',', '.') }} đ
                                        </p>

                                        {{-- Chỉ hiển thị box đánh giá khi có đánh giá hoặc đơn hàng đã hoàn tất --}}
                                        @if ($userReview || $order->status === 'completed')
                                            <div class="review-box mt-3">
                                                @if ($userReview)
                                                    {{-- Đã đánh giá --}}
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
                                                    {{-- Form đánh giá --}}
                                                    <h6 class="mb-2">Đánh giá sản phẩm</h6>

                                                    <form action="{{ route('client.reviews.store') }}" method="POST"
                                                        onsubmit="return validateReviewForm({{ $item->id }})">
                                                        @csrf
                                                        <input type="hidden" name="order_item_id"
                                                            value="{{ $item->id }}">

                                                        <div class="mb-2 rating-stars">
                                                            @for ($i = 5; $i >= 1; $i--)
                                                                <input type="radio" name="rating_{{ $item->id }}"
                                                                    id="star-{{ $item->id }}-{{ $i }}"
                                                                    value="{{ $i }}">
                                                                <label for="star-{{ $item->id }}-{{ $i }}"
                                                                    class="star-label">
                                                                    <i class="bi bi-star-fill"></i>
                                                                </label>
                                                            @endfor
                                                        </div>

                                                        <input type="hidden" name="rating"
                                                            id="rating-value-{{ $item->id }}">

                                                        <div class="mb-2">
                                                            <label for="comment-{{ $item->id }}"
                                                                class="form-label">Bình luận:</label>
                                                            <textarea name="comment" id="comment-{{ $item->id }}" rows="3" class="form-control" maxlength="500"
                                                                placeholder="Nhập nhận xét của bạn..." required></textarea>
                                                        </div>

                                                        <button type="submit" class="btn btn-warning">
                                                            <i class="bi bi-send"></i> Gửi đánh giá
                                                        </button>
                                                    </form>

                                                    {{-- Script xử lý chọn số sao --}}
                                                    <script>
                                                        document.querySelectorAll('input[name="rating_{{ $item->id }}"]').forEach(function(radio) {
                                                            radio.addEventListener('change', function() {
                                                                document.getElementById('rating-value-{{ $item->id }}').value = this.value;
                                                            });
                                                        });

                                                        function validateReviewForm(itemId) {
                                                            const ratingValue = document.getElementById('rating-value-' + itemId).value;
                                                            const comment = document.getElementById('comment-' + itemId).value.trim();

                                                            if (!ratingValue) {
                                                                alert("Vui lòng chọn số sao đánh giá.");
                                                                return false;
                                                            }

                                                            if (!comment) {
                                                                alert("Vui lòng nhập bình luận.");
                                                                return false;
                                                            }

                                                            return true;
                                                        }
                                                    </script>
                                                @endif
                                            </div>
                                        @endif
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
