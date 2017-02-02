@extends('layout.email')
@section('content')
<h3>Hi {{$name}},</h3>
<p>Visited URL: <a href="{{$url}}">{{$url}}</a></p>
<p>Message:{{$messages}}</p>
<p>Regards,</p>
<p>info@javul.org</p>
@endsection
