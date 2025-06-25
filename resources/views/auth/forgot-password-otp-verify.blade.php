<x-guest-layout>
    <form method="POST" action="{{ route('password.otp.verify') }}">
        @csrf
        <div>
            <x-input-label for="otp" value="Nhập mã OTP" />
            <x-text-input id="otp" name="otp" type="text" required />
            <x-input-error :messages="$errors->get('otp')" class="mt-2" />
        </div>

        <x-primary-button class="mt-4">Xác minh OTP</x-primary-button>
    </form>
</x-guest-layout>
