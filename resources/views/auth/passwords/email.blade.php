
@extends('layout.master')
@section('title', 'Forgot Password')

@section('content')
<div class="reset-container">
    <div class="reset-box">
        <h4 class="mb-4 fw-semibold">Forgot Your Password?</h4>
        <p class="mb-4 text-muted small">
            Enter your registered email address and we’ll send you a link to reset your password.
        </p>

        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif

        <form method="POST" action="{{ url('/password/email') }}">
            @csrf
            <div class="mb-3">
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                    value="{{ old('email') }}" placeholder="Email address" required autofocus />
                @error('email')
                <div class="invalid-feedback text-start">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <button type="submit" class="btn btn-reset w-100">
                <i class="fas fa-envelope me-2"></i> Send Password Reset Link
            </button>
        </form>
    </div>
</div>
@endsection
