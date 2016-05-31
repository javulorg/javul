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
    <form role="form" method="post" id="form_sample_2"  novalidate="novalidate" enctype="multipart/form-data">
        <div class="row">
            <div class="col-sm-4 form-group">
                <label class="control-label">{!! trans('messages.unit_name')!!}</label>
                <div class="input-icon right">
                    <i class="fa"></i>
                    <input type="text" name="unit_name" value="{{ old('unit_name') }}" class="form-control"  placeholder="{!! trans('messages.unit_name') !!}"/>
                </div>
            </div>
            <div class="col-sm-4 form-group">
                <label class="control-label">{!! trans('messages.unit_category') !!}</label>
                <div class="input-icon right">
                    <i class="fa select-error"></i>
                    <select class="form-control" name="unit_category">
                        <option value="">{!! trans('messages.select') !!}</option>
                        @if(count($unit_category_arr) > 0)
                            @foreach($unit_category_arr as $id=>$val)
                                <option value="{{$id}}">{{$val}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="col-sm-4 form-group">
                <label class="control-label">{!! trans('messages.unit_credibility') !!}</label>
                <div class="input-icon right">
                    <i class="fa select-error"></i>
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
        </div>
        <div class="row">
            <div class="col-sm-4 form-group">
                <label class="control-label">Country</label>
                <div class="input-icon right">
                    <i class="fa select-error"></i>
                    <select class="form-control" name="country" id="country">
                        <option value="">{!! trans('messages.select') !!}</option>
                        @if(count($countries) > 0)
                            @foreach($countries as $id=>$val)
                                <option value="{{$id}}">{{$val}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="col-sm-4 form-group">
                <label class="control-label">State</label>
                <div class="input-icon right">
                    <i class="fa select-error"></i>
                    <select class="form-control" name="state" id="state">
                        <option value="">{!! trans('messages.select') !!}</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-4 form-group">
                <label class="control-label">City</label>
                <div class="input-icon right">
                    <i class="fa select-error"></i>
                    <select class="form-control" name="city" id="city">
                        <option value="">{!! trans('messages.select') !!}</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4 form-group">
                <label class="control-label">Related To</label>
                <div class="input-icon right">
                    <i class="fa select-error"></i>
                    <select class="form-control" name="related_to">
                        <option value="">{!! trans('messages.select') !!}</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-4 form-group">
                <label class="control-label">Parent Unit</label>
                <div class="input-icon right">
                    <i class="fa select-error"></i>
                    <select class="form-control" name="parent_unit">
                        <option value="">{!! trans('messages.select') !!}</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-4 form-group">
                <label class="control-label" style="width: 100%;">Status</label>
                <input data-toggle="toggle" data-on="Active" data-off="Disabled" type="checkbox" name="status">
            </div>
        </div>
        <div class="row form-group">
            <div class="col-sm-12">
                <button class="btn orange-bg" id="create_unit" type="submit"><span class="glyphicon glyphicon-plus"></span> {!! trans
                    ('messages.create_unit') !!}</button>
            </div>
        </div>
    </form>
</div>
@include('elements.footer')
@stop
@section('page-scripts')
<script src="{!! url('assets/js/units/units.js') !!}"></script>
@endsection