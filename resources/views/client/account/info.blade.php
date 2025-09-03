@extends('layouts.cart')

@section('cart-content')
<div class="container py-5">
    <h2 class="mb-4">Thông tin cá nhân</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any() && !session('status'))
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form cập nhật thông tin cá nhân --}}
    <form method="POST" action="{{ route('client.account.update') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <!-- Ảnh đại diện -->
            <div class="col-md-3 text-center mb-4">
                <div class="avatar-wrapper mb-2">
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="avatar" class="rounded-circle shadow" style="width: 150px; height: 150px; object-fit: cover;">
                    @else
                        <img src="https://via.placeholder.com/150" class="rounded-circle shadow" alt="avatar" style="width: 150px; height: 150px; object-fit: cover;">
                    @endif
                </div>
                <input type="file" name="avatar" class="form-control">
            </div>

            <!-- Thông tin cơ bản -->
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Họ tên</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="phone" class="form-label">Số điện thoại</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="province" class="form-label">Tỉnh/Thành phố</label>
                        <input type="text" name="province" class="form-control" value="{{ old('province', $user->province) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="district" class="form-label">Quận/Huyện</label>
                        <input type="text" name="district" class="form-control" value="{{ old('district', $user->district) }}">
                    </div>
</div>
            </div>
        </div>
        <div class="text-end mt-3">
            <button type="submit" class="btn btn-primary">Cập nhật</button>
        </div>
    </form>

    {{-- Form đổi mật khẩu --}}
    <div class="mt-5">
        <h4>Đổi mật khẩu</h4>
 <form method="POST" action="{{ route('client.account.change_password') }}">
    @csrf
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="current_password" class="form-label">Mật khẩu hiện tại</label>
                    <input type="password" name="current_password" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="password" class="form-label">Mật khẩu mới</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="password_confirmation" class="form-label">Xác nhận mật khẩu mới</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-warning">Đổi mật khẩu</button>
                
            </div>
        </form>
        
        {{-- Thông báo đổi mật khẩu --}}
        @if(session('status') == 'password-updated')
            <div class="alert alert-success mt-3">Mật khẩu đã được cập nhật thành công!</div>
        @endif
        @error('current_password', 'updatePassword')
            <div class="alert alert-danger mt-2">{{ $message }}</div>
        @enderror
        @error('password', 'updatePassword')
            <div class="alert alert-danger mt-2">{{ $message }}</div>
        @enderror
    </div>

</div>
@endsection