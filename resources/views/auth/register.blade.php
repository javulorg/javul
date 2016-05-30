@extends('layout.default')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-offset-3 col-sm-6">
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                {!! csrf_field() !!}

                <div class="form-group row">
                    <div class="col-sm-12">
                        <h2 class="form-signin-heading">{!! Lang::get('messages.please_signup') !!}</h2>
                    </div>
                </div>
                <div class="row form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                    <div class="col-md-12">
                        <input type="text" class="form-control" required="" name="first_name" value="{{ old('first_name') }}"  placeholder="{!!
                        Lang::get('messages.enter_firstname') !!}">
                        @if ($errors->has('first_name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('first_name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="row form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                    <div class="col-md-12">
                        <input name="last_name" type="text" required="" id="last_name" value="{{ old('last_name') }}" class="form-control"
                               placeholder="{!! Lang::get('messages.enter_lastname') !!}"/>
                        @if ($errors->has('last_name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('last_name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="row form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <div class="col-md-12">
                        <input name="email" type="email" value="{{ old('email') }}" id="email" class="form-control" placeholder="{!! Lang::get('messages.email_address') !!}"
                               required="" >

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="row form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                    <div class="col-md-12">
                        <textarea name="address" value="{{ old('address') }}" id="address" class="form-control"
                                  placeholder="{!! Lang::get('messages.address') !!}"></textarea>
                        @if ($errors->has('address'))
                            <span class="help-block">
                                <strong>{{ $errors->first('address') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="row form-group{{ ($errors->has('country') || $errors->has('state') || $errors->has('city')) ? 'has-error': '' }}">
                    <div class="col-sm-4">
                        <select name="country" id="country" class="form-control">
                            <option value="">Select Country</option>
                            <option value="1">Australia</option>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <select name="state" id="state" class="form-control">
                            <option value="">Select State</option>
                            <option value="1">Melbourne</option>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <select name="city" id="city" class="form-control">
                            <option value="">Select City</option>
                            <option value="1">Melbourne</option>
                        </select>
                    </div>
                </div>

                <div class="row form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <div class="col-md-12">
                        <input name="password" type="password" id="password" class="form-control" placeholder="{!! Lang::get('messages.enter_password') !!}"
                               required="">
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="row form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                    <div class="col-md-12">
                        <input name="password_confirmation" type="password" id="password_confirmation" class="form-control"
                               placeholder="{!! Lang::get('messages.confirm_password') !!}" required="" />

                        @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-sm-12">
                        <button class="btn btn-lg orange-bg btn-block" type="submit">
                            <i class="fa fa-btn fa-user"></i> {!! Lang::get('messages.signup') !!}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@include('elements.footer')
@endsection
