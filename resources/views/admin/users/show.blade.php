@extends('layouts.admin')

@section('title', 'Chi tiết người dùng')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg rounded-4">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Chi tiết người dùng</h4>
        </div>
        <div class="card-body">
            <ul class="list-group list-group-flush fs-6">
                <li class="list-group-item"><strong>ID:</strong> {{ $user->id }}</li>
                <li class="list-group-item"><strong>Họ tên:</strong> {{ $user->name }}</li>
                <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
                <li class="list-group-item"><strong>Điện thoại:</strong> {{ $user->phone }}</li>
                <li class="list-group-item d-flex align-items-center">
                    <strong class="me-2">Mật khẩu:</strong>
                    <span class="d-inline-block" style="letter-spacing: 4px;">&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;</span>
                    <i class="bi bi-lock-fill text-muted ms-2"></i>
                </li>
                <li class="list-group-item">
                    <strong>Vai trò:</strong>
                    @if ($user->role?->name === 'admin')
                        <span class="badge bg-danger ms-2">Admin</span>
                    @elseif ($user->role?->name === 'user')
                        <span class="badge bg-success ms-2">User</span>
                    @else
                        <span class="badge bg-secondary ms-2">Chưa phân quyền</span>
                    @endif
                </li>
                <li class="list-group-item">
                    <strong>Trạng thái:</strong>
                    @if ($user->status === 'active')
                        <span class="badge bg-success ms-2">Hoạt động</span>
                    @else
                        <span class="badge bg-secondary ms-2">Không hoạt động</span>
                    @endif
                </li>
                <li class="list-group-item"><strong>Ngày tạo:</strong> {{ $user->created_at->format('d/m/Y H:i:s') }}</li>
                <li class="list-group-item"><strong>Ngày cập nhật:</strong> {{ $user->updated_at->format('d/m/Y H:i:s') }}</li>
                @if($user->deleted_at)
                    <li class="list-group-item text-danger">
                        <strong>Đã xoá lúc:</strong> {{ $user->deleted_at->format('d/m/Y H:i:s') }}
                    </li>
                @endif
            </ul>

            <div class="mt-4">
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Quay lại danh sách
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
