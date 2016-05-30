@extends('layout.default')
@section('content')
<div class="container">
    <div class="row">
        @include('elements.user-menu',['page'=>'units'])
    </div>
    <div class="row form-group">
        <div class="col-sm-12 ">
            <div class="col-sm-6 grey-bg unit_grey_screen_height">
                <h1 class="unit-heading create_unit_heading"><span class="glyphicon glyphicon-list-alt"></span> Create Unit</h1><br /><br />
            </div>
            <div class="col-sm-6 grey-bg unit_grey_screen_height">
                <div class="row">
                    <div class="col-sm-offset-4 col-sm-8">
                        <div class="panel form-group marginTop20">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <strong>{!! trans('messages.unit_information')!!}</strong>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6">{!! trans('messages.total_units') !!}</div>
                                    <div class="col-xs-6 text-right">500</div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6">{!! trans('messages.total_fund_available') !!}</div>
                                    <div class="col-xs-6 text-right">7850 $</div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6">{!! trans('messages.total_fund_rewarded') !!}</div>
                                    <div class="col-xs-6 text-right">7500 $</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row form-group">
        <div class="col-sm-4">
            <label class="control-label">{!! trans('messages.unit_name')!!}</label>
            <input type="text" name="unit_name" value="{{ old('unit_name') }}" class="form-control"  placeholder="{!! trans('messages.unit_name') !!}"/>
        </div>
        <div class="col-sm-4">
            <label class="control-label">{!! trans('messages.unit_category') !!}</label>
            <select class="form-control" name="unit_category">
                <option value="">{!! trans('messages.select') !!}</option>
                @if(count($unit_category_arr) > 0)
                    @foreach($unit_category_arr as $id=>$val)
                        <option value="{{$id}}">{{$val}}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="col-sm-4">
            <label class="control-label">{!! trans('messages.unit_credibility') !!}</label>
            <select class="form-control" name="unit_credibility">
                <option value="">{!! trans('messages.select') !!}</option>
                @if(count($unit_credibility_arr) > 0)
                    @foreach($unit_credibility_arr as $id=>$val)
                        <option value="{{$id}}">{{$val}}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
    <div class="row form-group">
        <div class="col-sm-4">
            <select class="form-control" name="countries">
                <option value="">{!! trans('messages.select') !!}</option>
                @if(count($countries) > 0)
                    @foreach($countries as $id=>$val)
                        <option value="{{$id}}">{{$val}}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="col-sm-4">
            <div class="col-sm-4">
                <select class="form-control" name="states">
                    <option value="">{!! trans('messages.select') !!}</option>
                </select>
            </div>
        </div>
        <div class="col-sm-4">

        </div>
    </div>
    <div class="row form-group">
        <div class="col-sm-12">
            <button class="btn orange-bg" id="add_objective_btn" type="button"><span class="glyphicon glyphicon-plus"></span> {!! trans('messages.add_objective') !!}</button>
            <button class="btn orange-bg" id="see_all_objective_btn" type="button">{!! trans('messages.see_all_objectives') !!}</button>
        </div>
    </div>
</div>

@include('elements.footer')
@endsection