@extends('layout.master')
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
                            <input name="email" type="email" id="email" class="form-control" placeholder="Enter your email" required value="{{ old('email') }}">
                            @if ($errors->has('email'))
                                <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="mt-2 form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password">Password</label>
                            <input name="password" type="password" id="password" class="form-control" placeholder="Enter your password" required>
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
                            <a class="btn btn-link" href="{{ url('/password/reset') }}">{{ __('messages.forgot_password') }}</a>
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
@endsection
