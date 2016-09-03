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
                @include('units.partials.unit_information_left_table',['unitObj'=>$objectiveObj->unit,'availableFunds'=>0,'awardedFunds'=>0])
                <div class="left" style="position: relative;">
                    <div class="loading_dots" style="position: absolute;top:20%;left:43%;z-index: 9999;display: none;">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    <div class="site_activity_list">
                        @include('elements.site_activities')
                    </div>
                </div>
            </div>
            <div class="col-md-8">
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
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($objectiveObj) > 0)
                                @foreach($objectiveObj as $obj)
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
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5">No record(s) found.</td>
                                </tr>
                            @endif

                            <tr style="background-color: #fff;text-align: right;">
                                <td colspan="5">
                                    <a class="btn black-btn" id="add_objective_btn" href="{!! url('objectives/'.$unitIDHashID->encode($unit_activity_id).'/add') !!}">
                                        <i class="fa fa-plus"></i> <span class="plus_text">{!! trans('messages.add_objective') !!}</span>
                                    </a>

                                    <a href="{!! url('units/add')!!}"class="btn more-black-btn" id="add_unit_btn"
                                       type="button">
                                        <span class="more_dots">...</span> MORE OBJECTIVE
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
