@extends('layout.default')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-offset-3 col-sm-6">
                <form class="form-signin">
                    <h2 class="form-signin-heading">{!! Lang::get('messages.please_signin') !!}</h2>
                    <div class="form-group">
                        <input name="email" type="email" id="email" class="form-control" placeholder="{!! Lang::get('messages.email_address') !!}"
                               required="" autofocus="">
                    </div>
                    <div class="form-group">
                        <input name="password" type="password" id="password" class="form-control" placeholder="{!! Lang::get('messages.enter_password') !!}"
                               required="">
                    </div>
                    <div class="form-gorup">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" value="remember-me"> {!! Lang::get('messages.remember_me') !!}
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-lg orange-bg btn-block" type="submit">{!! Lang::get('messages.sign_in') !!}</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
    @include('elements.footer')
@endsection