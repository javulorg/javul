@extends('layout.default')
@section('content')
<div class="container">
    <div class="row form-group" style="margin-bottom:15px;">
        @include('elements.user-menu',['page'=>'units'])
    </div>
    <div class="row form-group">
        <div class="col-md-12">
            <div class="panel panel-grey panel-default">
                <div class="panel-heading">
                    <h4>{!! Lang::get('messages.activity_log') !!}</h4>
                </div>
                <div class="panel-body list-group">
                    @if(count($site_activity) > 0)
                    @foreach($site_activity as $activity)
                    <div class="list-group-item" style="padding: 0px;">
                        <div class="row" style="padding: 7px 15px">
                            <div class="col-xs-3 global_activity">
                                {!! \App\Library\Helpers::timetostr($activity->created_at) !!}
                            </div>
                            <div class="col-xs-2 text-center round_ line">
                                <div class="circle activity-refresh" style="width: 30px;">
                                    <i class="fa fa-refresh"></i>
                                </div>
                            </div>
                            <div class="col-xs-7">
                                {!! $activity->comment !!}
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <div class="list-group-item">
                        No activity found.
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@include('elements.footer')
@endsection
