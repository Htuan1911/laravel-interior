@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Danh sách Vai trò</h2>
    <a href="{{ route('admin.roles.create') }}" class="btn btn-primary mb-2">Thêm mới</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên vai trò</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($roles as $role)
            <tr>
                <td>{{ $role->id }}</td>
                <td>{{ $role->name }}</td>
                <td>
                    <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                    <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
