@extends('layout.master')
@section('title', 'Task: ' . $taskObj->name)
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
                <h4>Update Task</h4>
            </div>
            <div class="panel-body list-group">
                <div class="list-group-item">
                    <form role="form" method="post" id="form_sample_2" action="{{ url('tasks/'. $taskHashId) }}" enctype="multipart/form-data">
                        @csrf
                        @method('put')

                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label class="control-label">Task Name</label>
                                <div class="input-icon right">
                                    <input type="text" name="task_name" id="task_name"
                                           value="{{ (!empty($taskObj))? $taskObj->name : old('task_name') }}"
                                           class="form-control" placeholder="Task Name">
                                </div>
                                @if ($errors->has('task_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('task_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row mt-3">
                            <input type="hidden" name="unit" value="{{ $unitIDHashID->encode($unitData->id) }}">

                            <div class="col-sm-12 form-group">
                                <label class="control-label">Objective <span
                                        class="text-danger">*</span></label>
                                <select @if(!empty($unitInfo) && !empty($task_objective_id)) name="objective_disabled"
                                        @else name="objective" @endif id="objective"
                                        class="form-control selectpicker" data-live-search="true">
                                    @if(count($objectiveObj) > 0)
                                        @foreach($objectiveObj as $objective)
                                            <option value="{{$objectiveIDHashID->encode($objective->id)}}"
                                                    @if(!empty($taskObj) && $objective->id == $taskObj->objective_id)
                                                    selected=selected
                                                    @elseif(empty($taskObj) && $objective->id == $task_objective_id)
                                                    selected=selected
                                                @endif>{{$objective->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @if(!empty($unitInfo) && !empty($task_objective_id))
                                    <input type="hidden" name="objective"
                                           value="{{$objectiveIDHashID->encode($task_objective_id)}}"/>
                                @endif
                                <span class="objective_loader location_loader" style="display: none">
                                            <img src="{!! url('assets/images/small_loader.gif') !!}"/>
                                        </span>
                                @if ($errors->has('objective'))
                                    <span class="help-block">
                                                <strong>{{ $errors->first('objective') }}</strong>
                                            </span>
                                @endif
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-sm-4  form-group {{ $errors->has('task_skills') ? ' has-error' : '' }}">
                                <label class="control-label">Task Skills <span
                                        class="text-danger">*</span></label>
                                <select name="task_skills[]" class="form-control selectpicker" data-live-search="true"
                                        id="task_skills" multiple>
                                    <option value="">Select</option>
                                    @if(!empty($task_skills))
                                        @foreach($task_skills as $skill_id=>$skill)
                                            <option value="{{$skill_id}}" @if(!empty($exploded_task_list) && in_array($skill_id,
                                                                                            $exploded_task_list)) selected=selected @endif>{{$skill}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @if ($errors->has('task_skills'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('task_skills') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-sm-4 mt-1 mb-2 form-group {{ $errors->has('estimated_completion_time_start') ? ' has-error' : '' }}">
                                <label class="control-label">Estimated Completion Time From</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="estimated_completion_time_start"
                                           name="estimated_completion_time_start" value="{{ (!empty($taskObj))?
                                                                                    $taskObj->estimated_completion_time_start :
                                                                                    old('estimated_completion_time_start') }}"
                                           class="form-control datetimepicker"
                                           placeholder="Estimated Completion Time From">
                                    <span class="input-group-text" id="calendar-icon-from"><i
                                            class="bi bi-calendar"></i></span>
                                </div>
                                @if ($errors->has('estimated_completion_time_start'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('estimated_completion_time_start') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-sm-4 mt-1 mb-2 form-group {{ $errors->has('estimated_completion_time_end') ? ' has-error' : '' }}">
                                <label class="control-label">Estimated Completion Time To</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="estimated_completion_time_end"
                                           name="estimated_completion_time_end" value="{{ (!empty($taskObj))?
                                                                                $taskObj->estimated_completion_time_end :
                                                                                old('estimated_completion_time_end') }}"
                                           class="form-control datetimepicker"
                                           placeholder="Estimated Completion Time To"/>
                                    <span class="input-group-text" id="calendar-icon-to"><i class="bi bi-calendar"></i></span>
                                </div>
                                @if ($errors->has('estimated_completion_time_end'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('estimated_completion_time_end') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-sm-4 form-group">
                                <label class="control-label">Compensation <span
                                        class="text-danger">*</span></label>
                                <div class="input-group mb-3">
                                    <input type="text" id="compensation" name="compensation"
                                           value="{{ (!empty($taskObj))? $taskObj->compensation : old('compensation') }}"
                                           class="form-control border-radius-0 onlyDigits"
                                           placeholder="Compensation"/>
                                    <span class="input-group-text"><i class="bi bi-currency-dollar"></i></span>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                @if(!empty($taskObj))
                                    <div class="col-sm-4 mt-1 mb-2 form-group">
                                        <label class="control-label">Status</label>
                                        <div class="input-icon right">
                                            @if(!empty($change_task_status) || \App\Models\Task::isUnitAdminOfTask($taskObj->id))
                                                <select name="task_status" class="form-control selectpicker"
                                                        data-live-search="true" id="task_status">
                                                    @foreach(\App\Models\SiteConfigs::task_status() as $index=>$status)
                                                        <option @if($taskObj->status == $index) selected=selected
                                                                @endif value="{{$index}}">{{ $status }}</option>
                                                    @endforeach
                                                </select>
                                            @else
                                                <span>
                                                {{\App\Models\SiteConfigs::task_status($taskObj->status)}}

                                                    @if($taskObj->status == "editable" && !empty($taskEditor) && $taskEditor->submit_for_approval == "not_submitted")
                                                        @if(count($otherEditorsDone) > 0)
                                                            ({{count($otherEditorsDone).' task editor submitted this task for Approval'}}
                                                            @if(!empty($availableDays))
                                                                {{"Time left for editing: ".$availableDays." days."}})
                                                            @endif
                                                        @endif
                                                        <a href="#" class="submit_for_approval" data-task_id="{{$taskIDHashID->encode($taskObj->id)}}">Submit for Approval</a>@elseif($taskObj->status == "editable" && count($taskEditor) > 0 && $taskEditor->submit_for_approval == "submitted")
                                                                                    ( You changed this task status to
                                                                                    "Awaiting Approval". Waiting
                                                                                    for {{count($otherRemainEditors)}}
                                                                                    other editors to do the same)
                                                    @endif
                                                    @endif
                                                </span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-sm-12 form-group">
                                <label class="control-label">Summary</label>
                                <textarea class="form-control" id="task-summary"
                                          name="summary">@if(!empty($taskObj)) {{$taskObj->summary}} @endif</textarea>
                            </div>

                            <div class="col-sm-12 mt-1 mb-2 form-group">
                                <label class="control-label">Description <span id="desc-error"></span></label>
                                <textarea class="form-control" id="description-summernote"
                                          name="description">@if(!empty($taskObj)) {{$taskObj->description}} @endif</textarea>
                            </div>

                            <div class="col-sm-12 mt-1 mb-2 form-group">
                                <label class="control-label">Action Items</label>
                                <textarea class="form-control" name="action_items" id="action_items">
                                    @if(!empty($taskObj))
                                        {!! $taskObj->task_action !!}
                                    @endif
                                </textarea>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-sm-12 form-group">
                                <div class="document_listing_div">
                                    <div class="table-responsive overflow-hidden">
                                        <table class="documents table table-striped">
                                            <thead>
                                            <tr>
                                                <th style="border:0px;font-weight:normal;">Documents</th>
                                                <th style="border:0px;"></th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @if(!empty($taskDocumentsObj))
                                                <?php $i = 1; ?>
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

                        <div class="row mt-3">
                            <div class="col-sm-12 form-group">
                                <label class="control-label">Comment</label>
                                <input class="form-control" name="comment" value="{{ $taskObj->comment }}">
                            </div>
                        </div>

                        <div class="row justify-content-center mt-3">
                            <div class="col-md-6 col-lg-4">
                                <button class="btn btn-secondary btn-block" type="submit" id="create_unit">
                                    <i class="fa fa-plus"></i> <span class="plus_text">Update Task</span>
                                </button>
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


            $(".datetimepicker").flatpickr({
                enableTime: true,
                position: "above",
                mode: "multiple",
                minuteIncrement: 1,
                enableSeconds: true,
            });

            $("#calendar-icon-from").on("click", function () {
                $(this).closest(".input-group").find("input").focus();
            });
            $("#calendar-icon-to").on("click", function () {
                $(this).closest(".input-group").find("input").focus();
            });




            $(document).off('click', '.addMoreDocument').on('click', ".addMoreDocument", function () {
                cloneTR();
                return false;
            });

            $(document).on("click", "table.documents tbody .remove-row", function () {
                var index_tr = $(".documents").find("tbody").find("tr").index($(this));
                var id = $(this).attr('data-id');
                var task_id = $(this).attr('data-task_id');
                var fromEdit = $(this).attr('data-from_edit');
                $that = $(this);
                if ($.trim(id) != "" && $.trim(task_id) != "") {
                    addEditedFieldName("remove_doc");

                    $.ajax({
                        type: 'get',
                        url: '{{ url("/tasks/remove_task_document") }}',
                        data: {id: id, task_id: task_id, fromEdit: fromEdit},
                        dataType: 'json',
                        success: function (resp) {
                            if (resp.success) {
                                showToastMessage('DOCUMENT_DELETED');
                                if ($("table.documents tbody tr").length > 1)
                                    $that.parents('tr:eq(0)').remove();
                                if ($("table.documents tbody tr").length < 10)
                                    // cloneTR(true);

                                    $(".documents").find("tbody").find("tr").eq(index_tr).find(".addMoreDocument").removeClass("hide");
                            } else
                                showToastMessage('SOMETHING_GOES_WRONG');
                        }
                    })
                } else {

                    if ($("table.documents tbody tr").length > 1)
                        $(this).parents('tr:eq(0)').remove();

                    var addedDocLength = $(".fileinput-new:not(:hidden)").length;
                    if (addedDocLength == 0)
                        $(".changed_items[value='" + field_name + "']").remove();

                    $(".documents").find("tbody").find("tr").eq(index_tr).find(".addMoreDocument").removeClass("hide");
                }

                return false;
            });

            $("#unit").on('change', function () {
                var unit_val = $(this).val();
                var token = $('[name="_token"]').val();
                if ($.trim(unit_val) == "") {
                    $("#objective").html('<option value="">Select</option>');
                    return false;
                } else {
                    $(".objective_loader.location_loader").show();
                    $("#objective").prop('disabled', true);
                    $.ajax({
                        type: 'POST',
                        url: '{{ url("/tasks/get_objective") }}',
                        dataType: 'json',
                        data: {unit_id: unit_val, _token: token},
                        success: function (resp) {
                            $(".objective_loader.location_loader").hide();
                            $("#objective").prop('disabled', false);
                            if (resp.success) {
                                var html = '<option value="">Select</option>';
                                $.each(resp.objectives, function (index, val) {
                                    html += '<option value="' + index + '">' + val + '</option>'
                                });
                                $("#objective").append(html);
                                $('.selectpicker').selectpicker('refresh');
                            }
                        }
                    })
                }
                return false
            });
        });

    </script>
@endsection
