<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Vui lòng nhập mã OTP đã gửi tới email của bạn.') }}
    </div>

    <form method="POST" action="{{ route('verify.otp') }}">
        @csrf

        <div>
            <x-input-label for="otp" :value="__('Mã OTP')" />
            <x-text-input id="otp" class="block mt-1 w-full" type="text" name="otp" required autofocus />
            <x-input-error :messages="$errors->get('otp')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ml-4">
                {{ __('Xác minh') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
