@extends('layout.default')
@section('page-css')
<link href="{!! url('assets/plugins/bootstrap-multiselect/bootstrap-multiselect.css') !!}" rel="stylesheet" type="text/css" />
<link href="{!! url('assets/plugins/bootstrap-fileinput/bootstrap-fileinput.css') !!}" rel="stylesheet" type="text/css" />
<link href="{!! url('assets/plugins/bootstrap-summernote/summernote.css') !!}" rel="stylesheet" type="text/css" />

<style>
    .hide-native-select .btn-group, .hide-native-select .btn-group .multiselect, .hide-native-select .btn-group.multiselect-container
    {width:100% !important;}
</style>
@endsection
@section('content')
<div class="container">
    <div class="row">
        @include('elements.user-menu',['page'=>'tasks'])
    </div>
    <div class="row form-group">
        <div class="col-sm-12 ">
            <div class="col-sm-6 grey-bg unit_grey_screen_height">
                <h1 class="unit-heading create_unit_heading">
                    <span class="glyphicon glyphicon-list-alt"></span>
                    @if(empty($taskObj))
                    Create Task
                    @else
                    Update Task
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
                                        <strong>Task Information</strong>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6">Total Tasks</div>
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
            <div class="col-sm-4 form-group {{ $errors->has('unit') ? ' has-error' : '' }}">
                <label class="control-label">Select Unit</label>
                <div class="input-icon right">
                    <i class="fa select-error"></i>
                    <select name="unit" id="unit" class="form-control">
                        <option value="">Select</option>
                        @if(count($unitsObj) > 0)
                            @foreach($unitsObj as $unit_id=>$unit)
                                <option value="{{$unitIDHashID->encode($unit_id)}}" @if(!empty($objectiveObj) && $objectiveObj->unit_id ==
                                $unit_id) selected=selected @endif>{{$unit}}</option>
                            @endforeach
                        @endif
                    </select>
                    @if ($errors->has('unit'))
                        <span class="help-block">
                            <strong>{{ $errors->first('unit') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-4 form-group {{ $errors->has('objective') ? ' has-error' : '' }}">
                <label class="control-label">Select Objective</label>
                <div class="input-icon right">
                    <i class="fa select-error"></i>
                    <select name="objective" id="objective" class="form-control">
                        <option value="">Select</option>
                    </select>
                    @if ($errors->has('objective'))
                        <span class="help-block">
                            <strong>{{ $errors->first('objective') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-4 form-group {{ $errors->has('task_name') ? ' has-error' : '' }}">
                <label class="control-label">Task Name</label>
                <div class="input-icon right">
                    <i class="fa"></i>
                    <input type="text" name="task_name" value="{{ (!empty($taskObj))? $taskObj->name : old('task_name') }}"
                           class="form-control"
                           placeholder="Task Name"/>
                    @if ($errors->has('task_name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('task_name') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4 form-group {{ $errors->has('task_skills') ? ' has-error' : '' }}">
                <label class="control-label">Task Skills</label>
                <div class="input-icon right">
                    <i class="fa select-error"></i>
                    <select name="task_skills" class="form-control" id="task_skills" multiple="multiple">
                        <option value="">Select</option>
                        @if(!empty($task_skills))
                            @foreach($task_skills as $skill_id=>$skill)
                                <option value="{{$skill_id}}">{{$skill}}</option>
                            @endforeach
                        @endif
                    </select>
                    @if ($errors->has('task_skills'))
                        <span class="help-block">
                            <strong>{{ $errors->first('task_skills') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-4 form-group {{ $errors->has('estimated_completion_time_start') ? ' has-error' : '' }}">
                <label class="control-label">Estimated Completion Time From</label>
                <div class="input-group date" id='datetimepicker1'>
                    <div class="input-icon right">
                        <i class="fa"></i>
                        <input type="text" id="estimated_completion_time_start" name="estimated_completion_time_start" value="{{ (!empty($taskObj))?
                        $taskObj->name :
                        old('estimated_completion_time_start') }}" class="form-control" placeholder="Estimated Completion Time From"/>
                    </div>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                    @if ($errors->has('estimated_completion_time_start'))
                        <span class="help-block">
                            <strong>{{ $errors->first('estimated_completion_time_start') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-4 form-group {{ $errors->has('estimated_completion_time_end') ? ' has-error' : '' }}">
                <label class="control-label">Estimated Completion Time To</label>
                <div class="input-group date" id='datetimepicker2'>
                    <div class="input-icon right">
                        <i class="fa"></i>
                        <input type="text" id="estimated_completion_time_end" name="estimated_completion_time_end" value="{{ (!empty($taskObj))?
                        $taskObj->name :
                        old('estimated_completion_time_end') }}" class="form-control" placeholder="Estimated Completion Time To"/>
                    </div>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                    @if ($errors->has('estimated_completion_time_end'))
                        <span class="help-block">
                            <strong>{{ $errors->first('estimated_completion_time_end') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <!--<div class="col-sm-4 form-group">
                <label class="control-label">Assigned To</label>
                <div class="input-icon right">
                    <i class="fa select-error"></i>
                    <select name="assigned_to" class="form-control" id="assigned_to">
                        <option value="">Select</option>
                        @if(!empty($assigned_toUsers))
                        @foreach($assigned_toUsers as $user_id=>$user_name)
                        <option value="{{$userIDHashID->encode($user_id)}}">{{$user_name}}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
            </div>-->
            <div class="col-sm-4 form-group">
                <label class="control-label">Compensation</label>
                <div class="input-icon right">
                    <i class="fa"></i>
                    <input type="text" name="compensation" value="{{ (!empty($taskObj))? $taskObj->name : old('compensation') }}"
                           class="form-control onlyDigits"
                           placeholder="Compensation"/>
                </div>
            </div>
            <div class="col-sm-4 form-group">

            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 form-group">
                <div class="document_listing_div">
                    <div class="table-responsive">
                        <table class="documents table table-striped">
                            <thead>
                                <tr>
                                    <th>Documents</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($taskDocumentsObj))
                                <tr>
                                    <td>
                                        <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                            <div class="form-control" data-trigger="fileinput">
                                                <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                                <span class="fileinput-filename"></span>
                                            </div>
                                            <span class="input-group-addon btn btn-default btn-file">
                                                <span class="fileinput-new">Select file</span>
                                                <span class="fileinput-exists">Change</span>
                                                <input type="file" name="document">
                                            </span>
                                            <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="#" class="remove-row text-danger" data-id="{{$hashID->encode($unit->id)}}">
                                            <i class="fa fa-remove"></i>
                                        </a>
                                        <?php $addMoreUnitClass = "";?>
                                        @if(count($propertyObj->units) > 1)
                                        <?php $addMoreUnitClass = "hide";?>
                                        @endif
                                        @if(count($propertyObj->units) == $i)
                                        <?php $addMoreUnitClass = "";?>
                                        @endif
                                        <span class="{{$addMoreUnitClass}}">
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <a href="#" class="addMoreUnit">
                                                <i class="fa fa-plus"></i>
                                            </a>
                                        </span>
                                    </td>
                                </tr>
                            @else
                                <tr>
                                    <td style="width:90%;">
                                        <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                            <div class="form-control" data-trigger="fileinput">
                                                <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                                <span class="fileinput-filename"></span>
                                            </div>
                                            <span class="input-group-addon btn btn-default btn-file">
                                                <span class="fileinput-new">Select file</span>
                                                <span class="fileinput-exists">Change</span>
                                                <input type="file" name="documents[]">
                                            </span>
                                            <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                        </div>
                                    </td>
                                    <td>
                                        <span>
                                            <a href="#" class="remove-row text-danger hide" >
                                                <i class="fa fa-remove"></i>
                                            </a>
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <a href="#" class="addMoreDocument">
                                                <i class="fa fa-plus"></i>
                                            </a>
                                        </span>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 form-group">
                <label class="control-label">Action Items</label>
                <textarea class="form-control" name="action_items" id="action_items">@if(!empty($taskObj)) {{$taskObj->summary}} @endif</textarea>
                <div class="all_action_items">
                    <input type="hidden" name="action_items_array[]" id="action_items_array" class="action_items_class"/>
                </div>
            </div>
            <div class="col-sm-12 form-group">
                <label class="control-label">Summary</label>
                <textarea class="form-control summernote" name="summary">@if(!empty($taskObj)) {{$taskObj->summary}} @endif</textarea>
            </div>
            <div class="col-sm-12 form-group">
                <label class="control-label">Description</label>
                <textarea class="form-control summernote" name="description">@if(!empty($taskObj)) {{$taskObj->description}} @endif</textarea>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-sm-12 ">
                <button class="btn orange-bg" id="create_objective" type="submit">
                    @if(!empty($taskObj))
                        <span class="glyphicon glyphicon-edit"></span> Update Task
                    @else
                        <span class="glyphicon glyphicon-plus"></span> Create Task
                    @endif
                </button>
            </div>
        </div>
    </form>
</div>
@include('elements.footer')
@stop
@section('page-scripts')
<script src="{!! url('assets/plugins/bootstrap-multiselect/bootstrap-multiselect.js') !!}" type="text/javascript"></script>
<script src="{!! url('assets/plugins/bootstrap-fileinput/bootstrap-fileinput.js') !!}" type="text/javascript"></script>
<script src="{!! url('assets/plugins/bootstrap-summernote/summernote.min.js') !!}" type="text/javascript"></script>
<script>
    $(function(){
        $('#datetimepicker1').datetimepicker({
            format: 'DD/MM/YYYY HH:mm',
            minDate:moment()
        });

        $('#datetimepicker2').datetimepicker({
            format: 'DD/MM/YYYY HH:mm',
            minDate:moment()
        });

        $('.summernote').summernote({
            height:100
        });

        $("#action_items").summernote({
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', []],
                ['fontsize', []],
                ['color', []],
                ['para', []],
                ['height', []]
            ]
        });

        $('#action_items').summernote('insertUnorderedList');


        $("#unit").select2({
            allowClear:true,
            placeholder:"Select Unit"
        });

        $("#objective").select2({
            allowClear:true,
            placeholder:"Select Objective"
        });

        $("#task_skills").select2({
            allowClear:true,
            placeholder:"Select Skills"
        });

        $("#unit").on('change',function(){
            var unit_val = $(this).val();
            var token = $('[name="_token"]').val();
            if($.trim(unit_val) == "")
            {
                $("#objective").html('<option value="">Select</option>');
                return false;
            }
            $.ajax({
                type:'POST',
                url:siteURL+'/tasks/get_objective',
                dataType:'json',
                async:false,
                data:{unit_id:unit_val,_token:token },
                success:function(resp){
                    if(resp.success){
                        var html='<option value="">Select</option>';
                        $.each(resp.objectives,function(index,val){
                            html+='<option value="'+index+'">'+val+'</option>'
                        });
                        $("#objective").html(html).select2({allowClear:true,placeholder:"Select Objective"});
                    }
                }
            })
        });

        $("#input-id").fileinput({'showUpload':false, 'previewFileType':'any'});
    });
</script>
<script src="{!! url('assets/js/tasks/tasks.js') !!}"></script>
@endsection