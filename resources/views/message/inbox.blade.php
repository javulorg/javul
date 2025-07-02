@extends('layout.master')
@section('title', 'Message ' . ucfirst($page))

@section('content')
<div class="inbox-app">
    <div class="card card-custom">
        <div class="row g-0">
            <!-- Sidebar -->
            <div class="col-md-3 bg-light border-end p-3">
                @include('message.menu', [])
            </div>

            <!-- Content Area -->
            <div class="col-md-9 p-4">
                @if (!empty($messages['message']))
                    <div id="inboxList">
                        <h5 class="mb-4">{{ ucfirst($page) }}</h5>

                        <ul class="list-group">
                            @foreach($messages['message'] as $value)
                                <li class="list-group-item list-group-item-action">
                                    <a href="{{ url('message/view/'.$value['message_id']) }}" class="text-decoration-none text-dark d-block">
                                        <div class="me-auto">
                                            <div>
                                                <span class="fw-bold">{{ $value['subject'] ?? 'No Subject' }}</span> -
                                                <span class="text-muted fw-light">
                                                    {{ \Illuminate\Support\Str::words($value['body'] ?? '', 13, '...') }}
                                                </span>
                                            </div>
                                            <div class="fw-bold my-1">
                                                {{ request()->is('inbox') ? 'From:' : 'To:' }}
                                                {{ $value['first_name'] }} {{ $value['last_name'] }}
                                            </div>
                                            <small class="text-muted">{{ $value['datetime'] ?? '' }}</small>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="pagination justify-content-center mt-3">
                        {!! $messages['pagination'] !!}
                    </div>
                @else
                    <div class="text-center text-muted py-5">
                        <i class="fas fa-inbox fa-3x mb-3"></i>
                        <h5>Your {{ ucfirst($page) }} is Empty</h5>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
