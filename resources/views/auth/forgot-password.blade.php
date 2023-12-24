<x-studentadministration-layout>
    <x-slot name="description">Forgot password?</x-slot>
    <x-slot name="title">Forgot password?</x-slot>

    <div class="flex justify-center">
        <img src="assets/icons/android-chrome-192x192.png" alt="tm_logo"/>
    </div>

    <x-layout.section class="grid grid-cols-1 max-w-md m-auto">

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="block">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{ __('Email Password Reset Link') }}
                </x-button>
            </div>
        </form>
    </x-layout.section>
</x-studentadministration-layout>
