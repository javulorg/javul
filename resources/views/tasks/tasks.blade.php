@extends('layout.default')
@section('content')
<div class="container">
    <div class="row">
        @include('elements.user-menu',['page'=>'tasks'])
    </div>
    <div class="row form-group">
        <div class="col-sm-8">
            <div class="panel panel-default panel-dark-grey">
                <div class="panel-heading">
                    <h4>Tasks</h4>
                </div>
                <div class="panel-body table-inner table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Task Name</th>
                            <th>Objective Name</th>
                            <th>Unit Name</th>
                            <th>Skills</th>
                            <th>Assigned to</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($tasks) > 0 )
                            @foreach($tasks as $task)
                                <tr>
                                    <td><a href="{!! url('tasks/'.$taskIDHashID->encode($task->id)) !!}">{{$task->name}}</a></td>
                                    <td>
                                        <a href="{!! url('objectives/'.$objectiveIDHashID->encode($task->objective_id))
                                        !!}">{{$task->objective_name}}</a>
                                    </td>
                                    <td>
                                        <a href="{!! url('units/'.$unitIDHashID->encode($task->unit_id)) !!}">{{$task->unit_name}}</a>
                                    </td>
                                    <td>
                                        {!! \App\JobSkill::getSkillNameLink($task->skills) !!}
                                    </td>
                                    <td>
                                        @if(empty($task->assigned_to))
                                            -
                                        @else
                                        @endif
                                    </td>
                                    <td>{{ucfirst($task->status)}}</td>
                                    <td>
                                        @if(\Auth::check())
                                        <a class="btn btn-xs btn-primary"
                                           href="{!! url('tasks/edit/'.$taskIDHashID->encode($task->id)) !!}" title="edit">
                                            <span class="glyphicon glyphicon-edit"></span>
                                        </a>
                                        @endif
                                        <?php $unitAdminID = \App\Task::checkUnitAdmin($task->unit_id); ?>
                                        @if(!empty($authUserObj) && ($authUserObj->role == "superadmin" || $unitAdminID ==
                                        $authUserObj->id))
                                            <a title="delete" href="#" class="btn btn-xs btn-danger delete-task"
                                               data-id="{{$taskIDHashID->encode($task->id)}}">
                                                <span class="glyphicon glyphicon-trash"></span>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                        <tr>
                            <td colspan="7">No record(s) found.</td>
                        </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <a href="{!! url('tasks/create')!!}"class="btn orange-bg" id="add_task_btn" type="button">
                <span class="glyphicon glyphicon-plus"></span> Add Task
            </a>
        </div>
        <div class="col-sm-4">
            @include('elements.site_activities')
        </div>
    </div>
</div>
@include('elements.footer')
@stop
@section('page-scripts')
<script type="text/javascript">
    var msg_flag ='{{ $msg_flag }}';
    var msg_type ='{{ $msg_type }}';
    var msg_val ='{{ $msg_val }}';
</script>
<script src="{!! url('assets/js/custom_tostr.js') !!}" type="text/javascript"></script>
<script src="{!! url('assets/js/tasks/delete_task.js') !!}"></script>
@endsection