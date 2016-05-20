@extends('layout.default')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-offset-3 col-sm-6">
                <form class="form-signup">
                    <h2 class="form-signin-heading">{!! Lang::get('messages.please_signup') !!}</h2>
                    <div class="form-group">
                        <input name="name" type="text" id="name" class="form-control" placeholder="{!! Lang::get('messages.enter_fullname') !!}"
                               required="" autofocus="" />
                    </div>
                    <div class="form-group">
                        <input name="email" type="email" id="email" class="form-control" placeholder="{!! Lang::get('messages.email_address') !!}"
                               required="" >
                    </div>
                    <div class="form-group">
                        <input name="password" type="password" id="password" class="form-control" placeholder="{!! Lang::get('messages.enter_password') !!}"
                               required="">
                    </div>
                    <div class="form-group">
                        <input name="confirm_password" type="password" id="confirm_password" class="form-control"
                               placeholder="{!! Lang::get('messages.confirm_password') !!}" required="" />
                    </div>
                    <div class="form-group">
                        <button class="btn btn-lg orange-bg btn-block" type="submit">{!! Lang::get('messages.signup') !!}</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
    @include('elements.footer')
@endsection