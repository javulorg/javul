<?php

namespace App\Http\Controllers;

use App\Models\ActivityPoint;
use App\Models\AreaOfInterest;
use App\Models\Fund;
use App\Models\JobSkill;
use App\Models\Objective;
use App\Models\SiteActivity;
use App\Models\Task;
use App\Models\TaskBidder;
use App\Models\TaskRatings;
use App\Models\Unit;
use Carbon\Carbon;
use Hashids\Hashids;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use App\Models\UserWiki;
use App\Models\Wiki;
use App\Models\ZcashWithdrawRequest;
use Illuminate\Support\Facades\Auth;
use DateTime;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',['except'=>['user_profile']]);
    }

    public function date_calculateToNow($date)
    {
        $created_date = new DateTime($date);
        $now_date = $created_date->diff(new DateTime());

        if($now_date->y == 0 && $now_date->m == 0 && $now_date->d == 0 && $now_date->h == 0 && $now_date->i == 0)
            return $now_date->s .' seconds ';
        elseif ($now_date->y == 0 && $now_date->m == 0 && $now_date->d == 0 && $now_date->h == 0)
            return $now_date->i .' min '. $now_date->s .' seconds';
        elseif ($now_date->y == 0 && $now_date->m == 0 && $now_date->d == 0)
            if($now_date->d == 0){
                return $now_date->h .' hours '. $now_date->i .' min';
            }else{
                return $now_date->d .' days '. $now_date->h .' hours';
            }
        elseif ($now_date->y == 0 && $now_date->m == 0)
            if($now_date->h == 0){
                return $now_date->m .' months '. $now_date->i .' min';
            }else{
                return  $now_date->d .' days '. $now_date->h .' hours';
            }
        elseif ($now_date->y == 0 )
            if($now_date->d == 0){
                return-$now_date->m .' months '. $now_date->h .' hours';
            }else{
                return $now_date->m .' months '. $now_date->d .' days';
            }
        elseif ($now_date->y != 0 )
            if($now_date->m == 0){
                return  $now_date->y .' year '. $now_date->d .' days';
            }else{
                return  $now_date->y .' year '. $now_date->m .' months';
            }

    }

    public function user_profile(Request $request,$user_id,$slug=null)
    {
        view()->share('user_id_hash',$user_id);
        if(!empty($user_id))
        {
            $userIDHashID= new Hashids('user id hash',10,Config::get('app.encode_chars'));
            $user_id = $userIDHashID->decode($user_id);
            if(!empty($user_id))
            {
                $user_id = $user_id [0];
                $userObj = User::find($user_id);
                $unitsObj = Unit::with(['objectives','tasks'])
                    ->where('units.user_id',$user_id)
                    ->get();


                $objectivesObj = Objective::where('user_id',$user_id)->get();
                $tasksObj = Task::where('user_id',$user_id)->get();

                $activityPoints = ActivityPoint::where('user_id',$user_id)->sum('points');

                $skills = [];
                if(!empty($userObj->job_skills))
                    $skills = JobSkill::whereIn('id',explode(",",$userObj->job_skills))->get();

                $interestObj = [];
                if(!empty($userObj->job_skills))
                    $interestObj = AreaOfInterest::whereIn('id',explode(",",$userObj->area_of_interest))->get();

                $userWiki = UserWiki::select(['page_content','id'])
                                    ->where("user_id","=",$user_id)
                                    ->where("page_type","=","2")
                                    ->get();
                if( $userWiki->count() == 0)
                {

                    $wikipage =  new UserWiki;
                    $wikipage->page_content = 'Welcome to the User wiki home page';
                    $wikipage->page_title = 'Home Page';
                    $wikipage->comment = '';
                    $wikipage->private = 1;
                    $wikipage->page_type = 2;
                    $wikipage->slug = 'home-page';
                    $wikipage->user_id = $user_id;
                    $wikipage->save();

                    $userWiki[0] = $wikipage;
                }

                $userPageIDHashID= new Hashids('userpage id hash',10,Config::get('app.encode_chars'));
                $page_id = $userPageIDHashID->encode($userWiki[0]->id);
                $activityPoints_forum = ActivityPoint::where('user_id',$user_id)->where('type','forum')->sum('points');
                view()->share('activityPoints_forum',$activityPoints_forum);

                $userWiki[0]->page_content = Wiki::parse($userWiki[0]->page_content);

                $rating_points = TaskRatings::where('user_id',$user_id)->sum('quality_of_work');
                $total_rating_points = TaskRatings::where('user_id',$user_id)->count();
                if(is_null($rating_points))
                    $rating_points = 0;
                else if($rating_points > 0)
                {
                    $rating_points = $rating_points / $total_rating_points;
                    if(is_float($rating_points))
                        $rating_points = round($rating_points,1);
                }


                /**
                 * Account age.
                 */
                 $userObj->age = $this->date_calculateToNow($userObj->created_at);



                view()->share('rating_points',$rating_points);
                view()->share("page_id_hase",$page_id);

                view()->share('userWiki',$userWiki);
                view()->share('objectivesObj',$objectivesObj);
                view()->share('tasksObj',$tasksObj);
                view()->share('interestObj',$interestObj);
                view()->share('skills',$skills);
                view()->share('activityPoints',$activityPoints);
                view()->share('userObj',$userObj);
                view()->share('unitsObj',$unitsObj);


                $mostActiveUnits = SiteActivity::select('unit_id', DB::raw('COUNT(*) as occurrence'))
                    ->with('unit')
                    ->where('created_at', '>=', Carbon::now()->subMonths(6))
                    ->where('user_id', $user_id)
                    ->groupBy('unit_id')
                    ->orderBy('occurrence', 'desc')
                    ->take(5)
                    ->get();

//                $mostActiveUnits = SiteActivity::select('site_activities.unit_id', DB::raw('SUM(activity_points.points) as total_points'))
//                    ->leftJoin('activity_points', function($join) {
//                        $join->on('site_activities.user_id', '=', 'activity_points.user_id')
//                            ->on('site_activities.unit_id', '=', 'activity_points.unit_id');
//                    })
//                    ->where('site_activities.created_at', '>=', Carbon::now()->subMonths(6))
//                    ->where('site_activities.user_id', $user_id)
//                    ->groupBy('site_activities.unit_id')
//                    ->orderBy('total_points', 'desc')
//                    ->take(5)
//                    ->get();

//                dd($mostActiveUnits->toArray());





                $mostTopObjectives = ActivityPoint::with('objective')
                    ->where('created_at', '>=', Carbon::now()->subMonths(6))
                    ->where('user_id', $user_id)
                    ->where('comments', 'Objective Created')
                    ->latest()
                    ->groupBy('objective_id')
                    ->take(5)
                    ->get();

                $mostTopTasks = ActivityPoint::with('task')
                    ->where('created_at', '>=', Carbon::now()->subMonths(6))
                    ->where('user_id', $user_id)
                    ->where('comments', 'Task Created')
                    ->latest()
                    ->groupBy('task_id')
                    ->take(5)
                    ->get();

                $mostTopIssues = ActivityPoint::with('issue')
                    ->where('created_at', '>=', Carbon::now()->subMonths(6))
                    ->where('user_id', $user_id)
                    ->where('comments', 'Issue Created')
                    ->latest()
                    ->groupBy('issue_id')
                    ->take(5)
                    ->get();

                $mostTopIdeas = ActivityPoint::with('idea')
                    ->where('created_at', '>=', Carbon::now()->subMonths(6))
                    ->where('user_id', $user_id)
                    ->where('comments', 'Idea Created')
                    ->latest()
                    ->groupBy('idea_id')
                    ->take(5)
                    ->get();

                $totalObjectivesCreated =  ActivityPoint::query()
                    ->where('created_at', '>=', Carbon::now()->subMonths(6))
                    ->where('user_id', $user_id)
                    ->where('comments', 'Objective Created')
                    ->count();

                $totalTasksCreated =  ActivityPoint::query()
                    ->where('created_at', '>=', Carbon::now()->subMonths(6))
                    ->where('user_id', $user_id)
                    ->where('comments', 'Task Created')
                    ->count();

                $totalTasksEdited =  ActivityPoint::query()
                    ->where('created_at', '>=', Carbon::now()->subMonths(6))
                    ->where('user_id', $user_id)
                    ->where('comments', 'Task Updated')
                    ->count();

                $totalCompletedTasks=  Task::query()
                    ->where('created_at', '>=', Carbon::now()->subMonths(6))
                    ->where('user_id', $user_id)
                    ->where('status', 'completed')
                    ->count();

                $totalObjectivesEdited =  ActivityPoint::query()
                    ->where('created_at', '>=', Carbon::now()->subMonths(6))
                    ->where('user_id', $user_id)
                    ->where('comments', 'Objective updated')
                    ->count();

                $totalIdeasCreated =  ActivityPoint::query()
                    ->where('created_at', '>=', Carbon::now()->subMonths(6))
                    ->where('user_id', $user_id)
                    ->where('comments', 'Idea Created')
                    ->count();

                $totalIdeasUpdated =  ActivityPoint::query()
                    ->where('created_at', '>=', Carbon::now()->subMonths(6))
                    ->where('user_id', $user_id)
                    ->where('comments', 'Idea Updated')
                    ->count();

                view()->share('mostActiveUnits',$mostActiveUnits);
                view()->share('mostTopObjectives',$mostTopObjectives);
                view()->share('mostTopTasks',$mostTopTasks);
                view()->share('mostTopIssues',$mostTopIssues);
                view()->share('mostTopIdeas',$mostTopIdeas);
                view()->share('totalObjectivesCreated',$totalObjectivesCreated);
                view()->share('totalObjectivesEdited',$totalObjectivesEdited);
                view()->share('totalTasksCreated',$totalTasksCreated);
                view()->share('totalTasksEdited',$totalTasksEdited);
                view()->share('totalCompletedTasks',$totalCompletedTasks);
                view()->share('totalIdeasCreated',$totalIdeasCreated);
                view()->share('totalIdeasUpdated',$totalIdeasUpdated);

                return view('users.profile');
            }
        }
        return view('errors.404');
    }

    public function my_contribution()
    {

        $site_activities = SiteActivity::where('user_id',Auth::user()->id)->orderBy('id','desc')->paginate(Config::get('app.global_site_activity_page'));
        view()->share('site_activities',$site_activities );

        return view('users.my_contributions');
    }

    public function my_tasks(Request $request)
    {
        $myBids = TaskBidder::join('tasks','task_bidders.task_id','=','tasks.id')
            ->where('task_bidders.user_id', Auth::user()->id)
            ->whereNull('task_bidders.status')
            ->select(['tasks.name','tasks.id as task_id','tasks.slug','tasks.status as task_status', 'task_bidders.*'])
            ->get();
        $myAssignedTask = Task::where('status','in_progress')->where('assign_to',Auth::user()->id)->get();

        $assignedTasks = Task::query()
            ->where('assign_to',Auth::user()->id)
            ->get();
        view()->share('assignedTasks',$assignedTasks);

        $inProgressTasks = Task::query()
            ->where('assign_to',Auth::user()->id)
            ->where('status','in_progress')
            ->get();

        $completedTasks = Task::query()
            ->where('assign_to',Auth::user()->id)
            ->where('status','completed')
            ->get();

        view()->share('inProgressTasks',$inProgressTasks);
        view()->share('myBids',$myBids);
        view()->share('completedTasks',$completedTasks);


        $myEvaluationTask =[];
        $myCancelledTask = [];
        $zcashTransferList = [];

        if(Auth::user()->role == 1)
        {
            $myEvaluationTask = Task::join('task_complete','tasks.id','=','task_complete.task_id')
                ->join('users','task_complete.user_id','=','users.id')
                ->selectRaw('max(tasks.name),max(slug),max(tasks.status),
                    max(users.first_name),max(users.last_name),max(users.id) as user_id,
                    max(tasks.id) as task_id,max(task_complete.attachments),max(task_complete.comments)')
                ->where('tasks.status','completion_evaluation')
                ->groupBy('task_complete.task_id')
                ->get();

            $myCancelledTask = Task::join('task_cancel','tasks.id','=','task_cancel.task_id')
                ->join('users','task_cancel.user_id','=','users.id')
                ->selectRaw('max(tasks.name),max(slug),max(tasks.status),max(users.first_name),max(users.last_name),max(users.id) as user_id,
                    max(tasks.id) as task_id,max(task_cancel.comments)')
                ->where('tasks.status','cancelled')
                ->groupBy('task_cancel.task_id')
                ->get();

            $zcashTransferList = ZcashWithdrawRequest::join('users','users.id','=','zcash_withdraw_request.user_id')
            ->select('users.first_name','users.last_name','users.id as user_id','zcash_withdraw_request.*')
            ->where('zcash_withdraw_request.status','withdrawal')
            ->get();
        }



        $unitData = Unit::where('id', $request->unit)->first();
        $availableFunds = Fund::getUnitDonatedFund($request->unit);
        $awardedFunds = Fund::getUnitAwardedFund($request->unit);

        view()->share('availableFunds',$availableFunds );
        view()->share('awardedFunds',$awardedFunds );
        view()->share('unitData',$unitData);
        view()->share('unitObj',$unitData);

        $site_activity = SiteActivity::orderBy('id','desc')->paginate(Config::get('app.site_activity_page_limit'));
        view()->share('site_activity',$site_activity);
        view()->share('site_activity_text','Global Activity Log');

        view()->share('myCancelledTask',$myCancelledTask);
        view()->share('myEvaluationTask',$myEvaluationTask);
        view()->share('myBids',$myBids);
        view()->share('myAssignedTask',$myAssignedTask);
        view()->share('zcashTransferList',$zcashTransferList);

        return view('users.my_tasks');
    }
}
