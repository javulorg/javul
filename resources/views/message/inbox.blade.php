@extends('layout.master')
@section('title', 'Message Inbox')

@section('content')
    <div class="row form-group">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Message Inbox</h4>
                </div>
                <div class="card-body list-group">
                    <div class="row">
                        <div class="col-md-2">
                            @include('message.menu', array())
                        </div>
                        <div class="col-md-10">
                            <ul class="list-group">
                                @foreach($messages['message'] as $key => $value)
                                    <li class="list-group-item">
                                        <a href="{{ url('message/view/'.$value['message_id']) }}">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="heading">
                                                    {{ $value['first_name'] }} {{ $value['last_name'] }}
                                                    <span class="time">{{ $value['datetime'] }}</span>
                                                </div>
                                                <div class="body">{{ $value['body'] }}</div>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                                @if(empty($messages['message']))
                                    <h4 class="text-center"><br><br>Your {{ $page }} is Empty </h4>
                                @endif
                            </ul>
                            <div class="pagination justify-content-center mt-3">
                                {!! $messages['pagination'] !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
