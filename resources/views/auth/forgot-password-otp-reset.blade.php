<x-guest-layout>
    <form method="POST" action="{{ route('password.otp.reset') }}">
        @csrf
        <div>
            <x-input-label for="password" value="Mật khẩu mới" />
            <x-text-input id="password" name="password" type="password" required />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" value="Xác nhận mật khẩu" />
            <x-text-input id="password_confirmation" name="password_confirmation" type="password" required />
        </div>

        <x-primary-button class="mt-4">Đặt lại mật khẩu</x-primary-button>
    </form>
</x-guest-layout>
