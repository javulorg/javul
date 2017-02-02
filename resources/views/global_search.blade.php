@extends('layout.default')
@section('content')
    <div class="container">
        <div class="row form-group" style="margin-bottom:15px">
            @include('elements.user-menu',array('page'=>'home'))
        </div>
        <div class="row">
            <div class="col-md-4 left">
                <div class="site_activity_list">
                    <div class="site_activity_loading loading_dots" style="position: absolute;top:20%;left:43%;z-index: 9999;display: none;">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    @include('elements.site_activities',['ajax'=>false])
                </div>
            </div>
            <div class="col-md-8 right">
                <div class="row form-group">
                    <div class="col-sm-12">
                        <div class="panel panel-grey panel-default">
                            <div class="panel-heading">
                                <h4>UNITS</h4>
                            </div>
                            <div class="panel-body list-group">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Categories</th>
                                            <th>Location</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(!empty($unitObj) && count($unitObj) > 0)
                                            @foreach($unitObj as $unit)
                                                <?php $categories = \App\Unit::getCategoryNames($unit->category_id); ?>
                                                <tr>
                                                    <td width="70%">
                                                        <a href="{!! url('units/'.$unitIDHashID->encode($unit->id).'/'.$unit->slug) !!}"
                                                           class="colorLightBlue" >
                                                            {{$unit->name}}
                                                        </a>
                                                    </td>
                                                    <td width="15%">
                                                        <a href="#">{{$categories}}</a>
                                                    </td>
                                                    <td>
                                                        @if(empty($unit->city_id) && $unit->country_id == 247)
                                                            GLOBAL
                                                        @else
                                                            {{\App\City::getName($unit->city_id)}}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="3">No unit found.</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-12">
                        <div class="panel panel-grey panel-default">
                            <div class="panel-heading">
                                <h4>Objectives</h4>
                            </div>
                            <div class="panel-body list-group">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Objective Name</th>
                                        <th>Unit Name</th>
                                        <th>Created By</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($objectiveObj) > 0 )
                                        @foreach($objectiveObj as $objective)
                                            <?php $unitslug =\App\Unit::getSlug($objective->unit_id); ?>
                                            <tr>
                                                <td><a href="{!! url('objectives/'.$objectiveIDHashID->encode($objective->id).'/'.$objective->slug)!!}">{{$objective->name}}</a></td>
                                                <td><a href="{!! url('units/'.$unitIDHashID->encode($objective->unit_id).'/'.$unitslug )!!}">{{\App\Unit::getUnitName($objective->unit_id)}}</a></td>
                                                <td><a href="{!! url('userprofiles/'.$userIDHashID->encode($objective->user_id).'/'.strtolower(str_replace(" ","_",\App\User::getUserName($objective->user_id))))!!}">
                                                        {{\App\User::getUserName($objective->user_id)}}
                                                    </a>
                                                </td>
                                                <td>{{$objective->status}}</td>
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
                </div>

                <div class="row form-group">
                    <div class="col-sm-12">
                        <div class="panel panel-grey panel-default">
                            <div class="panel-heading">
                                <h4>Tasks</h4>
                            </div>
                            <div class="panel-body list-group">
                                <table class="table table-striped tasks-table" style="overflow:hidden !important; ">
                                    <thead>
                                        <tr>
                                            <th>Task Name</th>
                                            <th>Objective Name</th>
                                            <th>Unit Name</th>
                                            <th>Skills</th>
                                            <th>Assigned to</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($taskObj) > 0 )
                                            @foreach($taskObj as $task)
                                                @include('tasks.partials.task_listing',['task'=>$task])
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
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-sm-12">
                        <div class="panel panel-grey panel-default">
                            <div class="panel-heading">
                                <h4>Issues</h4>
                            </div>
                            <div class="panel-body list-group">
                                <table class="table table-striped unit-table">
                                    <thead>
                                    <tr>
                                        <th>Creation Date</th>
                                        <th>Issue Title</th>
                                        <th>Unit Name</th>
                                        <th>Issue Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($issueObj) > 0 )
                                            @foreach($issueObj as $issue)

                                                <tr>
                                                    <td>{!! \App\Library\Helpers::timetostr($issue->created_at) !!}</td>
                                                    <td>
                                                        <a href="{!! url('issues/'.$issueIDHashID->encode($issue->id).'/view') !!}">
                                                            {{$issue->title}}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="{!! url('units/'.$unitIDHashID->encode($issue->unit_id).'/'.\App\Unit::getSlug($issue->unit_id)) !!}">
                                                            {{\App\Unit::getUnitName($issue->unit_id)}}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        {{$issue->status}}
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
    </div>
    @include('elements.footer')
@endsection