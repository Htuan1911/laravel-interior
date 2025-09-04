@extends('layouts.admin')

@section('title', 'Danh sách đánh giá')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="h3">Danh sách đánh giá</h1>

 <form method="GET" action="{{ route('admin.reviews.index') }}" class="d-flex">
        <select name="rating" class="form-select me-2" onchange="this.form.submit()">
            <option value="">-- Lọc theo số sao --</option>
            <option value="1" {{ request('rating') == 1 ? 'selected' : '' }}>1 sao</option>
            <option value="2" {{ request('rating') == 2 ? 'selected' : '' }}>2 sao</option>
            <option value="3" {{ request('rating') == 3 ? 'selected' : '' }}>3 sao</option>
            <option value="4" {{ request('rating') == 4 ? 'selected' : '' }}>4 sao</option>
            <option value="5" {{ request('rating') == 5 ? 'selected' : '' }}>5 sao</option>
        </select>
        @if(request('rating'))
            <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary">Xóa lọc</a>
        @endif
    </form>

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
                                <td>
                                    {{ optional($review->orderItem->variant->product->translations
                                    ->where('language_code', app()->getLocale())
                                    ->first())->name ?? 'Không rõ' }}
                                </td>
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
        {{-- <a href="{{ route('admin.reviews.edit', $review->id) }}" class="btn btn-sm btn-warning">
            <i class="fas fa-edit"></i>
        </a>  --}}
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
