<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Issue;
use App\Objective;
use App\SiteActivity;
use App\Task;
use App\Unit;
use App\User;
use App\Watchlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Hashids\Hashids;
use Illuminate\Support\Facades\Config;
use PayPal\Service\AdaptivePaymentsService;
use PayPal\Types\AP\PaymentDetailsRequest;
use PayPal\Types\AP\PayRequest;
use PayPal\Types\AP\Receiver;
use PayPal\Types\AP\ReceiverList;
use PayPal\Types\Common\RequestEnvelope;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth',['except'=>['index','add_to_watchlist','get_unit_site_activity_paginate','get_site_activity_paginate']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recentUnits = Unit::take(5)->orderBy('created_at','desc')->get();
        $recentObjectives = Objective::take(5)->orderBy('created_at','desc')->get();
        $recentTasks= Task::take(5)->orderBy('created_at','desc')->get();
        $recentUsers= User::take(5)->orderBy('created_at','desc')->get();

        view()->share('recentUnits',$recentUnits);
        view()->share('recentObjectives',$recentObjectives);
        view()->share('recentTasks',$recentTasks);
        view()->share('recentUsers',$recentUsers);
        view()->share('site_activity_text','Global Activity Log');

        $site_activity = SiteActivity::orderBy('created_at','desc')->paginate(\Config::get('app.site_activity_page_limit'));
        view()->share('site_activity',$site_activity);

        return view('home');
    }

    public function global_activities(){
        $activities = SiteActivity::orderBy('id','desc')->paginate(\Config::get('app.global_site_activity_page'));
        view()->share('site_activity',$activities);
        view()->share('site_activity_text','Global Activity Log');
        return view('global_activities');
    }

    public function get_unit_site_activity_paginate(Request $request){
        $unit_id = $request->input('unit_id');

        if(!empty($unit_id)){
            $unitIDHashID = new Hashids('unit id hash',10,\Config::get('app.encode_chars'));
            $unit_id = $unitIDHashID->decode($unit_id);
            if(!empty($unit_id)){
                $unit_id = $unit_id[0];
                $site_activity = SiteActivity::where('unit_id',$unit_id)->whereNull('issue_id')->orderBy('id','desc')
                    ->paginate(\Config::get('app.site_activity_page_limit'));
                view()->share('site_activity',$site_activity);
                view()->share('site_activity_text','Unit Activity Log');
                view()->share('unit_activity_id',$unit_id);
                view()->share('ajax',true);
                $html = view('elements.site_activities')->render();
                return \Response::json(['success'=>true,'html'=>$html]);

            }
        }
        return \Response::json(['success'=>false]);
    }

    public function get_site_activity_paginate(Request $request){
        $page_limit = \Config::get('app.site_activity_page_limit');
        if($request->has('from_page')){
            $page = $request->input('from_page');
            if($page == "global_activity")
                $page_limit = \Config::get('app.global_site_activity_page');
        }
        $site_activity = SiteActivity::orderBy('id','desc')->paginate($page_limit);
        view()->share('site_activity',$site_activity);
        view()->share('site_activity_text','Global Activity Log');
        view()->share('ajax',true);
        $html = view('elements.site_activities')->render();
        return \Response::json(['success'=>true,'html'=>$html]);
    }

    public function add_to_watchlist(Request $request){
        if($request->method('ajax')){
            if(Auth::check()){
                $type = $request->input('type');
                $id = $request->input('id');

                $hashID = '';
                $obj = [];
                switch($type){
                    case 'unit':
                        $hashID = new Hashids('unit id hash',10,\Config::get('app.encode_chars'));
                        $id = $hashID->decode($id);
                        if(!empty($id)) {
                            $id = $id[0];
                            $obj = Unit::find($id);
                        }
                        break;
                    case 'objective':
                        $hashID = new Hashids('objective id hash',10,\Config::get('app.encode_chars'));
                        $id = $hashID->decode($id);
                        if(!empty($id)) {
                            $id = $id[0];
                            $obj = Objective::find($id);
                        }
                        break;
                    case 'task':
                        $hashID = new Hashids('task id hash',10,\Config::get('app.encode_chars'));
                        $id = $hashID->decode($id);
                        if(!empty($id)) {
                            $id = $id[0];
                            $obj = Task::find($id);
                        }
                        break;
                    case 'issue':
                        $hashID = new Hashids('issue id hash',10,\Config::get('app.encode_chars'));
                        $id = $hashID->decode($id);
                        if(!empty($id)) {
                            $id = $id[0];
                            $obj = Issue::find($id);
                        }
                        break;
                }
                if(!empty($obj)){
                    $exist = Watchlist::where(strtolower($type).'_id',$id)->get();
                    if(empty($exist) || count($exist) == 0 ){
                        Watchlist::create([
                            'user_id'=>Auth::user()->id,
                            strtolower($type).'_id'=>$id
                        ]);
                        return \Response::json(['success'=>true,'msg'=>ucfirst($type).' added to watchlist.']);
                    }
                    else
                        return \Response::json(['success'=>false,'msg'=>ucfirst($type).' already added to watchlist.']);

                }
                return \Response::json(['success'=>false,'msg'=>ucfirst($type).' not found in database.']);
            }
            return \Response::json(['success'=>false,'msg'=>'Please login to continue.']);

        }
        return view('errors.404');

    }

    public function my_watchlist(Request $request){
        $watchedUnits = Watchlist::join('units','my_watchlist.unit_id','=','units.id')
                        ->where('my_watchlist.user_id',Auth::user()->id)
                        ->whereNotNull('unit_id')->select(['units.*'])->get();
        $watchedObjectives = Watchlist::join('objectives','my_watchlist.objective_id','=','objectives.id')
                            ->where('my_watchlist.user_id',Auth::user()->id)
                            ->whereNotNull('objective_id')->select(['objectives.*'])->get();
        $watchedTasks = Watchlist::join('tasks','my_watchlist.task_id','=','tasks.id')
                        ->where('my_watchlist.user_id',Auth::user()->id)
                        ->whereNotNull('task_id')->select(['tasks.*'])->get();
        //$watchedIssues = Watchlist::with(['issues'])->where('user_id',Auth::user()->id)->whereNotNull('issue_id')//->get();

        view()->share('watchedUnits',$watchedUnits);
        view()->share('watchedObjectives',$watchedObjectives);
        view()->share('watchedTasks',$watchedTasks);
        //view()->share('watchedIssues',$watchedIssues);
        return view('users.my_watchlist');
    }
    public function paypal(Request $request){

    }
}
