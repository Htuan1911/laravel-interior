@extends('layouts.admin')

@section('content')
    <h1>Chi tiết đánh giá</h1>

    <div class="card">
        <div class="card-body">
            <p><strong>Người dùng:</strong> {{ $reviews->user->name }}</p>
            <p><strong>Tên sản phẩm:</strong>
    {{ optional($reviews->orderItem->variant->product->translations
        ->where('language_code', app()->getLocale())
        ->first())->name ?? 'Không rõ' }}
</p>

            <p><strong> biến thể :</strong> {{ $reviews->orderItem->variant_name ?? 'N/A' }}</p>
            <p><strong>Đánh giá:</strong> {{ $reviews->rating }}/5</p>
            <p><strong>Bình luận:</strong></p>
            <p>{{ $reviews->comment }}</p>



          <p><strong>Ngày tạo:</strong> {{ $reviews->created_at->format('d/m/Y H:i') }}</p>
<p><strong>Ngày cập nhật:</strong> {{ $reviews->updated_at->format('d/m/Y H:i') }}</p>
            <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary mt-3">Quay lại</a>
        </div>
    </div>
@endsection
