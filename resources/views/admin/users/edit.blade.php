@extends('layouts.admin')

@section('title', 'Sửa người dùng')

@section('content')
<div class="container mt-4">
    <div class="card shadow rounded-4">
        <div class="card-header bg-warning text-white">
            <h4 class="mb-0">Cập nhật trạng thái người dùng</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Trạng thái --}}
                <div class="mb-3">
                    <label for="status" class="form-label">Trạng thái</label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Hoạt động</option>
                        <option value="inactive" {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>Không hoạt động</option>
                    </select>
                    @error('status')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Nút --}}
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Hủy</a>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
