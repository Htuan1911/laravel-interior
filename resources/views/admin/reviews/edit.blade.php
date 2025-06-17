@extends('layouts.admin')

@section('content')
    <h1>Chỉnh sửa đánh giá</h1>

    <form action="{{ route('admin.reviews.update', $reviews->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Người dùng</label>
            <select name="user_id" class="form-control" required>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $user->id == $reviews->user_id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Sản phẩm (Order Item)</label>
            <select name="order_item_id" class="form-control" required>
                @foreach($orderItems as $item)
                    <option value="{{ $item->id }}" {{ $item->id == $reviews->order_item_id ? 'selected' : '' }}>
                        {{ $item->variant_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Đánh giá</label>
            <input type="number" name="rating" class="form-control" value="{{ $reviews->rating }}" min="1" max="5" required>
        </div>

        <div class="mb-3">
            <label>Bình luận</label>
            <textarea name="comment" class="form-control" rows="4" required>{{ $reviews->comment }}</textarea>
        </div>

        <button class="btn btn-success">Cập nhật</button>
    </form>
@endsection
