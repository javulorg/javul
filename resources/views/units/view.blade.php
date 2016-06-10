@extends('layout.default')
@section('content')
<div class="container">
    <div class="row">
        @include('elements.user-menu',['page'=>'units'])
    </div>
    <div class="row form-group">
        <div class="col-sm-12 ">
            <div class="col-sm-6 grey-bg unit_description">
                <h1 class="unit-heading"><span class="glyphicon glyphicon-list-alt"></span> {{$unitObj->name}}</h1><br /><br />
                <p><span class="glyphicon glyphicon-map-marker"> </span> &nbsp;{{$cityName->name}}</p>
                <p><span class="glyphicon glyphicon-tag"> </span> &nbsp; {{$unitObj->category_name}}</p>
            </div>
            <div class="col-sm-6 grey-bg unit_description">
                <div class="row">
                    <div class="col-sm-offset-5 col-sm-7">
                        <div class="panel form-group marginTop20">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <strong>{!! trans('messages.unit_funds')!!}</strong>
                                    </div>
                                    <div class="col-xs-6">{!! trans('messages.available') !!}</div>
                                    <div class="col-xs-6 text-right">XXX $</div>
                                    <div class="col-xs-6">{!! trans('messages.awarded') !!}</div>
                                    <div class="col-xs-6 text-right">XXX $</div>
                                </div>
                            </div>
                        </div>
                        <div class="panel">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-5">
                                        <strong>{!! trans('messages.unit_links') !!}</strong>
                                    </div>
                                    <div class="col-xs-7 text-right">
                                        <a href="#">{!! trans('messages.forum') !!}</a> | <a href="#">{!! trans('messages.wiki') !!}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row form-group">
        <div class="col-sm-12">
            <div class="panel panel-default panel-dark-grey">
                <div class="panel-heading">
                    <h4>{!! trans('messages.objectives') !!}</h4>
                </div>
                <div class="panel-body table-inner table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th></th>
                            <th>{!! trans('messages.importance') !!}</th>
                            <th>{!! trans('messages.date_created') !!}</th>
                            <th>{!! trans('messages.title') !!}</th>
                            <th>{!! trans('messages.task_statistics') !!}</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>{!! trans('messages.available') !!}</th>
                            <th>{!! trans('messages.in_progress') !!}</th>
                            <th>{!! trans('messages.completed') !!}</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                            @if(count($objectivesObj) > 0)
                                @foreach($objectivesObj as $obj)
                                    <tr>
                                        <td>
                                            <span class="glyphicon glyphicon-thumbs-up text-success upvote" title="upvote"></span>
                                            <span class="glyphicon glyphicon-thumbs-down text-danger downvote" title="downvote"></span>
                                        </td>
                                        <td>1</td>
                                        <td>{{\App\Library\Helpers::timetostr($obj->created_at)}}</td>
                                        <td>{{$obj->name}}</td>
                                        <td>{{\App\Task::getTaskCount('available',$obj->id)}}</td>
                                        <td>{{\App\Task::getTaskCount('in-progress',$obj->id)}}</td>
                                        <td>{{\App\Task::getTaskCount('completed',$obj->id)}}</td>
                                        <td>
                                            @if(\Auth::check())
                                            <a class="btn btn-xs btn-primary"
                                               href="{!! url('objectives/edit/'.$objectiveIDHashID->encode($obj->id)) !!}" title="edit">
                                                <span class="glyphicon glyphicon-edit"></span>
                                            </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6">No record(s) found.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <a class="btn orange-bg" id="add_objective_btn" href="{!! url('objectives/create') !!}">
                <span class="glyphicon glyphicon-plus"></span> {!! trans('messages.add_objective') !!}
            </a>
            <!--<button class="btn orange-bg" id="see_all_objective_btn" type="button">{!! trans('messages.see_all_objectives') !!}</button>-->
        </div>
    </div>
    <!--<div class="row form-group">
        <div class="col-sm-12">
            <div class="panel panel-default panel-dark-grey">
                <div class="panel-heading">
                    <h4>{!! trans('messages.tasks') !!}</h4>
                </div>
                <div class="panel-body table-inner table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>{!! trans('messages.date_created') !!}</th>
                            <th>{!! trans('messages.title') !!}</th>
                            <th>{!! trans('messages.objective') !!}</th>
                            <th>{!! trans('messages.status') !!}</th>
                            <th>{!! trans('messages.award') !!}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($taskObj) > 0)
                            @foreach($taskObj as $task)
                                <tr>
                                    <td>2 weeks ago</td>
                                    <td>Task number 1</td>
                                    <td>Title of Objective for this task</td>
                                    <td>Assigned to User 1</td>
                                    <td>$ 10</td>
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
        </div>
        <div class="col-sm-12">
            <button class="btn orange-bg" type="button" id="add_task_btn"><span class="glyphicon glyphicon-plus"></span> {!! trans('messages.add_task') !!}</button>
            <button class="btn orange-bg" type="button" id="see_all_task_btn">{!! trans('messages.see_all_tasks') !!}</button>
        </div>
    </div>-->
    <div class="row form-group">
        <div class="col-sm-6 col-xs-12">
            @include('elements.site_activities')
        </div>
    </div>
</div>
@include('elements.footer')
@stop
