@extends('layout.default')
@section('content')
<div class="container">
    <div class="row">
        @include('elements.user-menu',['page'=>'units'])
    </div>
    <div class="row form-group">
        <div class="col-sm-12 ">
            <div class="col-sm-6 grey-bg unit_grey_screen_height">
                <h1 class="unit-heading create_unit_heading">
                    <span class="glyphicon glyphicon-list-alt"></span>
                    @if(empty($unitObj))
                        Create Unit
                    @else
                        Update Unit
                    @endif
                </h1><br /><br />
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
                                    <div class="col-xs-6 text-right">XXX</div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6">{!! trans('messages.total_fund_available') !!}</div>
                                    <div class="col-xs-6 text-right">XXX $</div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6">{!! trans('messages.total_fund_rewarded') !!}</div>
                                    <div class="col-xs-6 text-right">XXXX $</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form role="form" method="post" id="form_sample_2"  novalidate="novalidate" enctype="multipart/form-data">
        {!! csrf_field() !!}
        <div class="row">
            <div class="col-sm-4 form-group">
                <label class="control-label">{!! trans('messages.unit_name')!!}</label>
                <div class="input-icon right">
                    <i class="fa"></i>
                    <input type="text" name="unit_name" value="{{ (!empty($unitObj))? $unitObj->name : old('unit_name') }}"
                           class="form-control"
                           placeholder="{!! trans('messages.unit_name') !!}"/>
                </div>
            </div>
            <?php
            $edit_unit_category = [];
            if(!empty($unitObj))
                $edit_unit_category = explode(",",$unitObj->category_id);
            ?>
            <div class="col-sm-4 form-group">
                <label class="control-label">{!! trans('messages.unit_category') !!}</label>
                <div class="input-icon right">
                    <i class="fa select-error"></i>
                    <select class="form-control" name="unit_category[]" id="unit_category" multiple="multiple">
                        @if(count($unit_category_arr) > 0)
                            @foreach($unit_category_arr as $id=>$val)
                                <option value="{{$id}}" @if(!empty($edit_unit_category) && in_array($id,$edit_unit_category)) selected=selected @endif>{{$val}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="col-sm-4 form-group">
                <label class="control-label">{!! trans('messages.unit_credibility') !!}</label>
                <div class="input-icon right">
                    <i class="fa select-error"></i>
                    <select class="form-control" name="credibility">
                        <option value="">{!! trans('messages.select') !!}</option>
                        @if(count($unit_credibility_arr) > 0)
                            @foreach($unit_credibility_arr as $id=>$val)
                                <option value="{{$id}}" @if(!empty($unitObj) && $unitObj->credibility == $id)
                        selected=selected @endif>{{$val}}</option>
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

                                    <option value="{{$id}}" @if(!empty($unitObj) && $unitObj->country_id == $id)
                                    selected=selected @endif>{{$val}}</option>

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
                        @if(!empty($unitObj))
                            @foreach($states as $id=>$val)
                                <option value="{{$id}}" @if(!empty($unitObj) && $unitObj->state_id == $id)
                                selected=selected @endif>{{$val}}</option>
                            @endforeach
                        @else
                            <option value="">{!! trans('messages.select') !!}</option>
                        @endif
                    </select>
                    <span class="states_loader location_loader" style="display: none">
                        <img src="{!! url('assets/images/small_loader.gif') !!}"/>
                    </span>
                </div>
            </div>
            <div class="col-sm-4 form-group">
                <label class="control-label">City</label>
                <div class="input-icon right">
                    <i class="fa select-error"></i>
                    <select class="form-control" name="city" id="city">
                        @if(!empty($unitObj))
                            @foreach($cities as $cid=>$val)
                                <option value="{{$cid}}" @if(!empty($unitObj) && $unitObj->city_id == $cid)
                                selected=selected @endif>{{$val}}</option>
                            @endforeach
                        @else
                            <option value="">{!! trans('messages.select') !!}</option>
                        @endif
                    </select>
                    <span class="cities_loader location_loader" style="display: none">
                        <img src="{!! url('assets/images/small_loader.gif') !!}"/>
                    </span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4 form-group">
                <label class="control-label">Related To</label>
                <div class="input-icon right">
                    <i class="fa select-error"></i>
                    <select class="form-control" name="related_to[]" id="related_to" multiple="multiple">
                        @if(count($relatedUnitsObj) > 0 )
                            @foreach($relatedUnitsObj as $id=>$relate)
                                <option value="{{$id}}" @if(!empty($unitObj) && !empty($relatedUnitsofUnitObj) &&
                        in_array($id,$relatedUnitsofUnitObj)) selected=selected @endif>{{$relate}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="col-sm-4 form-group">
                <label class="control-label">Parent Unit</label>
                <div class="input-icon right">
                    <i class="fa select-error"></i>
                    <select class="form-control" name="parent_unit" id="parent_unit" >
                        <option value="">Select</option>
                        @if(count($parentUnitsObj) > 0 )
                            @foreach($parentUnitsObj as $id=>$parent)
                                <option value="{{$id}}" @if(!empty($unitObj) && $id == $unitObj->parent_id)
                        selected=selected @endif>{{$parent}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="col-sm-4 form-group">
                <label class="control-label" style="width: 100%;">Status</label>
                <input data-toggle="toggle" data-on="Active" data-off="Disabled" type="checkbox" name="status" @if(!empty($unitObj) &&
                $unitObj->status == "active") checked @endif>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 form-group">
                <label class="control-label">Unit Description</label>
                <textarea class="form-control" name="description">@if(!empty($unitObj)) {{$unitObj->description}} @endif</textarea>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-sm-12 ">
                <button class="btn orange-bg" id="create_unit" type="submit">
                    @if(!empty($unitObj))
                        <span class="glyphicon glyphicon-edit"></span> Update Unit
                    @else
                        <span class="glyphicon glyphicon-plus"></span> {!! trans('messages.create_unit') !!}
                    @endif
                </button>
            </div>
        </div>
    </form>
</div>
@include('elements.footer')
@stop
@section('page-scripts')
<script src="{!! url('assets/js/units/units.js') !!}"></script>
<script>
    $(function(){
        function format(country) {
            alert('d');
            if (country.id == "dash_line1" || country.id == "dash_line")
                return "<img class='flag' src='images/flags/" + state.id.toLowerCase() + ".png'/>" + state.text;
        }
        $("#country").select2({
			theme: "bootstrap",
            placeholder:"Select Country"/*,
            formatResult: format,
            formatSelection: format*/
        });

        $("#state").select2({
			theme: "bootstrap",
            placeholder:"Select State"
        });

        $("#city").select2({
			theme: "bootstrap",
            placeholder:"Select City"
        });

        $("#unit_category").select2({
			theme: "bootstrap",
            allowClear: true,
            placeholder: "Select an option"
        });

        $("#related_to").select2({
			theme: "bootstrap",
            allowClear: true,
            placeholder: "Select an option"
        });
    });

</script>
@endsection