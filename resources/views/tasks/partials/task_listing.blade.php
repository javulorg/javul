<?php $unitSlug = \App\Models\Unit::getSlug($task->unit_id);
$objectiveSlug = \App\Models\Objective::getSlug($task->objective_id);?>
<tr>
    <td><a href="{!! url('tasks/'.$taskIDHashID->encode($task->id).'/'.$task->slug)!!}">{{$task->name}}</a></td>
    <td>
        <a href="{!! url('objectives/'.$objectiveIDHashID->encode($task->objective_id).'/'.$objectiveSlug)!!}">
            {{\App\Models\Objective::getObjectiveName($task->objective_id)}}
        </a>
    </td>
    <td>
        <a href="{!! url('units/'.$unitIDHashID->encode($task->unit_id).'/'.$unitSlug) !!}">
            {{\App\Models\Unit::getUnitName($task->unit_id)}}
        </a>
    </td>
    <td>
        {!! \App\Models\JobSkill::getSkillNameLink($task->skills) !!}
    </td>
    <td>
        @if(empty($task->assign_to))
            -
        @else
            <a href="{!! url('userprofiles/'.$userIDHashID->encode($task->assign_to).'/'.strtolower(\App\Models\User::getUserName($task->assign_to))) !!}">
                {{\App\Models\User::getUserName($task->assign_to)}}
            </a>
        @endif
    </td>
    <td>{{\App\Models\SiteConfigs::task_status($task->status)}}</td>
    <td width="11%">
        @if(\App\Models\Task::isUnitAdminOfTask($task->id))
            <a title="Change Task Status" href="{!! url('tasks/'.$taskIDHashID->encode($task->id)).'/edit/change_status' !!}" class="btn btn-xs btn-primary">
                Change Status
            </a>
        @endif
        @if($task->status == "approval" || $task->status == "open_for_bidding")
           <!-- User cannot bid on their task -->
            @if(isset($authUserObj->id) && $authUserObj->id != $task->user_id)
                @if(\App\Models\TaskBidder::checkBid($task->id))
                    <a title="bid now" href="{!! url('tasks/bid_now/'.$taskIDHashID->encode($task->id)).'#bid_now' !!}" class="btn btn-xs btn-primary">
                        <!--<span><img src="{!! url('assets/images/bid_small.png') !!}"/></span>-->
                        Bid now
                    </a>
                @else
                    <a title="applied bid" class="btn btn-xs btn-warning">
                        Applied Bid
                    </a>
                @endif
            @elseif(!\App\Models\Task::isUnitAdminOfTask($task->id))
                -
            @endif
        @elseif(!\App\Models\Task::isUnitAdminOfTask($task->id))
            -
        @endif
    </td>
</tr>
