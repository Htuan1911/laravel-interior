<x-guest-layout>
    <form method="POST" action="{{ route('password.otp.send') }}">
        @csrf
        <div>
            <x-input-label for="email" value="Nhập Email để nhận OTP" />
            <x-text-input id="email" name="email" type="email" required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <x-primary-button class="mt-4">Gửi mã OTP</x-primary-button>
    </form>
</x-guest-layout>
