<?php

namespace App\Http\Controllers;

use App\ActivityPoint;
use App\AreaOfInterest;
use App\JobSkill;
use App\Objective;
use App\SiteActivity;
use App\Task;
use App\Unit;
use Hashids\Hashids;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware('auth',['except'=>['index']]);
    }

    public function user_profile(Request $request,$user_id)
    {
        if(!empty($user_id)){
            $userIDHashID= new Hashids('user id hash',10,\Config::get('app.encode_chars'));
            $user_id = $userIDHashID->decode($user_id);
            if(!empty($user_id)){
                $user_id = $user_id [0];
                $userObj = User::find($user_id);
                $unitsObj = Unit::with(['objectives','tasks'])->where('units.user_id',$user_id)->get();
                $tasksObj = Objective::where('user_id',$user_id)->get();
                $objectivesObj = Task::where('user_id',$user_id)->get();

                $activityPoints = ActivityPoint::where('user_id',$user_id)->sum('points');
                $site_activities = SiteActivity::where('user_id',$user_id)->take(10)->orderBy('created_at','desc')->get();

                $skills = [];
                if(!empty($userObj->job_skills))
                    $skills = JobSkill::whereIn('id',explode(",",$userObj->job_skills))->get();

                $interestObj = [];
                if(!empty($userObj->job_skills))
                    $interestObj = AreaOfInterest::whereIn('id',explode(",",$userObj->area_of_interest))->get();

                view()->share('objectivesObj',$objectivesObj);
                view()->share('tasksObj',$tasksObj);
                view()->share('interestObj',$interestObj);
                view()->share('skills',$skills);
                view()->share('site_activities',$site_activities );
                view()->share('activityPoints',$activityPoints);
                view()->share('userObj',$userObj);
                view()->share('unitsObj',$unitsObj);

                return view('users.profile');
            }
        }
        return view('errors.404');
    }
}
