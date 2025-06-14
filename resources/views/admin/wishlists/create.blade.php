@extends('layouts.admin')

@section('title', 'Thêm sản phẩm yêu thích')

@section('content')
<div class="container">
    <h1 class="my-4">Thêm sản phẩm yêu thích</h1>

    <form action="{{ route('admin.wishlists.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="user_id" class="form-label">Người dùng</label>
            <select name="user_id" id="user_id" class="form-control" required>
                <option value="">-- Chọn người dùng --</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} (ID: {{ $user->id }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="product_id" class="form-label">Sản phẩm</label>
            <select name="product_id" id="product_id" class="form-control" required>
                <option value="">-- Chọn sản phẩm --</option>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }} (ID: {{ $product->id }})</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Lưu</button>
        <a href="{{ route('admin.wishlists.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection
