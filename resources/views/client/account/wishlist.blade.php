@extends('layouts.master')

@section('account_content')
<h4>Danh sách yêu thích</h4>

@if($wishlist->isEmpty())
    <div class="alert alert-warning">Bạn chưa thêm sản phẩm nào.</div>
@else
    <div class="row">
        @foreach($wishlist as $item)
        <div class="col-md-6 mb-4">
            <div class="card">
                <img src="{{ asset('storage/' . $item->product->image) }}" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">{{ $item->product->name }}</h5>
                    <p class="card-text">Giá: {{ number_format($item->product->price) }} đ</p>
                    <form action="{{ route('account.wishlist.delete', $item->id) }}" method="POST" onsubmit="return confirm('Xoá sản phẩm này khỏi yêu thích?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Xoá</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endif
@endsection
