@extends('layout.default')
@section('content')

    <div class="container">
        <div class="row form-group">
            @include('elements.user-menu',array('page'=>'home'))
        </div>
        <!--<div class="row form-group">
            <div class="col-sm-12">
                <h2><strong>Objective: Change the World</strong></h2>
                <div>Explore projects, everywhere</div>
            </div>
        </div>-->
        <div class="row">
            <div class="col-sm-8">
                <div class="row form-group">
                    <div class="col-sm-12">
                        <div class="panel panel-dark-grey panel-default">
                            <div class="panel-heading">
                                <h4>{!! Lang::get('messages.recent_units') !!}</h4>
                            </div>
                            <div class="panel-body list-group">
                                @if(count($recentUnits) > 0)
                                    @foreach($recentUnits as $unit)
                                        <a href="{!! url('units/'.$unitIDHashID->encode($unit->id)) !!}" class="list-group-item"><span
                                                class="glyphicon glyphicon-dot"></span>
                                            {{$unit->name}}
                                        </a>
                                    @endforeach
                                @else
                                <div class="list-group-item">
                                    No Unit found.
                                </div>
                                @endif
                            </div>
                        </div>
                        @if(count($recentUnits) > 5)
                            <!--<a class="btn orange-bg" href="{!! url('') !!}">{!! Lang::get('messages.all_units') !!}</a>-->
                        @endif
                        <!--<a class="btn orange-bg" href="{!! url('units/create') !!}">{!! Lang::get('messages.create_units') !!}</a>-->
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-12">
                        <div class="panel panel-dark-grey panel-default">
                            <div class="panel-heading">
                                <h4>{!! Lang::get('messages.recent_objective') !!}</h4>
                            </div>
                            <div class="panel-body list-group">
                                @if(count($recentObjectives) > 0)
                                    @foreach($recentObjectives as $objective)
                                        <a href="{!! url('objectives/view/'.$objectiveIDHashID->encode($objective->id)) !!}"
                                           class="list-group-item"><span class="glyphicon glyphicon-dot"></span>
                                            {{$objective->name}}
                                        </a>
                                    @endforeach
                                @else
                                    <div class="list-group-item">
                                        No objective found.
                                    </div>
                                @endif
                            </div>
                        </div>
                        @if(count($recentObjectives) > 5)
                            <!--<button class="btn orange-bg">{!! Lang::get('messages.all_objectives') !!}</button>-->
                        @endif
                        <!--<button class="btn orange-bg">{!! Lang::get('messages.create_objectives') !!}</button>-->
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-12">
                        <div class="panel panel-dark-grey panel-default">
                            <div class="panel-heading">
                                <h4>{!! Lang::get('messages.recent_tasks') !!}</h4>
                            </div>
                            <div class="panel-body list-group">
                                @if(count($recentTasks) > 0)
                                    @foreach($recentTasks as $task)
                                        <a href="{!! url('task/view/'.$taskIDHashID->encode($task->id)) !!}" class="list-group-item">
                                            <span class="glyphicon glyphicon-dot"></span>
                                            {{$task->name}}
                                        </a>
                                    @endforeach
                                @else
                                    <div class="list-group-item">
                                        No task found.
                                    </div>
                                @endif
                            </div>
                        </div>
                        @if(count($recentTasks) > 5)
                            <!--<button class="btn orange-bg">{!! Lang::get('messages.all_tasks') !!}</button>-->
                        @endif
                        <!--<button class="btn orange-bg">{!! Lang::get('messages.create_tasks') !!}</button>-->
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="panel panel-dark-grey panel-default">
                    <div class="panel-heading">
                        <h4>{!! Lang::get('messages.most_recent_users') !!}</h4>
                    </div>
                    <div class="panel-body list-group">
                        @if(count($recentUsers) > 0 )
                            @foreach($recentUsers as $user)
                                <a href="{!! url('user/view/'.$userIDHashID->encode($user->id)) !!}" class="list-group-item">
                                    <span class="glyphicon glyphicon-user"></span>
                                    {{$user->first_name.' '.$user->last_name}}
                                </a>
                            @endforeach
                        @else
                            <div class="list-group-item">
                                No user found.
                            </div>
                        @endif
                    </div>
                </div>
                @include('elements.site_activities')
            </div>
        </div>
    </div>
    @include('elements.footer')
@endsection