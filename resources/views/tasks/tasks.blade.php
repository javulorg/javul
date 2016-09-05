@extends('layout.default')
@section('content')
<div class="container">
    <div class="row form-group" style="margin-bottom: 15px;">
        @include('elements.user-menu',['page'=>'tasks'])
    </div>
    <div class="row form-group">
        <div class="col-sm-4">
            <div class="left">
                <div class="loading_dots" style="position: absolute;top:20%;left:43%;z-index: 9999;display: none;">
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
            <div class="panel panel-default panel-grey">
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
                                @include('tasks.partials.task_listing',['task'=>$task])
                            @endforeach
                        @else
                        <tr>
                            <td colspan="7">No record(s) found.</td>
                        </tr>
                        @endif
                        <tr style="background-color: #fff;text-align: right;">
                            <td colspan="7" >
                                <a href="{!! url('tasks/add')!!}"class="btn black-btn form-group" id="add_task_btn" type="button">
                                    <i class="fa fa-plus plus"></i> <span class="plus_text">Add Task</span>
                                </a>

                                <a href="{!! url('tasks/add')!!}"class="btn more-black-btn form-group" id="add_unit_btn"
                                   type="button">
                                    <span class="more_dots">...</span> MORE TASKS
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

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