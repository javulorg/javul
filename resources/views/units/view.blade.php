@extends('layout.default')
@section('page-css')
<style>
    .related_para{margin:0 0 10px;}
</style>
@endsection
@section('content')
<div class="container">
    <div class="row form-group" style="margin-bottom: 15px;">
        @include('elements.user-menu',['page'=>'units'])
    </div>
    <div class="row form-group">
        <div class="col-md-4">
            @include('units.partials.unit_information_left_table')
            <div class="left" style="position: relative;margin-top: 30px;">
                <div class="site_activity_loading loading_dots" style="position: absolute;top:20%;left:43%;z-index: 9999;display: none;">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <div class="site_activity_list">
                    @include('elements.site_activities',['ajax'=>false])
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="panel panel-grey panel-default" style="margin-bottom: 30px;">
                <div class="panel-heading current_unit_heading featured_unit_heading">
                    <div class="featured_unit current_unit">
                        <i class="fa fa-stack-overflow"></i>
                    </div>
                    <h4>UNIT INFORMATION</h4>
                </div>
                <div class="panel-body current_unit_body" style="padding-top:0px">
                    <div class="row">
                        <div class="col-sm-7 featured_heading">
                            <h4 class="colorLightGreen">{{$unitObj->name}}</h4>
                        </div>
                        <div class="col-sm-5 featured_heading text-right colorLightBlue">
                            <div class="row">
                                <div class="col-xs-3 text-center">
                                    <a class="add_to_my_watchlist" data-type="unit" data-id="{{$unitIDHashID->encode($unitObj->id)}}">
                                        <i class="fa fa-eye" style="margin-right:2px"></i>
                                        <i class="fa fa-plus plus"></i>
                                    </a>
                                </div>
                                <div class="col-xs-2 text-center">
                                    <a href="{!! url('units/'.$unitIDHashID->encode($unitObj->id).'/edit') !!}" title="Edit Unit">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                </div>
                                <div class="col-xs-7 text-center">
                                    <i class="fa fa-history"></i> REVISION HISTORY
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr style="margin-top: 0px;">
                    {!! $unitObj->description !!}
                </div>
            </div>

            <div class="panel panel-grey panel-default" style="margin-bottom: 30px;">
                <div class="panel-heading">
                    <h4>OBJECTIVES</h4>
                </div>
                <div class="panel-body list-group loading_content_hide" style="position:relative;">
                    <div class="loading_dots objective_loading" style="position: absolute;top:0;left:43%;z-index: 9999;display:none;">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    <table class="table table-striped objective-table">
                        <thead>
                        <tr>
                            <th>Objective Name</th>
                            <th class="text-center">Support</th>
                            <th class="text-center">In progress</th>
                            <th class="text-center">Available</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($objectivesObj) > 0)
                            @foreach($objectivesObj as $obj)
                                <tr>
                                    <td>
                                        <a href="{!! url('objectives/'.$objectiveIDHashID->encode($obj->id).'/'.$obj->slug) !!}" title="edit">
                                            {{$obj->name}}
                                        </a>
                                    </td>
                                    <td  class="text-center">{{\App\Task::getTaskCount('available',$obj->id)}}</td>
                                    <td  class="text-center">{{\App\Task::getTaskCount('in-progress',$obj->id)}}</td>
                                    <td  class="text-center">{{\App\Task::getTaskCount('completed',$obj->id)}}</td>
                                </tr>
                            @endforeach
                        @else
                        <tr>
                            <td colspan="5">No record(s) found.</td>
                        </tr>
                        @endif

                        <tr style="background-color: #fff;text-align: right;">
                            <td colspan="5">
                                <a class="btn black-btn" id="add_objective_btn" href="{!! url('objectives/'.$unitIDHashID->encode
                                ($unitObj->id).'/add') !!}">
                                    <i class="fa fa-plus plus"></i> <span class="plus_text">{!! trans('messages.add_objective') !!}</span>
                                </a>
                                @if($objectivesObj->lastPage() > 1 && $objectivesObj->lastPage() != $objectivesObj->currentPage())
                                    <a href="#" data-url="{{$objectivesObj->url($objectivesObj->currentPage()+1) }}" data-unit_id="{{$unitIDHashID->encode($unitObj->id)}}" class="btn
                                    more-black-btn more-objectives" data-from_page="unit_view" type="button">
                                        <span class="more_dots">...</span> MORE OBJECTIVES
                                    </a>
                                @endif
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="panel panel-grey panel-default" style="margin-bottom: 30px;">
                <div class="panel-heading">
                    <h4>TASKS</h4>
                </div>
                <div class="panel-body list-group loading_content_hide" style="position: relative;">
                    <div class="loading_dots task_loading" style="position: absolute;top:0%;left:43%;z-index: 9999;display: none;">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    <table class="table table-striped tasks-table">
                        <thead>
                        <tr>
                            <th>Task Name</th>
                            <th class="text-center">Status</th>
                            <th class="text-center"><i class="fa fa-trophy"></i></th>
                            <th class="text-center"><i class="fa fa-clock-o"></i></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($taskObj) > 0)
                            @foreach($taskObj as $obj)
                                <tr>
                                    <td width="60%">
                                        <a href="{!! url('tasks/'.$taskIDHashID->encode($obj->id).'/'.$obj->slug) !!}"
                                           title="edit">
                                            {{$obj->name}}
                                        </a>
                                    </td>
                                    <td width="20%" class="text-center">
                                        @if($obj->status == "editable")
                                            <span class="colorLightGreen">{{\App\SiteConfigs::task_status($obj->status)}}</span>
                                        @else
                                            <span class="colorLightGreen">{{\App\SiteConfigs::task_status($obj->status)}}</span>
                                        @endif
                                    </td>
                                    <td class="text-center">{{\App\Task::getTaskCount('in-progress',$obj->id)}}</td>
                                    <td class="text-center">{{\App\Task::getTaskCount('completed',$obj->id)}}</td>
                                </tr>
                            @endforeach
                        @else
                        <tr>
                            <td colspan="5">No record(s) found.</td>
                        </tr>
                        @endif
                        <tr style="background-color: #fff;text-align: right;">
                            <td colspan="5">
                                <a class="btn black-btn" id="add_task_btn" href="{!! url('tasks/add?unit='.$unitIDHashID->encode($unitObj->id)) !!}">
                                    <i class="fa fa-plus plus"></i> <span class="plus_text">{!! trans('messages.add_task') !!}</span>
                                </a>

                                @if($taskObj->lastPage() > 1 && $taskObj->lastPage() != $taskObj->currentPage())
                                    <a href="#" data-url="{{$taskObj->url($taskObj->currentPage()+1) }}" data-unit_id="{{$unitIDHashID->encode($unitObj->id)}}"
                                       class="btn
                                    more-black-btn more-tasks" data-from_page="unit_view" type="button">
                                        <span class="more_dots">...</span> MORE TASKS
                                    </a>
                                @endif
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="panel panel-grey panel-default">
                <div class="panel-heading">
                    <h4>ISSUES</h4>
                </div>
                <div class="panel-body list-group">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Issue Name</th>
                            <th  class="text-center">Status</th>
                            <th  class="text-center">Support</th>
                            <th  class="text-center"><i class="fa fa-clock-o"></i> </th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr>
                            <td colspan="5">No record(s) found.</td>
                        </tr>
                        <tr style="background-color: #fff;text-align: right;">
                            <td colspan="4">
                                <a class="btn black-btn" id="add_issue_btn" href="#">
                                    <i class="fa fa-plus plus"></i> ADD ISSUE
                                </a>

                                <a href="#"class="btn more-black-btn" id="more_issue_btn" data-from_page="unit_view"
                                   type="button">
                                    <span class="more_dots">...</span> MORE ISSUE
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
@section('page-scripts')
<script>
    $(function(){
        $(".unit_description").css("min-height",($(".both-div").height())+10+'px');
    })
</script>
@endsection
