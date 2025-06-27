{{-- @extends('layout.master')
@section('title', 'Forgot Password')

@section('content')
<div class="row justify-content-center align-items-center">
    <div class="col-sm-offset-3 col-sm-6">
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif

        <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
            @csrf
            <div class="row mt-1 mb-2 form-group">
                <div class="col-sm-12">
                    <h4 class="form-signin-heading">{{ __('messages.enter_registered_email') }}</h4>
                </div>
            </div>

            <div class="row mt-1 mb-2 form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <div class="col-md-12">
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                        placeholder="{!! Lang::get('messages.email_address') !!}">
                    @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

            <div class="row mt-1 mb-2 form-group justify-content-center">
                <div class="col-sm-12 text-center">
                    <button class="btn btn-lg orange-bg btn-info" type="submit">
                        <i class="fa fa-btn fa-envelope"></i> {{ __('messages.send_password_reset_link') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection --}}

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
