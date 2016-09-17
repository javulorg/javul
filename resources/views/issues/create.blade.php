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
        <div class="row form-group" style="margin-bottom:15px;">
            @include('elements.user-menu',['page'=>'tasks'])
        </div>
        {{--<div class="row form-group">
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
                @include('tasks.partials.task_information')
            </div>
        </div>--}}

        <div class="row">
            <div class="col-sm-4">
                @include('units.partials.unit_information_left_table',['unitObj'=>$unitObj,'availableFunds'=>$availableUnitFunds,'awardedFunds'=>$awardedUnitFunds])
                <div class="left" style="position: relative;margin-top: 30px;">
                    <div class="site_activity_loading loading_dots" style="position: absolute;top:20%;left:43%;z-index: 9999;display: none;">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    <div class="site_activity_list">
                        @include('elements.site_activities',['ajax'=>false])
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="panel panel-grey panel-default">
                    <div class="panel-heading">
                        <h4>Create Issue</h4>
                    </div>
                    <div class="panel-body list-group">
                        <div class="list-group-item">
                            <form role="form" method="post" id="form_sample_2"  novalidate="novalidate" enctype="multipart/form-data">
                                {!! csrf_field() !!}
                                <div class="row">

                                    <input type="hidden" name="unit" value="{{$unitIDHashID->encode($unitObj->id)}}"/>
                                    <div class="col-sm-4 form-group {{ $errors->has('issue_title') ? ' has-error' : '' }}">
                                        <label class="control-label">Issue Title</label>
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <input type="text" name="title" value="{{ (!empty($taskObj))? $taskObj->name : old('title') }}"
                                                   class="form-control"
                                                   placeholder="Issue Name"/>
                                            @if ($errors->has('title'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('title') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-4 form-group">
                                        <label class="control-label">Select Objective</label>
                                        <div class="input-icon right">
                                            <i class="fa select-error"></i>
                                            <select name="objective_id" id="objective_id" class="form-control">
                                                <option value="">Select</option>
                                                @if(count($objectiveObj) > 0)
                                                    @foreach($objectiveObj as $objective)
                                                        <option value="{{$objectiveIDHashID->encode($objective->id)}}"
                                                                @if(!empty($taskObj) && $objective->id == $taskObj->objective_id)
                                                                selected=selected
                                                                @endif>{{$objective->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 form-group">
                                        <label class="control-label">Select Task</label>
                                        <div class="input-icon right">
                                            <i class="fa select-error"></i>
                                            <select name="task_id" id="task_id" class="form-control">
                                                <option value="">Select</option>
                                            </select>

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 form-group">
                                        <div class="document_listing_div">
                                            <div class="table-responsive">
                                                <table class="documents table table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th style="border:0px;font-weight:normal;">Documents</th>
                                                        <th style="border:0px;"></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    @if(!empty($taskDocumentsObj))
                                                        <?php $i=1; ?>
                                                        @foreach($taskDocumentsObj as $document)
                                                            @include('tasks.partials.task_document_listing',['document'=>$document,'taskObj'=>$taskObj,'taskDocumentIDHashID'=>$taskDocumentIDHashID,'fromEdit'=>'no'])
                                                        @endforeach
                                                        @if(empty($taskObj) || ($taskObj->status == "editable"))
                                                            @include('tasks.partials.document_upload')
                                                        @endif
                                                    @else
                                                        @if(empty($taskObj) || ($taskObj->status == "editable"))
                                                            @include('tasks.partials.document_upload')
                                                        @endif
                                                    @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 form-group">
                                        <label class="control-label">Description</label>
                                        <textarea class="form-control summernote" name="description">@if(!empty($taskObj)) {{$taskObj->description}} @endif</textarea>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12 ">

                                        <button id="create_objective" type="submit"  @if(!empty($taskObj) && ($taskObj->status !="editable"))
                                        class="btn" disabled="disabled" style="background-color:#e1672c;"@else class="btn black-btn" @endif>
                                            @if(!empty($taskObj))
                                                <span class="glyphicon glyphicon-edit"></span> Update Issue
                                            @else
                                                <i class="fa fa-plus plus"></i> <span class="plus_text">Create Issue</span>
                                            @endif
                                        </button>

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('elements.footer')
@stop
@section('page-scripts')
    <script>
        var editTask = false;

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
    <script src="{!! url('assets/plugins/bootstrap-multiselect/bootstrap-multiselect.js') !!}" type="text/javascript"></script>
    <script src="{!! url('assets/plugins/bootstrap-fileinput/bootstrap-fileinput.js') !!}" type="text/javascript"></script>
    <script src="{!! url('assets/plugins/bootstrap-summernote/summernote.min.js') !!}" type="text/javascript"></script>
    <script src="{!! url('assets/js/issues/issues.js') !!}"></script>
@endsection