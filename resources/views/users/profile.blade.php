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
    <div class="row">
        @include('elements.user-menu',array('page'=>'home'))
    </div>
    @include('users.user-profile')
    <div class="row">
        <div class="col-sm-8">
            <h3 style="display: inline-block;width: 70%;">Total Activity Points : {{$activityPoints}}</h3>
            <a class="btn orange-bg btn-sm" id="add_funds_btn" href="{!! url('funds/donate/user/'.$userIDHashID->encode($userObj->id)) !!}"
               style="display: inline-block;float:right;margin-top:10px">
                {!! trans('messages.add_funds')!!}
            </a>
            <ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
                <li class="active"><a href="#unit_details" data-toggle="tab">Units Details</a></li>
                <li><a href="#objectives_details" data-toggle="tab">Objectives Details</a></li>
                <li><a href="#tasks_details" data-toggle="tab">Tasks Details</a></li>
            </ul>
            <div id="my-tab-content" class="tab-content">
                <div class="list-group tab-pane active table-responsive" id="unit_details">
                    <div class="list-group-item">
                        <table class="table table-stripped">
                            <thead>
                            <tr>
                                <th>Unit Name</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                                @if(!empty($unitsObj))
                                    @foreach($unitsObj as $unit)
                                        <tr>
                                            <td>{{$unit->name}}</td>
                                            <td>{{$unit->status}}</td>
                                            <td width="11%">
                                                <a class="btn btn-xs"
                                                   href="{!! url('units/'.$unitIDHashID->encode($unit->id).'/edit') !!}" title="edit">
                                                    <span class="glyphicon glyphicon-edit"></span>
                                                </a>
                                                @if(!empty($authUserObj) && ($authUserObj->role == "superadmin" || $unit->user_id ==
                                                $authUserObj->id))
                                                    <a title="delete" href="#" class="btn btn-xs text-danger delete-unit"
                                                       data-id="{{$unitIDHashID->encode($unit->id)}}">
                                                        <span class="glyphicon glyphicon-trash"></span>
                                                    </a>
                                                @endif
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
                    <div class="list-group-item">
                        <table class="table table-stripped">
                            <thead>
                            <tr>
                                <th>Objective Name</th>
                                <th>Unit Name</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                                @if(!empty($objectivesObj))
                                    @foreach($objectivesObj as $objective)
                                        <tr>
                                            <td>{{$objective->name}}</td>
                                            <td>{{\App\Unit::getUnitName($objective->unit_id)}}</td>
                                            <td width="11%">
                                                <a class="btn btn-xs"
                                                   href="{!! url('objectives/'.$objectiveIDHashID->encode($objective->id).'/edit') !!}"
                                                   title="edit">
                                                    <span class="glyphicon glyphicon-edit"></span>
                                                </a>
                                                @if(!empty($authUserObj) && ($authUserObj->role == "superadmin" || $objective->user_id ==
                                                $authUserObj->id))
                                                <a title="delete" href="#" class="btn btn-xs text-danger delete-unit"
                                                   data-id="{{$objectiveIDHashID->encode($objective->id)}}">
                                                    <span class="glyphicon glyphicon-trash"></span>
                                                </a>
                                                @endif
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
                    <div class="list-group-item">
                        <table class="table table-stripped">
                            <thead>
                            <tr>
                                <th>Task Name</th>
                                <th>Objective Name</th>
                                <th>Unit Name</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($taskObj))
                                @foreach($taskObj as $task)
                                    <tr>
                                        <td>{{$task->name}}</td>
                                        <td>{{\App\Unit::getUnitName($task->unit_id)}}</td>
                                        <td>{{\App\Objective::getUnitName($task->objective_id)}}</td>
                                        <td width="11%">
                                            <a class="btn btn-xs"
                                               href="{!! url('tasks/'.$taskIDHashID->encode($task->id).'/edit') !!}"
                                               title="edit">
                                                <span class="glyphicon glyphicon-edit"></span>
                                            </a>
                                            @if(!empty($authUserObj) && ($authUserObj->role == "superadmin" || $objective->user_id ==
                                            $authUserObj->id))
                                            <a title="delete" href="#" class="btn btn-xs text-danger  delete-unit"
                                               data-id="{{$taskIDHashID->encode($task->id)}}">
                                                <span class="glyphicon glyphicon-trash"></span>
                                            </a>
                                            @endif
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
        <div class="col-sm-4">
            @include('elements.site_activities_user',['site_activity'=>$site_activities])
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