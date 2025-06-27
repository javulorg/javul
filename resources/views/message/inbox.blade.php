{{-- @extends('layout.master')
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
@endsection --}}

@extends('layout.master')
@section('title', 'Message Inbox')

@section('content')
<div class="inbox-app">
    <div class="card card-custom">
        <div class="row g-0">
            <!-- Sidebar -->
            <div class="col-md-3 sidebar bg-light border-end p-3">
                @include('message.menu', [])
            </div>

            <!-- Inbox Content -->
            <div class="col-md-9">
                <div class="tab-content">
                    <div class="tab-pane fade show active">
                        <h5 class="mb-4">Inbox</h5>

                        @if (!empty($messages['message']))
                        <ul class="list-group">
                            @foreach($messages['message'] as $message)
                            <a href="{{ url('message/view/'.$message['message_id']) }}"
                                class="list-group-item list-group-item-action">
                                <div class="d-flex justify-content-between">
                                    <div class="message-header">
                                        {{ $message['first_name'] }} {{ $message['last_name'] }}
                                        <div class="message-time">{{ $message['datetime'] }}</div>
                                    </div>
                                    <div class="text-truncate" style="max-width: 60%">
                                        {{ Str::limit($message['body'], 80) }}
                                    </div>
                                </div>
                            </a>
                            @endforeach
                        </ul>

                        <div class="pagination justify-content-center">
                            {!! $messages['pagination'] !!}
                        </div>
                        @else
                        <div class="text-center text-muted py-5">
                            <i class="fas fa-inbox fa-3x mb-3"></i>
                            <h5>Your {{ $page }} is Empty</h5>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
