@extends('layout.email')
@section('content')
<h3>Hi, {{$userObj->first_name.' '.$userObj->last_name}}</h3>
<p>Thank you for creating an account on javul.org .</p>
<p>Please confirm you email by clicking this <a href="{{\Config::get('app.url').'/verify_email/'.$token}}">link</a></p>
<p>Regards,</p>
<p>info@javul.org</p>
@endsection
