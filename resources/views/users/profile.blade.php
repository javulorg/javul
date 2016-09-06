@extends('layout.default')
@section('page-css')
<style>
    span.tags{padding:0 6px;}
    .text-danger{color:#ed6b75 !important;}
    .navbar-nav > li.active{background-color: #e7e7e7;}
</style>
@endsection
@section('content')

<div class="container">
    <div class="row form-group" style="margin-bottom:15px;">
        @include('elements.user-menu',array('page'=>'home'))
    </div>
    @include('users.user-profile')
    <div class="row">
        <div class="col-sm-4">
            <div class="left" style="position: relative;margin-top: 30px;">
                <div class="site_activity_loading loading_dots" style="position: absolute;top:20%;left:43%;z-index: 9999;display: none;">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <div class="site_activity_list">
                    @include('elements.site_activities_user',['site_activity'=>$site_activities])
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <h3 style="display: inline-block;width: 70%;">Total Activity Points : {{$activityPoints}}</h3>
            <a class="btn black-btn btn-sm" id="add_funds_btn" href="{!! url('funds/donate/user/'.$userIDHashID->encode($userObj->id)) !!}"
               style="display: inline-block;float:right;margin-top:10px">
                <i class="fa fa-plus plus"></i>
                {!! trans('messages.add_funds')!!}
            </a>
            <ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
                <li class="active"><a href="#unit_details" data-toggle="tab">Units Details</a></li>
                <li><a href="#objectives_details" data-toggle="tab">Objectives Details</a></li>
                <li><a href="#tasks_details" data-toggle="tab">Tasks Details</a></li>
            </ul>
            <div id="my-tab-content" class="tab-content">
                <div class="list-group tab-pane active table-responsive" id="unit_details">
                    <div style="border:1px solid #ddd; ">
                        <table class="table table-striped" style="margin-bottom: 0px;">
                            <thead>
                            <tr>
                                <th>Unit Name</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                                @if(!empty($unitsObj))
                                    @foreach($unitsObj as $unit)
                                        <tr>
                                            <td>
                                                <a href="{!! url('units/'.$unitIDHashID->encode($unit->id).'/edit') !!}">
                                                    {{$unit->name}}
                                                </a>
                                            </td>
                                            <td>
                                                <span class="colorLightGreen">{{$unit->status}}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3">No record(s) found.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="list-group tab-pane table-responsive" id="objectives_details">
                    <div style="border:1px solid #ddd;">
                        <table class="table table-striped" style="margin-bottom: 0px;">
                            <thead>
                            <tr>
                                <th>Objective Name</th>
                                <th>Unit Name</th>
                            </tr>
                            </thead>
                            <tbody>
                                @if(!empty($objectivesObj) && count($objectivesObj) > 0)
                                    @foreach($objectivesObj as $objective)
                                        <tr>
                                            <td>
                                                <a href="{!! url('objectives/'.$objectiveIDHashID->encode($objective->id).'/edit') !!}">
                                                    {{$objective->name}}
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{!! url('units/'.$unitIDHashID->encode($objective->unit_id).'/edit') !!}">
                                                    {{\App\Unit::getUnitName($objective->unit_id)}}
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3">No record(s) found.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="list-group tab-pane table-responsive" id="tasks_details">
                    <div style="border:1px solid #ddd;">
                        <table class="table table-striped" style="margin-bottom: 0px;">
                            <thead>
                            <tr>
                                <th>Task Name</th>
                                <th>Objective Name</th>
                                <th>Unit Name</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($taskObj))
                                @foreach($taskObj as $task)
                                    <tr>
                                        <td>
                                            <a href="{!! url('tasks/'.$taskIDHashID->encode($task->id).'/edit') !!}">
                                                {{$task->name}}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{!! url('objectives/'.$objectiveIDHashID->encode($task->objective_id).'/edit') !!}">
                                                {{\App\Objective::getObjectiveName($task->objective_id)}}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{!! url('units/'.$unitIDHashID->encode($task->unit_id).'/edit') !!}">
                                                {{\App\Unit::getUnitName($task->unit_id)}}
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4">No record(s) found.</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
@section('page-scripts')
<script type="text/javascript">
    $(function(){
        $('#tabs').tab();
    })
</script>
@endsection