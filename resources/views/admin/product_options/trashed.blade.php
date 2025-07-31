@extends('layouts.admin')

@section('content')
    <h4>Danh sách thuộc tính đã xóa</h4>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tên</th>
                <th>Danh mục</th>
                <th>Loại</th>
                <th>Trạng thái</th>
                <th>Thời gian xóa</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($trashedOptions as $option)
                <tr>
                    <td>{{ $option->name }}</td>
                    <td>{{ $option->category_name ?? '(Không xác định)' }}</td>
                    <td>{{ ucfirst($option->type) }}</td>
                    <td>
                        @if ($option->status)
                            <span class="badge bg-success">Hiện</span>
                        @else
                            <span class="badge bg-secondary">Ẩn</span>
                        @endif
                    </td>
                    <td>{{ \Carbon\Carbon::parse($option->deleted_at)->format('d/m/Y H:i') }}</td>
                    <td class="d-flex gap-1">
                        {{-- Khôi phục --}}
                        <form method="POST" action="{{ route('admin.product_options.restore', $option->id) }}">
                            @csrf
                            {{-- KHÔNG dùng @method ở đây vì route là POST --}}
                            <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('Khôi phục thuộc tính này?')">Khôi phục</button>
                        </form>

                        {{-- (Tuỳ chọn) Xóa vĩnh viễn nếu có route forceDelete --}}
                        
                        <form method="POST" action="{{ route('admin.product_options.force_delete', $option->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa vĩnh viễn?')">Xóa vĩnh viễn</button>
                        </form>
                       
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">Không có thuộc tính nào đã bị xóa.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <a href="{{ route('admin.product_options.index') }}" class="btn btn-secondary">← Quay lại danh sách chính</a>
@endsection
