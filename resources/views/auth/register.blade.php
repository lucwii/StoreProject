@extends('layouts.public')

@section('title', 'Register')

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
            <h2 class="fw-bold mb-3">Registracija</h2>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3 text-start">
                    <label for="name" class="form-label fw-semibold">Ime i prezime:</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" class="form-control auth-input">
                    @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3 text-start">
                    <label for="email" class="form-label fw-semibold">Email:</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" class="form-control auth-input">
                    @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3 text-start">
                    <label for="password" class="form-label fw-semibold">Lozinka:</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password" class="form-control auth-input">
                    @error('password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3 text-start">
                    <label for="password_confirmation" class="form-label fw-semibold">Potvrdite lozinku:</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="form-control auth-input">
                    @error('password_confirmation') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <a class="small" href="{{ route('login') }}">Već registrovani?</a>
                    <button type="submit" class="btn btn-primary auth-btn">Registruj se</button>
                </div>
            </form>
        </div>
    </div>
@endsection
