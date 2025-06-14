@extends('layouts.admin')

@section('title', 'Sửa sản phẩm yêu thích')

@section('content')
    <div class="container">
        <h1 class="my-4">Sửa sản phẩm yêu thích</h1>

        <form action="{{ route('admin.wishlists.update', $wishlist->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="user_id" class="form-label">Người dùng</label>
                <select name="user_id" id="user_id" class="form-control" required>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ $wishlist->user_id == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} (ID: {{ $user->id }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="product_id" class="form-label">Sản phẩm</label>
                <select name="product_id" id="product_id" class="form-control" required>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}" {{ $wishlist->product_id == $product->id ? 'selected' : '' }}>
                            {{ $product->name }} (ID: {{ $product->id }})
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-success">Cập nhật</button>
            <a href="{{ route('admin.wishlists.index') }}" class="btn btn-secondary">Hủy</a>
        </form>
    </div>
@endsection
