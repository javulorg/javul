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