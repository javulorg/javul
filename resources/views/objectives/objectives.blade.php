@extends('layout.default')
@section('content')
<div class="container">
    <div class="row">
        @include('elements.user-menu',['page'=>'objectives'])
    </div>
    <div class="row form-group">
        <div class="col-sm-8">
            <div class="panel panel-default panel-dark-grey">
                <div class="panel-heading">
                    <h4>{!! trans('messages.objectives') !!}</h4>
                </div>
                <div class="panel-body table-inner table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Objective Name</th>
                            <th>Unit Name</th>
                            <th>Created By</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($objectives) > 0 )
                        @foreach($objectives as $objective)
                        <tr>
                            <td><a href="{!! url('objectives/'.$objectiveIDHashID->encode($objective->id)) !!}">{{$objective->name}}</a></td>
                            <td><a href="{!! url('units/'.$unitIDHashID->encode($objective->unit_id)) !!}">{{$objective->unit_name}}</a></td>
                            <td><a href="{!! url('users/'.$userIDHashID->encode($objective->user_id)) !!}">{{$objective->first_name.' '.$objective->last_name}}</a></td>
                            <td>{{$objective->status}}</td>
                            <td>
                                @if(\Auth::check())
                                <a class="btn btn-xs btn-primary"
                                   href="{!! url('objectives/'.$objectiveIDHashID->encode($objective->id).'/edit') !!}" title="edit">
                                    <span class="glyphicon glyphicon-edit"></span>
                                </a>
                                @endif
                                <?php $unitAdminID = \App\Task::checkUnitAdmin($objective->unit_id); ?>

                                @if(!empty($authUserObj) && ($authUserObj->role == "superadmin" || $unitAdminID ==
                                $authUserObj->id))
                                <a title="delete" href="#" class="btn btn-xs btn-danger delete-objective"
                                   data-id="{{$objectiveIDHashID->encode($objective->id)}}">
                                    <span class="glyphicon glyphicon-trash"></span>
                                </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="5">No record(s) found.</td>
                        </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <a href="{!! url('objectives/add')!!}"class="btn orange-bg" id="add_objective_btn" type="button">
                <span class="glyphicon glyphicon-plus"></span> {!! trans('messages.add_objective') !!}
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
<script src="{!! url('assets/js/objectives/delete_objective.js') !!}"></script>
@endsection