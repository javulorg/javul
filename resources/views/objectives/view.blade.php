@extends('layout.default')
@section('page-css')
<style>.related_para{margin:0 0 10px;}</style>
@endsection
@section('content')

<div class="container">
    <div class="row">
        @include('elements.user-menu',['page'=>'objectives'])
    </div>
    <div class="row form-group">
        <div class="col-sm-12">
            <div class="grey-bg both-div" style="min-height: 250px;">
                <div class="col-md-6 unit_description objective-desc">
                    <h1 class="unit-heading"><span class="glyphicon glyphicon-list-alt"></span> {{$objectiveObj->name}}</h1>
                    <div class="form-group">
                        {!! $objectiveObj->description !!}
                    </div>
                    <div>
                        @if(Auth::check())
                        <a class="btn orange-bg" id="edit_object" href="{!! url('objectives/'.$objectiveIDHashID->encode
                        ($objectiveObj->id).'/edit')!!}">
                            <span class="glyphicon glyphicon-pencil"></span> &nbsp;
                            {!! trans('messages.edit_objective') !!}
                        </a>
                        <div class="pull-right">
                            <?php
                            $upvote_class=" text-success";
                            $downvote_class=" text-danger";
                            $flag = \App\ImportanceLevel::checkImportanceLevel($objectiveObj->id);
                            if($flag == "1")
                                $upvote_class="success-upvote";
                            elseif($flag == "-1")
                                $downvote_class="success-downvote";
                            ?>
                            <span class="glyphicon glyphicon-thumbs-up vote upvote {{$upvote_class}}"
                                  data-id="{{ $objectiveIDHashID->encode($objectiveObj->id) }}"
                                  data-type="up"
                                  title="upvote"></span>
                            <span class="glyphicon glyphicon-thumbs-down vote downvote {{$downvote_class}}"
                                  data-id="{{ $objectiveIDHashID->encode($objectiveObj->id) }}"
                                  data-type="down"
                                  title="downvote"></span>
                            <div class="importance-div" style="padding-left: 15px;line-height: 30px;">
                                @include('objectives.partials.importance_level')
                            </div>
                        </div>
                        @else
                            <div class="importance-div" style="padding-left: 15px;line-height: 30px;">
                                @include('objectives.partials.importance_level')
                            </div>
                        @endif

                    </div>
                    @if( !empty($objectiveObj->parent_id))
                        <p></p>
                        <p class="related_para">Relations to Other Objective:</p>
                        <ul style="padding-left:15px;">
                            <li style="list-style: none;">Parent &nbsp;&nbsp;:
                                <a href="{!! url('objectives/'.$objectiveIDHashID->encode($objectiveObj->parent_id)) !!}">
                                    {{\App\Objective::getObjectiveName($objectiveObj->parent_id)}}
                                </a>
                            </li>
                        </ul>
                    @endif

                </div>
                <div class="col-md-6 unit_description">
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="panel form-group marginTop20">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <strong>{!! trans('messages.unit_funds') !!}</strong>
                                        </div>
                                        <div class="col-xs-6">{!! trans('messages.available') !!}</div>
                                        <div class="col-xs-6 text-right">xxx $</div>
                                        <div class="col-xs-6">{!! trans('messages.awarded') !!}</div>
                                        <div class="col-xs-6 text-right">xxx $</div>
                                        <div class="col-xs-12 text-right">
                                            <button class="btn orange-bg btn-sm" id="add_funds_btn">{!! trans('messages.add_funds') !!}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <div class="panel form-group marginTop20">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <strong>{!! trans('messages.unit_information') !!}</strong>
                                        </div>
                                        <div class="col-xs-5">{!! trans('messages.unit_name') !!}</div>
                                        <div class="col-xs-7 text-right">
                                            <a href="{!! url('units/'.$unitIDHashID->encode($objectiveObj->unit_id)) !!}">
                                                {{\App\Unit::getUnitName($objectiveObj->unit_id)}}
                                            </a>
                                        </div>
                                        <div class="col-xs-5">{!! trans('messages.type') !!}</div>
                                        <div class="col-xs-7 text-right">
                                            @if(!empty($objectiveObj->unit))
                                                {{\App\Unit::getCategoryNames($objectiveObj->unit->category_id)}}
                                            @else
                                                -
                                            @endif
                                        </div>
                                        <div class="col-xs-5">{!! trans('messages.funds') !!}</div>
                                        <div class="col-xs-7 text-right">Available xxxx $</div>
                                        <div class="col-xs-5">{!! trans('messages.awarded') !!}</div>
                                        <div class="col-xs-7 text-right">xxx $</div>
                                        <div class="col-xs-12 text-right">
                                            <button class="btn orange-bg btn-sm" id="add_unit_fund_btn">{!! trans('messages.add_funds') !!}</button>
                                        </div>
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
                    <h4>Tasks</h4>
                </div>
                <div class="panel-body table-inner table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Task Name</th>
                            <!--<th>Objective Name</th>-->
                            <th>Unit Name</th>
                            <th>Skills</th>
                            <th>Assigned to</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($objectiveObj->tasks) > 0 )
                            @foreach($objectiveObj->tasks as $task)
                                <tr>
                                    <td><a href="{!! url('tasks/'.$taskIDHashID->encode($task->id)) !!}">{{$task->name}}</a></td>
                                   <!-- <td>
                                        <a href="{!! url('objectives/'.$objectiveIDHashID->encode($task->objective_id)) !!}">
                                            {{\App\Objective::getObjectiveName($task->objective_id)}}
                                        </a>
                                    </td>-->
                                    <td>
                                        <a href="{!! url('units/'.$unitIDHashID->encode($task->unit_id)) !!}">
                                            {{\App\Unit::getUnitName($task->unit_id)}}
                                        </a>
                                    </td>
                                    <td>

                                    </td>
                                    <td></td>
                                    <td>{{ucfirst($task->status)}}</td>
                                    <td>
                                        <a class="btn btn-xs btn-primary"
                                           href="{!! url('tasks/'.$taskIDHashID->encode($task->id).'/edit') !!}" title="edit">
                                            <span class="glyphicon glyphicon-edit"></span>
                                        </a>
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
            <a href="{!! url('tasks/'.$unitIDHashID->encode($objectiveObj->unit_id).'/'.$objectiveIDHashID->encode($objectiveObj->id)
            .'/add')
            !!}"class="btn orange-bg" id="add_task_btn"
               type="button">
                <span class="glyphicon glyphicon-plus"></span> Add Task
            </a>
        </div>
    </div>
    <div class="row form-group">
        <div class="col-sm-6 col-xs-12">
            @include('elements.site_activities')
        </div>
    </div>
</div>
@include('elements.footer')
@endsection
@section('page-scripts')
<script>
    $(function(){
        $(".both-div").css("min-height",($(".objective-desc").height())+10+'px');

        $(".vote").click(function(){
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