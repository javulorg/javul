@extends('layout.master')
@section('title', 'Create Issue')

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
                <h4>Create Issue</h4>
            </div>

            <div class="panel-body list-group">
                <div class="list-group-item">
                    <form role="form" method="post" id="form_sample_2" action="{{ url('issues') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <input type="hidden" name="unit_id" value="{{$unitIDHashID->encode($unitObj->id)}}"/>
                        </div>
                        <div class="row">

                            <div class="form-group">
                                <label class="control-label">Issue Title</label>
                                <input type="text" name="title" value="{{ (!empty($issueObj))? $issueObj->title : old('title') }}" class="form-control" placeholder="Issue Name"/>
                                @if ($errors->has('title'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </span>
                                @endif
                            </div>


                            <div class="mt-3 form-group">
                                <label class="control-label">Select Objective</label>
                                <select name="objective_id" id="objective_id" class="form-control selectpicker" data-live-search="true">
                                    <option value="">Select</option>
                                    @if(count($objectiveObj) > 0)
                                        @foreach($objectiveObj as $objective)
                                            <option value="{{$objectiveIDHashID->encode($objective->id)}}" @if(!empty($issueObj) && $objective->id == $issueObj->objective_id) selected="selected" @endif>{{$objective->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>


                            @if(!empty($issueObj) && $user_can_change_status)
                                <div class="mt-3 form-group">
                                    <label class="control-label">Select Status</label>
                                    <select name="status" id="status" class="form-control selectpicker" data-live-search="true">
                                        <option value="unverified" @if(!empty($issueObj) && $issueObj->status == "unverified") selected="selected" @endif>Unverified</option>
                                        <option value="verified" @if(!empty($issueObj) && $issueObj->status == "verified") selected="selected" @endif>Verified</option>
                                        <option value="resolved" @if(!empty($issueObj) && $issueObj->status == "resolved") selected="selected" @endif>Resolved</option>
                                    </select>
                                </div>
                            @endif


                            <div class="mt-3 form-group">
                                <label class="control-label">Select Task</label>
                                <select name="task_id" id="task_id" class="form-control selectpicker" data-live-search="true">
                                    <option value="">Select</option>
                                    @if(!empty($taskObj))
                                            <?php $task_ids = explode(",", $issueObj->task_id); ?>
                                        @foreach($taskObj as $task)
                                            <option value="{{$taskIDHashID->encode($task->id)}}" @if(in_array($task->id, $task_ids)) selected @endif>{{$task->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>


                            <div class="mt-3 form-group">
                                <label class="control-label">Description</label>
                                <textarea class="form-control" id="description" name="description">@if(!empty($issueObj)) {{$issueObj->description}} @endif</textarea>
                            </div>


                            <div class="mt-3 form-group">
                                <label class="control-label">Resolution</label>
                                <textarea class="form-control" id="resolution" name="resolution">@if(!empty($issueObj)) {{$issueObj->resolution}} @endif</textarea>
                            </div>

                            <div class="mt-3 form-group text-center">
                                <button class="btn btn-secondary" type="submit" id="create_issue">
                                    <i class="fa fa-plus"></i> <span class="plus_text">Create Issue</span>
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
                position : "above",
                mode : "multiple",
                minuteIncrement : 1,
                enableSeconds : true,
            });

            $(document).off('click','.addMoreDocument').on('click',".addMoreDocument",function(){
                cloneTR();
                return false;
            });

            $(document).on("click","table.documents tbody .remove-row", function(){
                var index_tr = $(".documents").find("tbody").find("tr").index($(this));
                var id = $(this).attr('data-id');
                var task_id = $(this).attr('data-task_id');
                var fromEdit = $(this).attr('data-from_edit');
                $that = $(this);
                if($.trim(id) != "" && $.trim(task_id) != ""){
                    addEditedFieldName("remove_doc");

                    $.ajax({
                        type:'get',
                        url: '{{ url("/tasks/remove_task_document") }}',
                        data:{id:id,task_id:task_id,fromEdit:fromEdit },
                        dataType:'json',
                        success:function(resp){
                            if(resp.success){
                                showToastMessage('DOCUMENT_DELETED');
                                if ($("table.documents tbody tr").length > 1)
                                    $that.parents('tr:eq(0)').remove();
                                if ($("table.documents tbody tr").length < 10)
                                    // cloneTR(true);

                                    $(".documents").find("tbody").find("tr").eq(index_tr).find(".addMoreDocument").removeClass("hide");
                            }
                            else
                                showToastMessage('SOMETHING_GOES_WRONG');
                        }
                    })
                }
                else{

                    if ($("table.documents tbody tr").length > 1)
                        $(this).parents('tr:eq(0)').remove();

                    var addedDocLength = $(".fileinput-new:not(:hidden)").length;
                    if(addedDocLength == 0)
                        $(".changed_items[value='"+field_name+"']").remove();

                    $(".documents").find("tbody").find("tr").eq(index_tr).find(".addMoreDocument").removeClass("hide");
                }

                return false;
            });

            $("#unit_id").on('change',function(){
                var unit_val = $(this).val();
                var token = $('[name="_token"]').val();
                    $("#objective_id").prop('disabled',true);
                    $.ajax({
                        type:'POST',
                        url: '{{ url("/tasks/get_objective") }}',
                        dataType:'json',
                        data:{unit_id:unit_val,_token:token },
                        success:function(resp){
                            $("#objective_id").prop('disabled',false);
                            if(resp.success){
                                var html;
                                $.each(resp.objectives,function(index,val){
                                    html+='<option value="'+index+'">'+val+'</option>'
                                });
                                $("#objective_id").append(html);
                                $('.selectpicker').selectpicker('refresh');
                            }
                        }
                    })
                return false
            });

            $("#objective_id").on('change',function(){
                var obj_val = $(this).val();
                var token = $('[name="_token"]').val();
                $("#objective_id").prop('disabled',true);

                $.ajax({
                    type:'POST',
                    url: '{{ url("/tasks/get_tasks") }}',
                    dataType:'json',
                    data:{obj_id:obj_val,_token:token},
                    success:function(resp)
                    {
                        $("#objective_id").prop('disabled',false);
                        if(resp.success)
                        {
                            var html;
                            $.each(resp.tasks,function(index,val)
                            {
                                html+='<option value="'+index+'">'+val+'</option>'
                            });
                            $("#task_id").append(html);
                            $('.selectpicker').selectpicker('refresh');
                        }
                    }
                })
                return false
            });

            ClassicEditor
                .create( document.querySelector( '#description' ) )
                .catch( error => {
                    console.error( error );
                } );

            ClassicEditor
                .create( document.querySelector( '#resolution' ) )
                .catch( error => {
                    console.error( error );
                } );
        });
    </script>
@endsection
