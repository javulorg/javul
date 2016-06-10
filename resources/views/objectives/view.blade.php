@extends('layout.default')
@section('content')

<div class="container">
    <div class="row">
        @include('elements.user-menu',['page'=>'objectives'])
    </div>
    <div class="row form-group">
        <div class="col-sm-12">
            <div class="grey-bg both-div" style="min-height: 250px;">
                <div class="col-md-6 unit_description objective-desc">
                    <h1 class="unit-heading"><span class="glyphicon glyphicon-list-alt"></span> {{$objectiveObj->name}}</h1>
                    <div class="form-group">
                        {!! $objectiveObj->description !!}
                    </div>
                    <div>
                        @if(Auth::check())
                        <a class="btn orange-bg" id="edit_object" href="{!! url('objectives/edit/'.$objectiveIDHashID->encode($objectiveObj->id))!!}">
                            <span class="glyphicon glyphicon-pencil"></span> &nbsp;
                            {!! trans('messages.edit_objective') !!}
                        </a>
                        @endif
                    </div>

                </div>
                <div class="col-md-6 unit_description">
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="panel form-group marginTop10">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <strong>{!! trans('messages.unit_funds') !!}</strong>
                                        </div>
                                        <div class="col-xs-6">{!! trans('messages.available') !!}</div>
                                        <div class="col-xs-6 text-right">400 $</div>
                                        <div class="col-xs-6">{!! trans('messages.awarded') !!}</div>
                                        <div class="col-xs-6 text-right">100 $</div>
                                        <div class="col-xs-12 text-right">
                                            <button class="btn orange-bg btn-sm" id="add_funds_btn">{!! trans('messages.add_funds') !!}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <div class="panel form-group marginTop10">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <strong>{!! trans('messages.unit_information') !!}</strong>
                                        </div>
                                        <div class="col-xs-5">{!! trans('messages.unit_name') !!}</div>
                                        <div class="col-xs-7 text-right">Woman's Rights</div>
                                        <div class="col-xs-5">{!! trans('messages.type') !!}</div>
                                        <div class="col-xs-7 text-right">Non-profit-Human-welfare</div>
                                        <div class="col-xs-5">{!! trans('messages.funds') !!}</div>
                                        <div class="col-xs-7 text-right">Available 5000 $</div>
                                        <div class="col-xs-5">{!! trans('messages.awarded') !!}</div>
                                        <div class="col-xs-7 text-right">750 $</div>
                                        <div class="col-xs-12 text-right">
                                            <button class="btn orange-bg btn-sm" id="add_unit_fund_btn">{!! trans('messages.add_funds') !!}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row form-group">
        <div class="col-sm-6 col-xs-12">
            @include('elements.site_activities')
        </div>
    </div>
</div>
@include('elements.footer')
@endsection
@section('page-scripts')
<script>
    $(function(){
        $(".both-div").css("min-height",($(".objective-desc").height())+10+'px');
    })
</script>
@endsection