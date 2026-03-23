<x-guest-layout>
    <div class="card shadow-sm rounded-4 p-4">
        <h4 class="fw-bold mb-3 text-center">{{ __('Forgot Password') }}</h4>
        <p class="text-muted small mb-4">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </p>

        <x-auth-session-status class="mb-3 alert alert-success" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-3">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus />
                <x-input-error :messages="$errors->get('email')" />
            </div>
            <div class="d-grid">
                <x-primary-button>{{ __('Email Password Reset Link') }}</x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
