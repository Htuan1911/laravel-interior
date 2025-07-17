@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="mb-4">Danh sách bài viết</h1>

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary mb-3">Thêm bài viết</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tiêu đề</th>
                <th>Danh mục</th>
                <th>Ngày tạo</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($posts as $post)
            <tr>
                <td>{{ $post->id }}</td>
                <td>{{ $post->title }}</td>
                <td>{{ $post->category_name ?? 'Không có' }}</td>

                <td>{{ \Carbon\Carbon::parse($post->created_at)->format('d/m/Y H:i') }}</td>

                <td>
                    <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-sm btn-warning">Sửa</a>

                    <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-sm btn-danger"
                            onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                    </form>
                    
               <a href="{{ route('admin.posts.show', $post->id) }}" class="btn btn-sm btn-info">Chi tiết</a>

                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5">Không có bài viết nào.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{ $posts->links() }}
</div>
@endsection