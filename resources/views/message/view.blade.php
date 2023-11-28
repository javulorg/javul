@extends('layout.master')
@section('title', 'View Message')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ $message['subject'] }}
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            @include('message.menu', array())
                        </div>
                        <div class="col-md-8">
                            <div class="bodyMSG col-md-12">
                                <div class="name">
                                    {{ $message['to'] == $myId ? 'From' : 'To' }} :
                                    <a href="{{ $message['link'] }}">
                                        {{ $message['first_name'] }} {{ $message['last_name'] }}
                                    </a> {{ $message['datetime'] }}
                                </div>
                                <br>{!! $message['body'] !!}</div>
                        </div>
                        <div class="clearfix"></div>
                        <a href="{{ url('message/send').'/'.$message['from'] }}" class="btn btn-dark float-end">Reply</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
