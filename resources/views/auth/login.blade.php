{{-- @extends('layout.master')
@section('title', 'Login')

@section('content')

<div class="row justify-content-center align-items-center">
    <div class="col-sm-6">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title text-center">{{ __('messages.please_signin') }}</h2>
                <form class="mt-4" method="POST" action="{{ url('/login') }}">
                    @csrf
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email">Email</label>
                        <input name="email" type="email" id="email" class="form-control" placeholder="Enter your email"
                            required value="{{ old('email') }}">
                        @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="mt-2 form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password">Password</label>
                        <input name="password" type="password" id="password" class="form-control"
                            placeholder="Enter your password" required>
                        @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group form-check mt-1">
                        <input type="checkbox" name="remember" id="remember" class="form-check-input">
                        <label for="remember" class="form-check-label">{{ __('messages.remember_me') }}</label>
                    </div>

                    <div class="form-group text-center">
                        <button class="btn btn-primary" type="submit">
                            <i class="fa fa-sign-in" aria-hidden="true"></i>
                            {{ __('messages.sign_in') }}
                        </button>
                    </div>

                    <div class="form-group text-center">
                        <a class="btn btn-link" href="{{ url('/password/reset') }}">{{ __('messages.forgot_password')
                            }}</a>
                    </div>

                    <div class="form-group text-center">
                        <a class="btn btn-link" href="{{ url('/register') }}">
                            <i class="fa fa-user-plus" aria-hidden="true"></i>
                            <strong>Don't have an account? Sign Up</strong>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection --}}
@extends('layout.master')
@section('title', 'Login')

@section('content')


<div class="login-app">
    <div class="login-card">
        <h3 class="text-center mb-4">{{ __('messages.please_signin') }}</h3>

        <form method="POST" action="{{ url('/login') }}">
            @csrf

            {{-- Email --}}
            <div class="mb-3 position-relative">
                <i class="fas fa-envelope input-icon"></i>
                <input name="email" type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                    placeholder="Enter your email" value="{{ old('email') }}" required autofocus>
                @if ($errors->has('email'))
                <div class="invalid-feedback d-block">
                    {{ $errors->first('email') }}
                </div>
                @endif
            </div>

            {{-- Password --}}
            <div class="mb-3 position-relative">
                <i class="fas fa-lock input-icon"></i>
                <input name="password" type="password"
                    class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                    placeholder="Enter your password" required>
                @if ($errors->has('password'))
                <div class="invalid-feedback d-block">
                    {{ $errors->first('password') }}
                </div>
                @endif
            </div>

            {{-- Remember & Forgot --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember">
                        {{ __('messages.remember_me') }}
                    </label>
                </div>
                <a href="{{ url('/password/reset') }}" class="text-decoration-none">{{
                    __('messages.forgot_password') }}</a>
            </div>

            {{-- Login Button --}}
            <div class="d-grid mb-3">
                <button type="submit" class="btn login-btn">
                    <i class="fas fa-arrow-right me-2"></i> {{ __('messages.sign_in') }}
                </button>
            </div>

            {{-- Register --}}
            <div class="text-center link-group">
                <span>Don't have an account?</span>
                <a href="{{ url('/register') }}" class="text-decoration-none fw-bold ms-1">
                    <i class="fas fa-user-plus"></i> Sign Up
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
