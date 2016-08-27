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
            <div class="panel panel-grey panel-default">
                <div class="panel-heading">
                    <h4>UNIT INFORMATION</h4>
                </div>
                <div class="panel-body unit-info-panel list-group">
                    <div class="list-group-item">
                        <div class="row">
                            <div class="col-xs-12">
                                <label class="control-label upper">UNIT NAME</label>
                                <label class="control-label colorLightGreen form-control label-value">
                                    {{$unitObj->name}}
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="list-group-item">
                        <div class="row">
                            <div class="col-xs-4 unit-info-main-div">
                                <label class="control-label upper">UNIT LINKS</label>
                            </div>
                            <div class="col-xs-8" style="padding-top: 7px;">
                                <div class="row unit_info_row_1">
                                    <div class="col-xs-12">
                                        <ul class="unit_info_link_1" style="">
                                            <li><a href="#" class="colorLightBlue upper">OBJECTIVES</a></li>
                                            <li class="mrgrtlt5">|</li>
                                            <li><a href="#" class="colorLightBlue upper">TASKS</a></li>
                                            <li class="mrgrtlt5">|</li>
                                            <li><a href="#" class="colorLightBlue upper">ISSUES</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <ul class="unit_info_link_2">
                                            <i class="fa fa-quote-right colorLightBlue"></i>
                                            <li><a href="#" class="colorLightBlue upper">FORUM</a></li>
                                            <i class="fa fa-comments colorLightBlue"></i>
                                            <li><a href="#" class="colorLightBlue upper">CHAT</a></li>
                                            <i class="fa fa-wikipedia-w colorLightBlue"></i>
                                            <li><a href="#" class="colorLightBlue upper">WIKI</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="list-group-item">
                        <div class="row">
                            <div class="col-xs-4 borderRT paddingTB7">
                                <label class="control-label upper">OTHER LINKS</label>
                            </div>
                            <div class="col-xs-8 paddingTB7">
                                <label class="control-label colorLightBlue">LINK1, LINK2</label>
                            </div>
                        </div>
                    </div>
                    <div class="list-group-item">
                        <div class="row">
                            <div class="col-xs-4 borderRT paddingTB7">
                                <label class="control-label upper">UNIT CATEGORIES</label>
                            </div>
                            <div class="col-xs-8 paddingTB7">
                                <label class="control-label colorLightBlue upper">{{$unitObj->category_name}}</label>
                            </div>
                        </div>
                    </div>
                    <div class="list-group-item">
                        <div class="row">
                            <div class="col-xs-4 borderRT paddingTB7">
                                <label class="control-label upper">UNIT LOCATION</label>
                            </div>
                            <div class="col-xs-8 paddingTB7">
                                <label class="control-label colorLightBlue upper">{{$cityName}}</label>
                            </div>
                        </div>
                    </div>
                    <div class="list-group-item">
                        <div class="row">
                            <div class="col-xs-4 borderRT paddingTB7">
                                <label class="control-label upper" style="width: 100%;">
                                    FUND
                                    <span class="text-right pull-right"> <div class="fund_paid"><i class="fa fa-plus"></i></div></span>
                                </label>
                            </div>
                            <div class="col-xs-8 paddingTB7">
                                <div class="row">
                                    <div class="col-xs-6">Available</div>
                                    <div class="col-xs-6">{{number_format($availableFunds,0)}}$</div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6">Awarded</div>
                                    <div class="col-xs-6">{{number_format($awardedFunds,0)}}$</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="left">
                @include('elements.site_activities')
            </div>
        </div>
        <div class="col-md-8">
            <div class="panel panel-grey panel-default">
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
                                    <i class="fa fa-eye" style="margin-right:2px"></i><i class="fa fa-plus"></i>
                                </div>
                                <div class="col-xs-2 text-center">
                                    <i class="fa fa-pencil"></i>
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

            <div class="panel panel-grey panel-default">
                <div class="panel-heading">
                    <h4>OBJECTIVES</h4>
                </div>
                <div class="panel-body list-group">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Objective Name</th>
                            <th>Support</th>
                            <th>In progress</th>
                            <th>Available</th>
                            @if(\Auth::check())
                            <th></th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($objectivesObj) > 0)
                        @foreach($objectivesObj as $obj)
                        <tr>
                            <td>
                                <a href="{!! url('objectives/'.$objectiveIDHashID->encode($obj->id).'/'.$obj->slug) !!}"
                                   title="edit">
                                    {{$obj->name}}
                                </a>
                            </td>
                            <td>{{\App\Task::getTaskCount('available',$obj->id)}}</td>
                            <td>{{\App\Task::getTaskCount('in-progress',$obj->id)}}</td>
                            <td>{{\App\Task::getTaskCount('completed',$obj->id)}}</td>
                            @if(\Auth::check())
                            <td>
                                <a class="btn btn-xs btn-primary"
                                   href="{!! url('objectives/'.$objectiveIDHashID->encode($obj->id).'/edit') !!}" title="edit">
                                    <span class="glyphicon glyphicon-edit"></span>
                                </a>
                            </td>
                            @endif
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

            <div class="panel panel-grey panel-default">
                <div class="panel-heading">
                    <h4>TASKS</h4>
                </div>
                <div class="panel-body list-group">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Task Name</th>
                            <th>Status</th>
                            <th><i class="fa fa-trophy"></i></th>
                            <th><i class="fa fa-clock-o"></i></th>
                            @if(\Auth::check())
                            <th></th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($objectivesObj) > 0)
                            @foreach($objectivesObj as $obj)
                                <tr>
                                    <td>
                                        <a href="{!! url('objectives/'.$objectiveIDHashID->encode($obj->id).'/'.$obj->slug) !!}"
                                           title="edit">
                                            {{$obj->name}}
                                        </a>
                                    </td>
                                    <td>{{\App\Task::getTaskCount('available',$obj->id)}}</td>
                                    <td>{{\App\Task::getTaskCount('in-progress',$obj->id)}}</td>
                                    <td>{{\App\Task::getTaskCount('completed',$obj->id)}}</td>
                                    @if(\Auth::check())
                                    <td>
                                        <a class="btn btn-xs btn-primary"
                                           href="{!! url('objectives/'.$objectiveIDHashID->encode($obj->id).'/edit') !!}" title="edit">
                                            <span class="glyphicon glyphicon-edit"></span>
                                        </a>
                                    </td>
                                    @endif
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
            <div class="panel panel-grey panel-default">
                <div class="panel-heading">
                    <h4>ISSUES</h4>
                </div>
                <div class="panel-body list-group">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Issue Name</th>
                            <th>Status</th>
                            <th>Support</th>
                            <th><i class="fa fa-clock-o"></i> </th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr>
                            <td colspan="5">No record(s) found.</td>
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
