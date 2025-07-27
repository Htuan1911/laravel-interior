@extends('layouts.admin')

@section('title', 'Danh sách đánh giá')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="h3">Danh sách đánh giá</h1>
            {{-- <a href="{{ route('admin.reviews.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-1"></i> Thêm đánh giá
            </a> --}}
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover table-bordered align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Người dùng</th>
                            <th>Sản phẩm</th>
                            <th>Đánh giá</th>
                            <th>Bình luận</th>
                            <th>Ngày tạo</th>
                            <th>Ngày cập nhật</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reviews as $review)
                            <tr>
                                <td>{{ $review->id }}</td>
                                <td>{{ $review->user->name ?? 'Không rõ' }}</td>
                                <td>{{ $review->orderItem->variant_name ?? 'Không rõ' }}</td>
                                <td>
                                    <span class="badge bg-warning text-dark">{{ $review->rating }}/5</span>
                                </td>
                                <td>{{ Str::limit(strip_tags($review->comment), 50) }}</td>
                                <td>{{ $review->created_at->format('d/m/Y H:i') }}</td>
                                <td>{{ $review->updated_at->format('d/m/Y H:i') }}</td>
                                <td>
    <div class="btn-group mb-1" role="group">
        <a href="{{ route('admin.reviews.show', $review->id) }}" class="btn btn-sm btn-info">
            <i class="fas fa-eye"></i>
        </a>
        <a href="{{ route('admin.reviews.edit', $review->id) }}" class="btn btn-sm btn-warning">
            <i class="fas fa-edit"></i>
        </a> 
        {{-- <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST"
              onsubmit="return confirm('Bạn chắc chắn muốn xóa?');" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger">
                <i class="fas fa-trash-alt"></i>
            </button>
        </form> --}}
        {{-- ✅ Nút Ẩn/Hiện --}}
    <form action="{{ route('admin.reviews.toggleVisibility', $review->id) }}" method="POST">
        @csrf
        @method('PATCH')
        <button type="submit" class="btn btn-sm {{ $review->is_visible ? 'btn-warning' : 'btn-success' }}">
            {{ $review->is_visible ? 'Ẩn' : 'Hiện' }}
        </button>
    </form>
    </div>

    
</td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">Không có đánh giá nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-3">
            {{ $reviews->links() }}
        </div>
    </div>
@endsection
