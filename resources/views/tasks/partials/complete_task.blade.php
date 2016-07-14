@extends('layout.default')
@section('page-css')
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
                Complete Task
            </h1>
            <span style="font-size: 14px;padding-left:50px">
                <b>{{$taskObj->name}}</b>
            </span><br /><br />
        </div>
        @include('tasks.partials.task_information')
    </div>
</div>
<form role="form" method="post" id="form_sample_2"  novalidate="novalidate" enctype="multipart/form-data">
{!! csrf_field() !!}
    @if(!empty($taskCompleteObj) && count($taskCompleteObj) > 0)
        <?php $i=1; ?>
        @foreach($taskCompleteObj as $completeObj)
            <div class="row">
                <div class="col-sm-12">
                    <img src="{!! url('assets/images/user.png') !!}" style="border: 1px solid;height:50px;vertical-align: top;"/>
                    <div style="display: inline-block;padding-left: 10px;">
                        <a href="{!! url('userprofiles/'.$userIDHashID->encode($completeObj->user_id).'/'.
                                                        strtolower($completeObj->first_name.'_'.$completeObj->last_name)) !!}">
                            {{$completeObj->first_name.' '.$completeObj->last_name}}
                        </a>
                             <span>
                                comments on task
                            </span>
                        <br/>
                        <span class="smallText">&nbsp;({{\App\Library\Helpers::timetostr($completeObj->created_at)}})</span>
                    </div>
                </div>
                <div class="col-sm-12">
                    {!! $completeObj->comments !!}
                </div>
                <?php $taskCompleteDocs = $completeObj->attachments;
                if(!empty($taskCompleteDocs))
                    $taskCompleteDocs = json_decode($taskCompleteDocs);
                ?>

                @if(!empty($taskCompleteDocs) && count($taskCompleteDocs) > 0)
                <div class="col-sm-12" >
                    @foreach($taskCompleteDocs as $doc)
                        <span>
                            <a href="{!! url($doc->file_path) !!}" target="_blank">
                                {{$doc->file_name}}
                            </a>
                        </span>
                    @endforeach
                </div>
                @endif
            </div>
            @if($i <= (count($taskCompleteObj) - 1))
                <hr/>
            @endif
        <?php $i++; ?>
        @endforeach
    @endif
<hr/>
@if($authUserObj->role == "superadmin")
    @include('tasks.partials.complete_evaluation')
@else
    @if(!empty($taskEditors) && count($taskEditors) > 0)
        <div class="panel panel-default panel-dark-grey">
            <div class="panel-heading">
                <h4>Reward Assignment</h4>
                <span class="text-right">( 10% of task reward among all task editor and task creator)</span>
            </div>

            <div class="panel-body reward-assignment-body">
                @if(!$rewardAssigned)
                <div class="row form-group {{  $errors->has('split_error') ? ' has-error' : ''  }}
                        {{  $errors->has('amount_percentage['.$taskObj->user_id.']')? ' has-error' : ''  }}">
                    <div class="col-sm-4 col-xs-8">
                        {{\App\User::getUserName($taskObj->user_id)}} (<b>task creator</b>)
                    </div>
                    <div class="col-sm-2 col-xs-4">
                        <input type="text" name="amount_percentage[{{$taskObj->user_id}}]"
                               value="{{ old('amount_percentage['.$taskObj->user_id.']') }}"
                               class="form-control onlyDigits amount_percentage"
                               style="display:inline-block;float:left;width:50px"/>
                        <span style="line-height:35px;padding-left:2px">%</span>
                    </div>
                </div>
                @endif
                @foreach($taskEditors as $editor)
                    <div class="row form-group {{  $errors->has('split_error') ? ' has-error' : ''  }}
                            {{  $errors->has('amount_percentage['.$editor->user_id.']')? ' has-error' : ''  }}">
                        <div class="col-sm-4 col-xs-8">
                            {{\App\User::getUserName($editor->user_id)}}
                            @if($rewardAssigned && $editor->user_id == $taskObj->user_id)
                                (<b>task creator</b>)
                            @else
                                (<b>task editor</b>)
                            @endif
                        </div>
                        <div class="col-sm-2 col-xs-4">
                            <input type="text" name="amount_percentage[{{$editor->user_id}}]"
                                   @if($rewardAssigned) value="{{ $editor->reward_percentage}}" @else
                            value="{{ old('amount_percentage['.$editor->user_id.']')}}" @endif "
                                   class="form-control onlyDigits amount_percentage"
                                   @if($rewardAssigned) disabled=disabled @endif
                                   style="display:inline-block;float:left;width:50px"/>
                            <span style="line-height:35px;padding-left:2px">%</span>
                        </div>
                    </div>
                @endforeach
                @if($errors->has('split_error'))
                    <span class="has-error error-not-100">
                        <span class="control-label">{{$errors->first('split_error')}}</span>
                    </span>
                @elseif($errors->has('amount_percentage['.$taskObj->user_id.']'))
                    <span class="has-error error-not-100">
                        <span class="control-label">Please enter percentage</span>
                    </span>
                @elseif(count($errors) > 0 && !$error->has('comment'))
                    <span class="has-error error-not-100">
                        <span class="control-label">Please enter percentage</span>
                    </span>
                @endif
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-sm-12 form-group">
            <div class="attachment_listing_div">
                <div class="table-responsive">
                    <table class="complete_task_attachment table table-striped">
                        <thead>
                        <tr>
                            <th>Documents</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
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
                                        <input type="file" name="attachments[]">
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

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 form-group">
            <label class="control-label">Comments</label>
            <textarea class="form-control summernote" name="comment" id="comment"></textarea>
        </div>
    </div>
    <div class="row form-group">
        <div class="col-sm-12 ">
            <button id="create_objective" type="submit"  class="btn orange-bg">
                <span class="glyphicon glyphicon-ok"></span> Complete Task
            </button>
        </div>
    </div>
@endif

</form>
</div>
@include('elements.footer')
@stop
@section('page-scripts')
<script>
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "positionClass": "toast-top-right",
        "onclick": null,
        "showDuration": "1000",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
</script>
<script src="{!! url('assets/plugins/bootstrap-fileinput/bootstrap-fileinput.js') !!}" type="text/javascript"></script>
<script src="{!! url('assets/plugins/bootstrap-summernote/summernote.min.js') !!}" type="text/javascript"></script>
<script src="{!! url('assets/js/tasks/complete_tasks.js') !!}"></script>
@endsection