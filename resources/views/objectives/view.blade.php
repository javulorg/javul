@extends('layout.default')
@section('page-css')
<style>.related_para{margin:0 0 10px;}</style>
@endsection
@section('content')

<div class="container">
    <div class="row form-group" style="margin-bottom:15px">
        @include('elements.user-menu',['page'=>'objectives'])
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
                                    {{$objectiveObj->unit->name}}
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
                                <label class="control-label colorLightBlue upper">SOFTWARE</label>
                            </div>
                        </div>
                    </div>
                    <div class="list-group-item">
                        <div class="row">
                            <div class="col-xs-4 borderRT paddingTB7">
                                <label class="control-label upper">UNIT LOCATION</label>
                            </div>
                            <div class="col-xs-8 paddingTB7">
                                <label class="control-label colorLightBlue upper">{{\App\City::getName($taskObj->unit->city_id)}}</label>
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
                                    <div class="col-xs-6 text-right">12456$</div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6">Awarded</div>
                                    <div class="col-xs-6 text-right">6563131$</div>
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
                <div class="panel-heading current_objective_heading featured_unit_heading">
                    <div class="featured_unit current_objective">
                        <i class="fa fa-bullseye"></i>
                    </div>
                    <h4>OBJECTIVE INFORMATION</h4>
                </div>
                <div style="padding: 0px;" class="panel-body current_unit_body list-group">
                    <div class="list-group-item" style="padding-top:0px;padding-bottom:0px;">
                        <div class="row" style="border-bottom:1px solid #ddd;">
                            <div class="col-sm-7 featured_heading">
                                <h4 class="colorLightGreen">{{$objectiveObj->name}}</h4>
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

                        <div class="row">
                            <div class="col-xs-7 featured_heading" style="min-height: 150px">
                                {!! $objectiveObj->description !!}
                            </div>
                            <div class="col-xs-5 featured_heading text-right colorLightBlue obj_info_div">
                                <div class="row">
                                    <div class="col-xs-4">
                                        <label class="control-label upper" style="width: 100%;">
                                            <span class="fund_icon">FUND</span>
                                            <span class="text-right pull-right"> <div class="fund_paid"><i class="fa fa-plus"></i></div></span>
                                        </label>
                                    </div>
                                    <div class="col-xs-8 text-left borderLFT pdngtop10">
                                        <div>
                                            <label class="control-label">
                                                Available
                                            </label>
                                            <label class="control-label colorLightBlue label-value pull-right">12331 $</label>
                                        </div>
                                        <div>
                                            <label class="control-label">
                                                Available
                                            </label>
                                            <label class="control-label colorLightBlue label-value pull-right">12331 $</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row borderBTM lnht30">
                                    <div class="col-xs-4 text-left">
                                        <label class="control-label upper">Status</label>
                                    </div>
                                    <div class="col-xs-8 borderLFT text-left">
                                        <label class="control-label">In Progress</label>
                                    </div>
                                </div>
                                <div class="row borderBTM lnht30">
                                    <div class="col-xs-4 text-left">
                                        <label class="control-label upper">SUPPORT</label>
                                    </div>
                                    <div class="col-xs-8 borderLFT">
                                        <div class="importance-div">
                                            @include('objectives.partials.importance_level',['objective_id'=>$objectiveObj->id])
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                        @if(count($objectiveObj->tasks) > 0)
                        @foreach($objectiveObj->tasks as $obj)
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
                    <h4>RELATION TO OTHER OBJECTIVES</h4>
                </div>
                <div class="panel-body list-group">
                    <div class="list-group-item">
                        <div class="row">
                            <div class="col-sm-6">
                                <label class="control-label">
                                    Parent Objective
                                </label>
                                <label class="control-label colorLightBlue form-control label-value">
                                    <?php $objSlug = \App\Objective::getSlug($objectiveObj->parent_id); ?>
                                    <a style="font-weight: normal;" class="no-decoration" href="{!! url('objectives/'
                                    .$objectiveIDHashID->encode
                                    ($objectiveObj->parent_id).'/'.$objSlug ) !!}">
                                        {{\App\Objective::getObjectiveName($objectiveObj->parent_id)}}
                                    </a>
                                </label>
                            </div>
                            <div class="col-sm-6">
                                <label class="control-label">
                                    Child Objective
                                </label>
                                <label class="control-label colorLightGreen form-control label-value">
                                    -
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('elements.footer')
@endsection
@section('page-scripts')
<script>
    $(function(){
        $(".both-div").css("min-height",($(".objective-desc").height())+10+'px');

        $(document).off('click','.vote').on('click',".vote",function(){
            var type = $(this).attr('data-type');

            if(type == "up")
                var flag =!$(this).hasClass('success-upvote');
            else if(type=="down")
                var flag =!$(this).hasClass('success-downvote');
            else
                return false;

            if(flag){
                var that = $(this);
                var id=$(this).attr('data-id');
                if($.trim(id) != ""){
                    $.ajax({
                        type:'post',
                        url:siteURL+'/objectives/importance',
                        data:{_token:'{!! csrf_token() !!}',id:id,type:type},
                        dataType:'json',
                        success:function(resp){
                            if(resp.success){
                                $(".importance-div").html(resp.html);
                                if(type == "up")
                                {
                                    that.removeClass('text-success').addClass('success-upvote');
                                    $(".downvote[data-id='" + id + "']").removeClass('success-downvote').addClass
                                        ('text-danger');
                                }
                                else{
                                    that.removeClass('text-danger').addClass('success-downvote');
                                    $(".upvote[data-id='" + id + "']").removeClass('success-upvote').addClass
                                        ('text-success');
                                }
                            }

                        }
                    })
                }
            }
            return false;
        });
    })
</script>
@endsection