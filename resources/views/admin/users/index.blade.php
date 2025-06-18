@extends('layouts.admin')

@section('title', 'Quản lý người dùng')

@section('content')
<div class="container mt-4">
    <div class="card shadow rounded-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Danh sách người dùng</h4>
            <a href="{{ route('admin.users.create') }}" class="btn btn-light btn-sm">+ Thêm người dùng</a>
        </div>

        <div class="card-body">
            @if ($users->count())
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">#</th>
                            <th>Họ tên</th>
                            <th>Email</th>
                            <th>SĐT</th>
                            <th>Vai trò</th>
                            <th>Trạng thái</th>
                            <th width="160">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <th scope="row">{{ $user->id }}</th>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone }}</td>
                               <td>
    @if ($user->role?->name === 'admin')
        <span class="badge bg-danger">Admin</span>
    @elseif ($user->role?->name === 'user')
        <span class="badge bg-success">User</span>
    @else
        <span class="badge bg-secondary">Chưa phân quyền</span>
    @endif
</td>

                                <td>
                                    @if ($user->status === 'active')
                                        <span class="badge bg-success">Hoạt động</span>
                                    @else
                                        <span class="badge bg-secondary">Không hoạt động</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.users.show', $user) }}" class="btn btn-info btn-sm">Xem</a>
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning btn-sm">Sửa</a>
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Bạn chắc chắn muốn xóa?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Xoá</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div class="mt-3">
                    {{ $users->links() }}
                </div>
            @else
                <p class="text-muted">Chưa có người dùng nào.</p>
            @endif
        </div>
    </div>
</div>
@endsection
