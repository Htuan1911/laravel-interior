@extends('layouts.admin')

@section('content')
    <h1>Thêm đánh giá</h1>

    <form action="{{ route('admin.reviews.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Người dùng</label>
            <select name="user_id" class="form-control" required>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Sản phẩm (Order Item)</label>
            <select name="order_item_id" class="form-control" required>
                @foreach($orderItems as $item)
                    <option value="{{ $item->id }}">{{ $item->variant_name }}</option>
                @endforeach
            </select>
        </div> 

        <div class="mb-3">
            <label>Đánh giá (1-5)</label>
            <input type="number" name="rating" class="form-control" min="1" max="5" required>
        </div>

        <div class="mb-3">
            <label>Bình luận</label>
            <textarea name="comment" class="form-control" rows="4" required></textarea>
        </div>

        <button class="btn btn-primary">Lưu</button>
    </form>
@endsection
