<?php $unitSlug = \App\Unit::getSlug($task->unit_id);
$objectiveSlug = \App\Objective::getSlug($task->objective_id);?>
<tr>
    <td><a href="{!! url('tasks/'.$taskIDHashID->encode($task->id).'/'.$task->slug)!!}">{{$task->name}}</a></td>
    <td>
        <a href="{!! url('objectives/'.$objectiveIDHashID->encode($task->objective_id).'/'.$objectiveSlug)!!}">
            {{\App\Objective::getObjectiveName($task->objective_id)}}
        </a>
    </td>
    <td>
        <a href="{!! url('units/'.$unitIDHashID->encode($task->unit_id).'/'.$unitSlug) !!}">
            {{\App\Unit::getUnitName($task->unit_id)}}
        </a>
    </td>
    <td>
        {!! \App\JobSkill::getSkillNameLink($task->skills) !!}
    </td>
    <td>
        @if(empty($task->assign_to))
            -
        @else
            <a href="{!! url('userprofiles/'.$userIDHashID->encode($task->assign_to).'/'.strtolower(\App\User::getUserName($task->assign_to))) !!}">
                {{\App\User::getUserName($task->assign_to)}}
            </a>
        @endif
    </td>
    <td>{{\App\SiteConfigs::task_status($task->status)}}</td>
    <td width="11%">
        @if($task->status == "approval")
            @if(\App\TaskBidder::checkBid($task->id))
                <a title="bid now" href="{!! url('tasks/bid_now/'.$taskIDHashID->encode($task->id)) !!}" class="btn btn-xs btn-primary">
                    <!--<span><img src="{!! url('assets/images/bid_small.png') !!}"/></span>-->
                    Bid now
                </a>
            @else
                <a title="applied bid" class="btn btn-xs btn-warning">
                    Applied Bid
                </a>
            @endif
        @else
            -
        @endif
    </td>
</tr>