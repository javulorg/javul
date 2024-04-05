<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Models\Fund;
use App\Models\Notification;
use App\Models\Task;
use App\Models\TaskBidder;
use App\Models\Unit;
use App\Traits\UnitTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    use UnitTrait;
    public function taskAcceptOfferView($taskId)
    {
        $task = Task::where('id', $taskId)->first();
        if(!$task){
            abort(404);
        }
        $unitData = Unit::where('id', $task->unit_id)->first();
        $availableFunds = Fund::getUnitDonatedFund($task->unit_id);
        $awardedFunds = Fund::getUnitAwardedFund($task->unit_id);
        $issueResolutions = $this->calculateIssueResolution($task->unit_id);

        view()->share('availableFunds',$availableFunds);
        view()->share('awardedFunds',$awardedFunds);
        view()->share('unitData',$unitData);
        view()->share('unitObj',$unitData);
        view()->share('taskObj',$task);
        view()->share('totalIssueResolutions',$issueResolutions);

        $taskBidderObj = TaskBidder::where('task_id', $taskId)
            ->where('user_id',Auth::user()->id)
            ->whereIn('status',['offer_sent','re_assigned'])
            ->first();
        view()->share('taskBidderObj',$taskBidderObj);
        return view('tasks.accept-offer');
    }
}
