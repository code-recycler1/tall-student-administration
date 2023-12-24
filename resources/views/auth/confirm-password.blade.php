<x-studentadministration-layout>
    <x-slot name="description">Confirm password</x-slot>
    <x-slot name="title">Confirm password</x-slot>

    <div class="flex justify-center">
        <img src="assets/icons/android-chrome-192x192.png" alt="tm_logo"/>
    </div>

    <x-layout.section class="grid grid-cols-1 max-w-md m-auto">

        <div class="mb-4 text-sm text-gray-600">
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </div>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div>
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" autofocus />
            </div>

            <div class="flex justify-end mt-4">
                <x-button class="ms-4">
                    {{ __('Confirm') }}
                </x-button>
            </div>
        </form>
    </x-layout.section>
</x-studentadministration-layout>
