@extends('layouts.public')

@section('title', 'Login')

@push('styles')
<style>
    body { background: #f4a46a !important; }
    .auth-card { width: 420px; background: #e6e6e6; border-radius: 24px; padding: 28px; }
    .auth-input { border-radius: 22px; height: 38px; }
    .auth-btn { border-radius: 22px; padding: 8px 34px; }
    .auth-small { font-size: 12px; }
</style>
@endpush

@section('content')
    <div class="d-flex justify-content-center align-items-center" style="min-height:70vh;">
        <div class="auth-card text-center shadow-sm">
            @if (session('status'))
                <div class="alert alert-info">{{ session('status') }}</div>
            @endif

            <h2 class="fw-bold mb-3">Login</h2>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3 text-start">
                    <label for="email" class="form-label fw-semibold">Unesite email:</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="form-control auth-input">
                    @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3 text-start">
                    <label for="password" class="form-label fw-semibold">Unesite lozinku:</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password" class="form-control auth-input">
                    @error('password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="form-check text-start">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                        <label class="form-check-label small" for="remember_me">Zapamti me</label>
                    </div>

                    <div>
                        @if (Route::has('password.request'))
                            <a class="small" href="{{ route('password.request') }}">Zaboravili ste lozinku?</a>
                        @endif
                    </div>
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary auth-btn">Login</button>
                </div>

                <div class="small auth-small">
                    Nemate nalog? <a href="{{ route('register') }}">Registrujte se</a>
                </div>
            </form>
        </div>
    </div>
@endsection
