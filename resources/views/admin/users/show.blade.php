@extends('layouts.admin')

@section('title', 'Chi tiết người dùng')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg rounded-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Chi tiết người dùng</h4>
            <a href="{{ route('admin.users.index') }}" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-left"></i> Quay lại
            </a>
        </div>

        <div class="card-body">
            <div class="row">
                {{-- Avatar --}}
                <div class="col-md-3 text-center mb-3">
                    @if ($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar"
                             class="rounded-circle img-thumbnail" style="width: 150px; height: 150px;">
                    @else
                        <img src="{{ asset('images/default-avatar.png') }}" alt="No avatar"
                             class="rounded-circle img-thumbnail" style="width: 150px; height: 150px;">
                    @endif
                </div>

                {{-- Thông tin người dùng --}}
                <div class="col-md-9">
                    <ul class="list-group list-group-flush fs-6">
                        <li class="list-group-item"><strong>ID:</strong> {{ $user->id }}</li>
                        <li class="list-group-item"><strong>Họ tên:</strong> {{ $user->name }}</li>
                        <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
                        <li class="list-group-item"><strong>SĐT:</strong> {{ $user->phone }}</li>
                        <li class="list-group-item"><strong>Địa chỉ:</strong> {{ $user->address ?? 'Chưa cập nhật' }}</li>

                        <li class="list-group-item d-flex align-items-center">
                            <strong class="me-2">Mật khẩu:</strong>
                            <span class="d-inline-block" style="letter-spacing: 4px;">••••••••</span>
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

                        @if ($user->deleted_at)
                            <li class="list-group-item text-danger">
                                <strong>Đã xoá lúc:</strong> {{ $user->deleted_at->format('d/m/Y H:i:s') }}
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
