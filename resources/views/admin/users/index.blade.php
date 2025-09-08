@extends('layouts.admin')

@section('title', 'Quản lý người dùng')

@section('content')
<div class="container-fluid mt-4">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-gradient bg-info text-white py-3 d-flex flex-wrap justify-content-between align-items-center">
            <h4 class="mb-2 mb-md-0">
                <i class="fas fa-users me-2"></i> Danh sách người dùng
            </h4>
            <a href="{{ route('admin.users.create') }}" class="btn btn-light btn-sm shadow-sm">
                <i class="fas fa-user-plus me-1"></i> Thêm người dùng
            </a>
        </div>

        {{-- Form tìm kiếm --}}
        <div class="p-3 border-bottom bg-light">
            <form action="{{ route('admin.users.index') }}" method="GET" class="row g-2 align-items-center">
           <form method="GET" class="row g-2 mb-4 align-items-center">
    <div class="col-md-4">
        <input type="text" name="search" class="form-control shadow-sm border-0 rounded-pill px-3"
               placeholder="Tìm theo tên hoặc email"
               value="{{ request('search') }}">
    </div>

    <div class="col-auto">
        <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">
            <i class="fas fa-search me-1"></i> Lọc
        </button>
    </div>

    @if(request('search'))
        <div class="col-auto">
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary rounded-pill px-4 shadow-sm">
                <i class="fas fa-redo me-1"></i> Quay lại
            </a>
        </div>
    @endif
</form>

        </div>

        <div class="card-body">
            @if ($users->count())
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Ảnh</th> <!-- Cột ảnh -->
                                <th>Họ tên</th>
                                <th>Email</th>
                                <th>SĐT</th>
                                <th>Vai trò</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>
                                        @if ($user->avatar)
                                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="avatar"
                                                 width="50" height="50"
                                                 class="rounded-circle object-fit-cover">
                                        @else
                                            <img src="{{ asset('images/default-avatar.png') }}" alt="no-avatar"
                                                 width="50" height="50"
                                                 class="rounded-circle object-fit-cover">
                                        @endif
                                    </td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>
                                        @if ($user->role?->name === 'admin')
                                            <span class="badge bg-danger">
                                                <i class="fas fa-user-shield me-1"></i> Admin
                                            </span>
                                        @elseif ($user->role?->name === 'user')
                                            <span class="badge bg-success">
                                                <i class="fas fa-user me-1"></i> User
                                            </span>
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
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.users.show', $user) }}"
                                               class="btn btn-sm btn-info" title="Xem chi tiết">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.users.edit', $user) }}"
                                               class="btn btn-sm btn-warning" title="Chỉnh sửa">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <!-- {{-- <form action="{{ route('admin.users.destroy', $user) }}"
                                                  method="POST" class="d-inline-block"
                                                  onsubmit="return confirm('Bạn chắc chắn muốn xóa?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Xóa">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form> --}} -->
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

        <div class="mt-3 d-flex justify-content-center">
    {{ $users->links('pagination::bootstrap-5') }}
</div>


            @else
                <div class="alert alert-info mb-0">Chưa có người dùng nào.</div>
            @endif
        </div>
    </div>
</div>
@endsection
