@extends('layout.master')
@section('title', 'Update Unit')

@section('site-name')
    @if(isset($unitData))
        <h1>{{ $unitData->name }}</h1>
    @else
        <h1>Javul.org</h1>
    @endif
    <div class="banner_desc d-md-block d-none">
        Open-source Society
    </div>
@endsection

@section('navbar')
    @if(isset($unitData))
        @include('layout.navbar', ['unitData' => $unitData])
    @endif
@endsection
@section('content')

    <div class="content_row">
        <div class="sidebar">
            @if(isset($unitData))
                @include('layout.v2.global-unit-overview')
                <?php
                $title = 'Activity Log';
                ?>
                @include('layout.v2.global-activity-log',['title' => $title, 'unit' => $unitData->id])

                @include('layout.v2.global-finances')

                @include('layout.v2.global-about-site')
            @else
                <?php
                $title = 'Global Activity Log';
                ?>
                @include('layout.v2.global-activity-log',['title' => $title])
            @endif
        </div>
        <div class="panel panel-grey panel-default">
            <div class="panel-heading">
                <h4>Update Unit</h4>
            </div>
            <div class="panel-body list-group">
                <div class="list-group-item">
                    <form role="form" method="post" id="form_sample_2" action="{{ url('units/' . $unitHashId) }}">
                        @csrf
                        @method('put')
                        <div class="row">
                                     <div class="col-sm-4 form-group">
                                  <label class="control-label">{{ __('messages.unit_name') }}</label>
                                  <div class="input-icon right">
                                      <input type="text" name="unit_name" value="{{ (!empty($unitObj))? $unitObj->name : old('unit_name') }}" class="form-control" placeholder="{{ __('messages.unit_name') }}"/>
                                  </div>
                              </div>

                                        <?php
                                        $edit_unit_category = [];
                                        if(!empty($unitObj))
                                            $edit_unit_category = explode(",",$unitObj->category_id);
                                        ?>
                                     <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label">{{ __('messages.unit_category') }} <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control selectpicker" data-live-search="true" name="unit_category[]" id="unit_category" multiple>
                                                @if(count($unit_category_arr) > 0)
                                                    @foreach($unit_category_arr as $id=>$val)
                                                        <option value="{{$id}}" @if(!empty($edit_unit_category) && in_array($id,$edit_unit_category)) selected=selected @endif>{{$val}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-4 form-group">
                                        <label class="control-label">Country<span class="text-danger">*</span></label>
                                        <select class="form-control selectpicker" data-live-search="true" id="country" name="country">
                                            <option value="">{!! trans('messages.select') !!}</option>
                                            @if(count($countries) > 0)
                                                @foreach($countries as $id=>$val)
                                                    @if($val == "dash_line" || $val == "dash_line1")
                                                        <option value="{{$id}}" disabled></option>
                                                    @else
                                                        <option value="{{$id}}" @if(!empty($unitObj) && $unitObj->country_id == $id)
                                                        selected=selected @endif>{{$val}}</option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <div class="col-sm-4 mt-3 form-group">
                                        <label class="control-label">State<span class="text-danger">*</span></label>
                                        <select class="form-control" data-live-search="true" name="state" id="state" @if(!empty($unitObj) && $unitObj->country_id == "global") disabled @endif>
                                            @if(!empty($unitObj))
                                                @foreach($states as $id=>$val)
                                                    <option value="{{$id}}" @if(!empty($unitObj) && $unitObj->state_id == $id)
                                                    selected=selected @endif>{{$val}}</option>
                                                @endforeach
                                            @else
                                                <option value="">{!! trans('messages.select') !!}</option>
                                            @endif
                                        </select>
                                        <span class="states_loader location_loader" style="display: none"><img src="{!! url('assets/images/small_loader.gif') !!}"/></span>
                                    </div>

                                    <div class="col-sm-4 mt-3 form-group">
                                        <label class="control-label">City<span class="text-danger">*</span></label>
                                        <select class="form-control" name="city" id="city" @if(!empty($unitObj) && $unitObj->country_id == "global")
                                        disabled @endif>
                                            @if(!empty($unitObj))
                                                @if(!empty($state_name_as_city_for_field))
                                                    <option value="{{$state_name_as_city_for_field->id}}" selected>{{$state_name_as_city_for_field->name}}</option>
                                                @else
                                                    @foreach($cities as $cid=>$val)
                                                        <option value="{{$cid}}" @if(!empty($unitObj) && $unitObj->city_id == $cid)
                                                        selected=selected @endif>{{$val}}</option>
                                                    @endforeach
                                                @endif
                                            @else
                                                <option value="">{{ __('messages.select') }}</option>
                                            @endif
                                        </select>
                                        <input type="hidden" name="empty_city_state_name" id="empty_city_state_name"
                                               @if(!empty($state_name_as_city_for_field)) value="{{$unitObj->state_id_for_city_not_exits}}" @endif/>
                                        <span class="cities_loader location_loader" style="display: none"><img src="{!! url('assets/images/small_loader.gif') !!}"/>
                                </span>
                                    </div>

                                    <div class="col-sm-4 mt-3 form-group">
                                        <label class="control-label">{{ __('messages.unit_credibility') }}<span class="text-danger">*</span></label>
                                        <select class="form-control" data-live-search="true" name="credibility">
                                            <option value="">{!! trans('messages.select') !!}</option>
                                            @if(count($unit_credibility_arr) > 0)
                                                @foreach($unit_credibility_arr as $id=>$val)
                                                    <option value="{{$id}}" @if(!empty($unitObj) && $unitObj->credibility == $id)
                                                    selected=selected @endif>{{$val}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <div class="col-sm-4 mt-3 form-group">
                                        <label class="control-label">Related To</label>
                                        <select class="form-control selectpicker" data-live-search="true" name="related_to[]" id="related_to" multiple>
                                            @if(count($relatedUnitsObj) > 0 )
                                                @foreach($relatedUnitsObj as $id=>$relate)
                                                    <option value="{{$id}}" @if(!empty($unitObj) && !empty($relatedUnitsofUnitObj) &&
                                                    in_array($id,$relatedUnitsofUnitObj)) selected=selected @endif>{{$relate}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <div class="col-sm-4 mt-3 form-group">
                                        <label class="control-label">Parent Unit</label>
                                        <select class="form-control selectpicker" data-live-search="true" name="parent_unit" id="parent_unit">
                                            <option value="">Select</option>
                                            @if(count($parentUnitsObj) > 0 )
                                                @foreach($parentUnitsObj as $id=>$parent)
                                                    <option value="{{$id}}" @if(!empty($unitObj) && $id == $unitObj->parent_id)
                                                        selected=selected @endif>{{$parent}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <div class="col-sm-12 mt-3 form-group">
                                        <label class="control-label">Unit Description</label>
                                        <textarea class="form-control" id="description" name="description">
                                              @if(!empty($unitObj)) {{ $unitObj->description }} @endif
                                         </textarea>
                                    </div>

                                    <div class="col-sm-12 mt-3 form-group">
                                        <label class="control-label">Comment</label>
                                        <input class="form-control" name="comment" @if(!empty($unitObj) && !empty($unitObj->comment))
                                        value="{{$unitObj->comment}}" @endif>
                                    </div>

                                    @if(!empty($unitObj) && $authUserObj->role == "superadmin")
                                        <div class="col-sm-4 form-group">
                                            <label class="control-label" style="width: 100%;">Status</label>
                                            <input data-toggle="toggle" data-on="Active" data-off="Disabled" type="checkbox" name="status" @if(!empty($unitObj) &&
                                                  $unitObj->status == "active") checked @elseif(empty($unitObj)) checked @endif>
                                        </div>
                                    @endif

                                    <div class="row justify-content-center mt-3">
                                        <div class="col-md-6 col-lg-4">
                                            <button class="btn btn-secondary btn-block" type="submit" id="update_unit">
                                                <i class="fa fa-plus"></i> <span class="plus_text">Update Unit</span>
                                            </button>
                                        </div>
                                    </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            ClassicEditor
                .create( document.querySelector( '#description' ) )
                .catch( error => {
                    console.error( error );
                } );

            $("#country").on('change',function(){
                var value = $(this).val();
                var token = $('[name="_token"]').val();
                if($.trim(value) == "" && value != 247){
                    $("#state").html('<option value="">Select</option>');
                    $("#city").html('<option value="">Select</option>');
                    $("#state").prop('disabled',false);
                    $("#city").prop('disabled',false);
                }
                else if($.trim(value) == 247){
                    $("#state").prop('disabled',true);
                    $("#city").prop('disabled',true);
                    return false;
                }
                else
                {
                    $(".states_loader.location_loader").show();
                    $("#state").prop('disabled',true);
                    $("#city").prop('disabled',true);
                    $.ajax({
                        type:'POST',
                        url:  '{{ url("units/get_state") }}',
                        dataType:'json',
                        async:true,
                        data:{country_id:value,_token:token },
                        success:function(resp){
                            $(".states_loader.location_loader").hide();
                            $("#state").prop('disabled',false);
                            $("#city").prop('disabled',false);
                            if(resp.success){
                                var html='<option value=""></option>';
                                $.each(resp.states,function(index,val){
                                    html+='<option value="'+index+'">'+val+'</option>'
                                });
                                $("#state").append(html);
                                $('.selectpicker').selectpicker('refresh');
                            }
                        }
                    })
                }
            });
            $("#state").on('change',function(){
                var value = $(this).val();
                var token = $('[name="_token"]').val();
                if($.trim(value) == ""){
                    $("#city").html('<option value="">Select</option>');
                    $("#city").prop('disabled',false);
                }
                else
                {
                    $(".cities_loader.location_loader").show();
                    $("#city").prop('disabled',true);
                    $.ajax({
                        type:'POST',
                        url: '{{ url("units/get_city") }}',
                        dataType:'json',
                        async:true,
                        data:{state_id:value,_token:token },
                        success:function(resp){

                            $(".cities_loader.location_loader").hide();
                            $("#city").prop('disabled',false);
                            if(resp.success){

                                if(Object.keys(resp.cities).length > 0)
                                {
                                    $.each(resp.cities,function(index,val){
                                        html ='<option value="'+index+'">'+val+'</option>'
                                    });
                                    $("#city").append(html);
                                    $('.selectpicker').selectpicker('refresh');
                                    $("#empty_city_state_name").val('');
                                }else{
                                    var html ='<option value="'+value+'">'+resp.state_name+'</option>';

                                    $("#city").append(html);
                                    $('.selectpicker').selectpicker('refresh');
                                    $("#empty_city_state_name").val(JSON.stringify([{"id":value,"name":resp.state_name}]));
                                }
                            }
                        }
                    })
                }
            });
        });
    </script>
@endsection
