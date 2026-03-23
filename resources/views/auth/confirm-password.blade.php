<x-guest-layout>
    <div class="card shadow-sm rounded-4 p-4">
        <h4 class="fw-bold mb-3 text-center">{{ __('Confirm Password') }}</h4>
        <p class="text-muted small mb-4">
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </p>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf
            <div class="mb-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" />
            </div>
            <div class="d-grid">
                <x-primary-button>{{ __('Confirm') }}</x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
