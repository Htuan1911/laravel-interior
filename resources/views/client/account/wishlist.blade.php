@extends('layouts.master')

@section('account_content')
    <h4 class="mb-4">Danh sách yêu thích</h4>

    {{-- Thông báo khi xoá thành công --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Danh sách yêu thích --}}
    @if($wishlist->isEmpty())
        <div class="alert alert-warning">Bạn chưa thêm sản phẩm nào vào danh sách yêu thích.</div>
    @else
        <div class="row">
            @foreach($wishlist as $item)
                @php
                    $product = $item->product;
                    $variant = $product->variants->first(); // lấy biến thể đầu tiên
                @endphp

                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        {{-- Hiển thị ảnh sản phẩm --}}
                        <img 
                            src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/no-image.png') }}" 
                            class="card-img-top" 
                            alt="{{ $product->name }}"
                            onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}';"
                        >

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $product->name }}</h5>

                            @if($variant)
                                <p class="card-text mb-3">
                                    Giá: <strong>{{ number_format($variant->price, 0, ',', '.') }} đ</strong>
                                </p>
                            @else
                                <p class="card-text mb-3 text-danger">Chưa có biến thể sản phẩm</p>
                            @endif

                            {{-- Form xoá --}}
                            <form 
                                action="{{ route('client.account.wishlist.delete', $item->id) }}" 
                                method="POST" 
                                onsubmit="return confirm('Bạn chắc chắn muốn xoá sản phẩm này khỏi danh sách yêu thích?')"
                                class="mt-auto"
                            >
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm w-100">🗑 Xoá khỏi yêu thích</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
