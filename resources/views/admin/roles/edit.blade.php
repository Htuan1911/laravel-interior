@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Chỉnh sửa vai trò</h2>
    <form method="POST" action="{{ route('admin.roles.update', $role->id) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Tên vai trò</label>
            <input type="text" name="name" class="form-control" value="{{ $role->name }}">
        </div>
        <button type="submit" class="btn btn-success">Cập nhật</button>
        <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
