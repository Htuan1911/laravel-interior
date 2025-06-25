@extends('layouts.admin')

@section('content')
    <h1>Danh sách đánh giá</h1>
    <a href="{{ route('admin.reviews.create') }}" class="btn btn-primary mb-3">Thêm đánh giá</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Người dùng</th>
                <th>Sản phẩm</th>
                <th>Đánh giá</th>
                <th>Bình luận</th>
                 <th>Ngày tạo</th> {{-- thêm cột created_at --}}
                <th>Ngày cập nhật</th> {{-- thêm cột updated_at --}}
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reviews as $review)
                <tr>
                    <td>{{ $review->id }}</td>
                    <td>{{ $review->user->name }}</td>
                    <td>{{ $review->orderItem->variant_name ?? 'N/A' }}</td>
                    <td>{{ $review->rating }}/5</td>
                    <td>{{ $review->comment }}</td>
                    <td>{{ $review->created_at->format('d/m/Y H:i') }}</td> 
                    <td>{{ $review->updated_at->format('d/m/Y H:i') }}</td> 

                    <td>
                        <a href="{{ route('admin.reviews.show', $review->id) }}" class="btn btn-info btn-sm">Xem</a>
                        <a href="{{ route('admin.reviews.edit', $review->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                        <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Bạn chắc chắn muốn xóa?')" class="btn btn-danger btn-sm">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $reviews->links() }}
@endsection
