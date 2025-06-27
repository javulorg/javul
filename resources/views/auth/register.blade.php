{{-- @extends('layout.master')
@section('title', 'Register')

@section('content')
<div class="row justify-content-center align-items-center">
    <div class="col-sm-6">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title text-center">{{ __('messages.please_signup') }}</h2>
                <form class="mt-4" id="register-form" role="form" method="POST" action="{{ url('/register') }}">
                    @csrf

                    <div class="form-group mb-2">
                        <label for="uname" class="form-label">User Name</label>
                        <input type="text" id="uname" class="form-control" required name="user_name"
                            value="{{ old('user_name') }}" placeholder="Enter user name">
                        @if ($errors->has('user_name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('user_name') }}</strong>
                        </span>
                        @elseif($errors->has('username_duplicate'))
                        <span class="help-block">
                            <strong>{{ $errors->first('username_duplicate') }}</strong>
                        </span>
                        @endif
                        <img id="user_img" src="" style="float: right;position: absolute;margin-top: 7px">
                    </div>

                    <div class="form-group mb-2">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}"
                            placeholder="Enter your first name" required>
                        @if ($errors->has('first_name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('first_name') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group mb-2">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input name="last_name" type="text" id="last_name" value="{{ old('last_name') }}"
                            placeholder="Enter your last name" class="form-control" required>
                        @if ($errors->has('last_name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('last_name') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group mb-2">
                        <label for="email" class="form-label">Email</label>
                        <input name="email" type="email" value="{{ old('email') }}" id="email"
                            placeholder="Enter your Email" class="form-control" required>
                        @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                        <img id="email_img" src="" style="float: right;position: absolute;margin-top: 7px">
                    </div>

                    <div class="form-group mb-2">
                        <label for="password" class="form-label">Password</label>
                        <input name="password" type="password" id="password" placeholder="Enter your password"
                            class="form-control" required>
                        @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group mb-2">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input name="password_confirmation" type="password" id="password_confirmation"
                            placeholder="Password confirmation" class="form-control" required>
                        @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                        @endif
                    </div>

                    <input type="hidden" name="g-recaptcha-response-name" id="g-recaptcha-response">
                    <div class="form-group mb-2">
                        <div class="g-recaptcha" data-sitekey="6LdqlBAnAAAAAKfLVMR-3BC4vWv35c4Z-2rvSP30"
                            data-callback="onSubmit" data-action="register-form" onclick="sendToken(event)"></div>
                        @if ($errors->has('g-recaptcha-response-name'))
                        <span style="color:#a94442">{{ $errors->first('g-recaptcha-response-name') }}</span>
                        @endif
                    </div>

                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary">{{ __('messages.signup') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function sendToken(e) {
            e.preventDefault();
            grecaptcha.ready(function () {
                grecaptcha.execute('6LdqlBAnAAAAAKfLVMR-3BC4vWv35c4Z-2rvSP30', {action: 'register-form'}).then(function (token) {
                    console.log(token);
                    document.getElementById('g-recaptcha-response').value = token;
                    document.getElementById('register-form').submit();
                });
            });
        }
</script>
@endsection
--}}

@extends('layout.master')
@section('title', 'Register')

@section('content')

<div class="signup-app">
    <div class="signup-card">
        <h3 class="text-center mb-4">{{ __('messages.please_signup') }}</h3>

        <form id="register-form" method="POST" action="{{ url('/register') }}">
            @csrf

            {{-- Username --}}
            <div class="mb-3 position-relative">
                <label class="form-label">User Name</label>
                <input type="text" name="user_name" class="form-control" value="{{ old('user_name') }}"
                    placeholder="Choose a username" required>
                @if ($errors->has('user_name'))
                <div class="help-block">{{ $errors->first('user_name') }}</div>
                @elseif($errors->has('username_duplicate'))
                <div class="help-block">{{ $errors->first('username_duplicate') }}</div>
                @endif
                <img id="user_img" src="">
            </div>

            {{-- First & Last Name --}}
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">First Name</label>
                    <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}"
                        placeholder="Enter your first name" required>
                    @if ($errors->has('first_name'))
                    <div class="help-block">{{ $errors->first('first_name') }}</div>
                    @endif
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Last Name</label>
                    <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}"
                        placeholder="Enter your last name" required>
                    @if ($errors->has('last_name'))
                    <div class="help-block">{{ $errors->first('last_name') }}</div>
                    @endif
                </div>
            </div>

            {{-- Email --}}
            <div class="mb-3 position-relative">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}"
                    placeholder="Enter your email" required>
                @if ($errors->has('email'))
                <div class="help-block">{{ $errors->first('email') }}</div>
                @endif
                <img id="email_img" src="">
            </div>

            {{-- Password --}}
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter your password"
                        required>
                    @if ($errors->has('password'))
                    <div class="help-block">{{ $errors->first('password') }}</div>
                    @endif
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control"
                        placeholder="Confirm password" required>
                    @if ($errors->has('password_confirmation'))
                    <div class="help-block">{{ $errors->first('password_confirmation') }}</div>
                    @endif
                </div>
            </div>

            {{-- reCAPTCHA --}}
            <input type="hidden" name="g-recaptcha-response-name" id="g-recaptcha-response">
            <div class="mb-3">
                <div class="g-recaptcha" data-sitekey="6LdqlBAnAAAAAKfLVMR-3BC4vWv35c4Z-2rvSP30"
                    data-callback="onSubmit" data-action="register-form" onclick="sendToken(event)"></div>
                @if ($errors->has('g-recaptcha-response-name'))
                <div class="help-block">{{ $errors->first('g-recaptcha-response-name') }}</div>
                @endif
            </div>

            {{-- Submit --}}
            <div class="d-grid mb-2">
                <button type="submit" class="btn btn-signup">
                    <i class="fas fa-user-plus me-2"></i> {{ __('messages.signup') }}
                </button>
            </div>

            <div class="text-center mt-3">
                <span>Already have an account?</span>
                <a href="{{ url('/login') }}" class="text-decoration-none fw-bold ms-1">
                    <i class="fas fa-sign-in-alt me-1"></i> Login
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function sendToken(e) {
            e.preventDefault();
            grecaptcha.ready(function () {
                grecaptcha.execute('6LdqlBAnAAAAAKfLVMR-3BC4vWv35c4Z-2rvSP30', {action: 'register-form'}).then(function (token) {
                    document.getElementById('g-recaptcha-response').value = token;
                    document.getElementById('register-form').submit();
                });
            });
        }
</script>
@endsection
