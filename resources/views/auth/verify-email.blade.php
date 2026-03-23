<x-guest-layout>
    <div class="card shadow-sm rounded-4 p-4 text-center">
        <h4 class="fw-bold mb-3">{{ __('Verify Email') }}</h4>
        <p class="text-muted small mb-3">
            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </p>

        @if (session('status') == 'verification-link-sent')
            <div class="alert alert-success small">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif

        <div class="d-flex align-items-center justify-content-between gap-3">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <x-primary-button>{{ __('Resend Verification Email') }}</x-primary-button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-link text-muted small">{{ __('Log Out') }}</button>
            </form>
        </div>
    </div>
</x-guest-layout>

</x-guest-layout>
