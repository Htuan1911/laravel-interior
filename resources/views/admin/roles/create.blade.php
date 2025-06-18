@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Thêm vai trò mới</h2>
    <form method="POST" action="{{ route('admin.roles.store') }}">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Tên vai trò</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
        </div>
        <button type="submit" class="btn btn-success">Tạo</button>
        <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
