<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="uuid" value="{{ __('UUID') }}" />
                <x-inputs.text id="uuid" name="uuid" :value="old('uuid')" required autofocus autocomplete="uuid" />
                @error('uuid')
                <x-message.error>{{ $message }}</x-message.error>
                @enderror
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-inputs.password id="password" name="password" required autocomplete="current-password" />
                @error('password')
                <x-message.error>{{ $message }}</x-message.error>
                @enderror
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-buttons.submit class="ml-4">
                    {{ __('Log in') }}
                </x-buttons.submit>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
