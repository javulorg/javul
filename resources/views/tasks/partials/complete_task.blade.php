@extends('layout.master')
@section('title', 'Task: ' . $taskObj->name)
@section('style')
<style>
    .custom-orange-text {
        color: orange;
    }
</style>
@endsection
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
    <div class="main_content">
        <div class="content_block">
            <div class="table_block table_block_tasks active">
                <div class="table_block_head">
                    <div class="table_block_icon">
                        <img src="{{ asset('v2/assets/img/list.svg') }}" alt="" class="img-fluid">
                    </div>
                    TASK MANAGEMENT / Complete Task : {{ $taskObj->name }}
                    <div class="arrow">
                        <img src="{{ asset('v2/assets/img/bottom.svg') }}" alt="">
                    </div>
                </div>
                <div class="objective_content">
                    <div class="objective_content_row d-sm-flex d-none">
                        <div>
                            <p>
                                {!! $taskObj->description !!}
                            </p>
                        </div>
                        <div class="objective_content_info">
                            <div class="sidebar_block">
                                <div class="sidebar_block_ttl">
                                    Task Overview
                                    <div class="arrow">
                                        <img src="{{ asset('v2/assets/img/bottom_y.svg') }}" alt="">
                                    </div>
                                </div>
                                <div class="sidebar_block_content">
                                    <div class="sidebar_block_row">
                                        <div class="sidebar_block_left">
                                        </div>
                                        <div class="sidebar_block_right">

                                            <div class="progress">
                                                <div class="progress-bar" style="width:75%"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="sidebar_block_row">
                                        <div class="sidebar_block_left">
                                            Status:
                                        </div>
                                        <div class="sidebar_block_right">
                                            <label class="control-label"
                                                style="color: lightgreen;">{{\App\Models\SiteConfigs::task_status($taskObj->status)}}</label>
                                        </div>

                                    </div>

                                    <div class="sidebar_line"></div>
                                    <div class="sidebar_block_row">
                                        <div class="sidebar_block_left">
                                            Skills
                                        </div>
                                        <div class="sidebar_block_right">
                                            @if(!empty($skill_names) && count($skill_names) > 0)
                                            {{$skill_names[0]}}
                                            @else
                                            -
                                            @endif
                                        </div>
                                    </div>

                                    <div class="sidebar_line"></div>
                                    <div class="sidebar_block_row">
                                        <div class="sidebar_block_left">
                                            Award
                                        </div>
                                        <div class="sidebar_block_right">
                                            $ {{ $taskObj->compensation }}
                                        </div>
                                    </div>


                                    <div class="sidebar_line"></div>
                                    <div class="sidebar_block_row">
                                        <div class="sidebar_block_left">
                                            Completion
                                        </div>
                                        <div class="sidebar_block_right">
                                            {{ $taskObj->completionTime }}
                                        </div>
                                    </div>

                                    <div class="sidebar_line"></div>
                                    <div class="sidebar_block_row">
                                        <div class="sidebar_block_left">
                                            Available
                                        </div>
                                        <div class="sidebar_block_right">
                                            $ {{ number_format($availableFunds,2) }}
                                        </div>
                                    </div>

                                    <div class="sidebar_line"></div>
                                    <div class="sidebar_block_row">
                                        <div class="sidebar_block_left">
                                            Awarded
                                        </div>
                                        <div class="sidebar_block_right">
                                            $ {{ number_format($availableFunds,2) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="objective_content_info_links">
                                <a class="add_to_my_watchlist edit_icon" data-type="task"
                                    data-id="{{$taskIDHashID->encode($taskObj->id)}}"
                                    data-redirect="{{url()->current()}}"><img src="{{ asset('v2/assets/img/eye.svg') }}"
                                        alt=""></a>
                                <div class="separat"></div>
                                <a href="{!! route('tasks_revison',[$taskIDHashID->encode($taskObj->id)]) !!}"
                                    class="edit_icon"> Revision History</a>
                                <div class="separat"></div>
                                <a href="{!! url('tasks/'.$taskIDHashID->encode($taskObj->id).'/edit')!!}"
                                    class="edit_icon"><img src="{{ asset('v2/assets/img/pencil-create.svg') }}"
                                        alt=""></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content_block mt-3">
            <div class="row">
                <div class="col-sm-6 action_list" style="padding-right: 0px;">
                    <h4 style="padding:10px 15px;background-color: #f9f9f9;margin-top:0px;font-weight: 500;">Action
                        Items</h4>
                    <div class="list_item_div">
                        {!! $taskObj->task_action !!}
                    </div>
                </div>
                <div class="col-sm-6 file_list" style="padding-left: 0px;">
                    <h4 style="padding:10px 15px;background-color: #f9f9f9;margin-top:0px;font-weight: 500;">File
                        Attachments</h4>
                    @if(!empty($taskObj->task_documents) && count($taskObj->task_documents) > 0)
                    {{count($taskObj->task_documents)}}
                    <ul style="list-style-type: decimal; padding-left:30px;">
                        @foreach($taskObj->task_documents as $index=>$document)
                        <?php $extension = pathinfo($document->file_path, PATHINFO_EXTENSION); ?>
                        @if($extension == "pdf")
                        <?php $extension="pdf"; ?>
                        @elseif($extension == "doc" || $extension == "docx")
                        <?php $extension="docx"; ?>
                        @elseif($extension == "jpg" || $extension == "jpeg")
                        <?php $extension="jpeg"; ?>
                        @elseif($extension == "ppt" || $extension == "pptx")
                        <?php $extension="pptx"; ?>
                        @else
                        <?php $extension="file"; ?> @endif
                        <li>
                            <a class="files_image" href="{!! url($document->file_path) !!}" target="_blank">
                                <span style="display:block">
                                    @if(empty($document->file_name))
                                    &nbsp;
                                    @else
                                    {{$document->file_name}}
                                    @endif
                                </span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                    @else
                    <ul style="list-style-type: none; padding-left:20px;">
                        <li>No file(s) found.</li>
                    </ul>
                    @endif
                </div>
            </div>
        </div>

        <div class="content_block mt-4">
            <div class="table_block table_block_objectives active">
                <div class="table_block_head">
                    <div class="table_block_icon">
                        <img src="{{ asset('v2/assets/img/location.svg') }}" alt="" class="img-fluid">
                    </div>
                    Objectives
                    <div class="arrow">
                        <img src="{{ asset('v2/assets/img/bottom.svg') }}" alt="">
                    </div>
                </div>

                <?php $objSlug = \App\Models\Objective::getSlug($taskObj->objective->id); ?>
                <div class="table_block_txt">
                    <a style="font-weight: normal;" class="no-decoration"
                        href="{!! url('objectives/'.$objectiveIDHashID->encode($taskObj->objective->id).'/'.$objSlug ) !!}">
                        {{ $taskObj->objective->name }}
                    </a>
                </div>
            </div>
        </div>

        <div class="content_block mt-3">
            <div class="row">
                <div class="col-sm-12" style="padding:20px 20px 10px 30px;">

                    {{-- <form role="form" method="post"
                        action="{{ url('tasks/complete_task/' . $taskIDHashID->encode($taskObj->id)) }}"
                        novalidate="novalidate" enctype="multipart/form-data">
                        @csrf
                        @method('post')
                        @if(!empty($taskCompleteObj) && count($taskCompleteObj) > 0)
                        <?php $i=1; ?>
                        @foreach($taskCompleteObj as $completeObj)
                        <div class="row">
                            <div class="col-sm-12">
                                <img src="{!! url('assets/images/user.png') !!}"
                                    style="border: 1px solid;height:50px;vertical-align: top;" />
                                <div style="display: inline-block;padding-left: 10px;">
                                    <a
                                        href="{!! url('userprofiles/'.$userIDHashID->encode($completeObj->user_id).'/'.
                                                        strtolower($completeObj->first_name.'_'.$completeObj->last_name)) !!}">
                                        {{$completeObj->first_name.' '.$completeObj->last_name}}
                                    </a>
                                    <span>
                                        comments on task
                                    </span>
                                    <br />
                                    <span class="smallText">&nbsp;({!!
                                        \App\Library\Helpers::timetostr($completeObj->created_at) !!})</span>
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
                            <div class="col-sm-12">
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
                        @if($i
                        <= (count($taskCompleteObj) - 1)) <hr />
                        @endif
                        <?php $i++; ?>
                        @endforeach
                        @endif
                        <hr />
                        @if($authUserObj->role == 1)
                        <div class="row">
                            <div class="col-sm-12">
                                <label class="control-label" style="margin-bottom:0px">Quality of Work</label>
                                <div><input value="0" name="quality_of_work" type="number" class="rating_user" min=0
                                        max=5 step=0.5 data-size="xs"></div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-12">
                                <label class="control-label" style="margin-bottom:0px">Timeliness</label>
                                <div><input value="0" type="number" name="timeliness" class="rating_user" min=0 max=5
                                        step=0.5 data-size="xs"></div>
                            </div>
                        </div>
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
                                                        <div class="fileinput fileinput-new input-group"
                                                            data-provides="fileinput">
                                                            <div class="form-control" data-trigger="fileinput">
                                                                <i
                                                                    class="glyphicon glyphicon-file fileinput-exists"></i>
                                                                <span class="fileinput-filename"></span>
                                                            </div>
                                                            <span class="input-group-addon btn btn-default btn-file">
                                                                <span class="fileinput-new">Select file</span>
                                                                <span class="fileinput-exists">Change</span>
                                                                <input type="file" name="attachments[]">
                                                            </span>
                                                            <a href="#"
                                                                class="input-group-addon btn btn-default fileinput-exists"
                                                                data-dismiss="fileinput">Remove</a>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            <a href="#" class="remove-row text-danger hide">
                                                                <i class="fa fa-remove"></i>
                                                            </a>
                                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                                            <a href="#" class="addMoreDocument">
                                                                <i class="fa fa-plus plus"></i>
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
                                <textarea class="form-control" name="comment" id="comment"></textarea>
                            </div>
                        </div>
                        <div class="row form-group mt-4">
                            <div class="col-sm-12 ">
                                <button id="create_objective" type="submit" class="btn orange-bg">
                                    <span class="glyphicon glyphicon-ok"></span> Complete Task
                                </button>
                            </div>
                        </div>
                        @endif

                    </form> --}}

                    {{-- Non-admin users (role == 0) --}}
                    @if($authUserObj->role == 0)
                    <form role="form" method="post"
                        action="{{ url('tasks/complete_task/' . $taskIDHashID->encode($taskObj->id)) }}"
                        novalidate="novalidate" enctype="multipart/form-data">
                        @csrf
                        @method('post')

                        {{-- Existing task completions --}}
                        @if(!empty($taskCompleteObj) && count($taskCompleteObj) > 0)
                        <?php $i=1; ?>
                        @foreach($taskCompleteObj as $completeObj)
                        <div class="row">
                            <div class="col-sm-12">
                                <img src="{!! url('assets/images/user.png') !!}"
                                    style="border: 1px solid;height:50px;vertical-align: top;" />
                                <div style="display: inline-block;padding-left: 10px;">
                                    <a href="{!! url('userprofiles/'.$userIDHashID->encode($completeObj->user_id).'/'.
                        strtolower($completeObj->first_name.'_'.$completeObj->last_name)) !!}">
                                        {{ $completeObj->first_name.' '.$completeObj->last_name }}
                                    </a>
                                    <span>comments on task</span><br />
                                    <span class="smallText">&nbsp;({!!
                                        \App\Library\Helpers::timetostr($completeObj->created_at) !!})</span>
                                </div>
                            </div>
                            <div class="col-sm-12">{!! $completeObj->comments !!}</div>

                            @php
                            $taskCompleteDocs = json_decode($completeObj->attachments ?? '[]');
                            @endphp
                            @if(!empty($taskCompleteDocs) && count($taskCompleteDocs) > 0)
                            <div class="col-sm-12">
                                @foreach($taskCompleteDocs as $doc)
                                <span>
                                    <a href="{!! url($doc->file_path) !!}" target="_blank">{{ $doc->file_name }}</a>
                                </span>
                                @endforeach
                            </div>
                            @endif
                        </div>
                        @if($i
                        <= (count($taskCompleteObj) - 1)) <hr />
                        @endif
                        <?php $i++; ?>
                        @endforeach
                        @endif

                        <hr />

                        {{-- File upload and comment section --}}
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
                                                        <div class="fileinput fileinput-new input-group"
                                                            data-provides="fileinput">
                                                            <div class="form-control" data-trigger="fileinput">
                                                                <i
                                                                    class="glyphicon glyphicon-file fileinput-exists"></i>
                                                                <span class="fileinput-filename"></span>
                                                            </div>
                                                            <span class="input-group-addon btn btn-default btn-file">
                                                                <span class="fileinput-new">Select file</span>
                                                                <span class="fileinput-exists">Change</span>
                                                                <input type="file" name="attachments[]">
                                                            </span>
                                                            <a href="#"
                                                                class="input-group-addon btn btn-default fileinput-exists"
                                                                data-dismiss="fileinput">Remove</a>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            <a href="#" class="remove-row text-danger hide"><i
                                                                    class="fa fa-remove"></i></a>
                                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                                            <a href="#" class="addMoreDocument"><i
                                                                    class="fa fa-plus plus"></i></a>
                                                        </span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Comments field --}}
                        <div class="row">
                            <div class="col-sm-12 form-group">
                                <label class="control-label">Comments</label>
                                <textarea class="form-control" name="comment" id="comment"></textarea>
                            </div>
                        </div>

                        {{-- Submit Button --}}
                        <div class="row form-group mt-4">
                            <div class="col-sm-12">
                                <button id="create_objective" type="submit" class="btn orange-bg">
                                    <span class="glyphicon glyphicon-ok"></span> Complete Task
                                </button>
                            </div>
                        </div>
                    </form>
                    @endif

                    {{-- Admin users (role == 1) --}}
                    @if($authUserObj->role == 1)
                    <form role="form" method="post"
                        action="{{ url('tasks/mark_task_complete/' . $taskIDHashID->encode($taskObj->id)) }}" novalidate
                        enctype="multipart/form-data">
                        @csrf
                        @method('post')

                        {{-- Existing task completions --}}
                        @if(!empty($taskCompleteObj) && count($taskCompleteObj) > 0)
                        <?php $i=1; ?>
                        @foreach($taskCompleteObj as $completeObj)
                        <div class="row">
                            <div class="col-sm-12">
                                <img src="{!! url('assets/images/user.png') !!}"
                                    style="border: 1px solid;height:50px;vertical-align: top;" />
                                <div style="display: inline-block;padding-left: 10px;">
                                    <a
                                        href="{!! url('userprofiles/' . $userIDHashID->encode($completeObj->user_id) . '/' . strtolower($completeObj->first_name . '_' . $completeObj->last_name)) !!}">
                                        {{ $completeObj->first_name . ' ' . $completeObj->last_name }}
                                    </a>
                                    <span>comments on task</span><br />
                                    <span class="smallText">&nbsp;({!!
                                        \App\Library\Helpers::timetostr($completeObj->created_at) !!})</span>
                                </div>
                            </div>
                            <div class="col-sm-12">{!! $completeObj->comments !!}</div>

                            @php
                            $taskCompleteDocs = json_decode($completeObj->attachments ?? '[]');
                            @endphp
                            @if(!empty($taskCompleteDocs) && count($taskCompleteDocs) > 0)
                            <div class="col-sm-12">
                                @foreach($taskCompleteDocs as $doc)
                                <span><a href="{!! url($doc->file_path) !!}" target="_blank">{{ $doc->file_name
                                        }}</a></span>
                                @endforeach
                            </div>
                            @endif
                        </div>
                        @if($i
                        <= (count($taskCompleteObj) - 1)) <hr />
                        @endif
                        <?php $i++; ?>
                        @endforeach
                        @endif

                        <hr />

                        {{-- Admin rating and evaluation --}}
                        <div class="row">
                            <div class="col-sm-12">
                                <label class="control-label" style="margin-bottom:0px">Quality of Work</label>
                                <div><input value="0" name="quality_of_work" type="number" class="rating_user" min=0
                                        max=5 step=0.5 data-size="xs"></div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-12">
                                <label class="control-label" style="margin-bottom:0px">Timeliness</label>
                                <div><input value="0" type="number" name="timeliness" class="rating_user" min=0 max=5
                                        step=0.5 data-size="xs"></div>
                            </div>
                        </div>

                        {{-- Admin Evaluation Partial --}}
                        @include('tasks.partials.complete_evaluation')

                        {{-- Admin Submit Button --}}
                        <div class="row form-group mt-4">
                            <div class="col-sm-12">
                                <button type="submit" class="btn orange-bg">
                                    <span class="glyphicon glyphicon-ok"></span> Complete Task
                                </button>
                            </div>
                        </div>
                    </form>
                    @endif


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
            ClassicEditor
                .create( document.querySelector('#comment') )
                .catch( error => {
                    console.error(error);
                } );
        });
</script>
@endsection
