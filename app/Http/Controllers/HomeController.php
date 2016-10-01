<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Issue;
use App\JobSkill;
use App\Objective;
use App\SiteActivity;
use App\Task;
use App\Unit;
use App\UnitCategory;
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
                $site_activity = SiteActivity::where('unit_id',$unit_id)->orderBy('id','desc')->paginate(\Config::get('app.site_activity_page_limit'));
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

    public function site_admin(Request $request){
        if(!Auth::check())
            return \Redirect::to(url(''));

        $categoriesObj =UnitCategory::paginate(\Config::get('app.site_activity_page_limit'));
        $jobSkillsObj = JobSkill::paginate(\Config::get('app.site_activity_page_limit'));

        $msg_flag = false;
        $msg_val = '';
        $msg_type = '';
        if($request->session()->has('msg_val')){
            $msg_val =  $request->session()->get('msg_val');
            $request->session()->forget('msg_val');
            $msg_flag = true;
            $msg_type = "success";
        }
        view()->share('msg_flag',$msg_flag);
        view()->share('msg_val',$msg_val);
        view()->share('msg_type',$msg_type);


        view()->share('jobSkillsObj',$jobSkillsObj);
        view()->share('categoriesObj',$categoriesObj);

        $site_activity = SiteActivity::orderBy('id','desc')->paginate(\Config::get('app.site_activity_page_limit'));
        view()->share('site_activity',$site_activity);
        view()->share('site_activity_text','Global Activity Log');

        return view('admin.site_admin');
    }

    public function get_skill_paginate(Request $request){
        if(!Auth::check())
            return \Response::json(['success'=>true,'html'=>'']);

        $page_limit = \Config::get('app.page_limit');
        $jobSkillObj = JobSkill::paginate($page_limit);
        view()->share('jobSkillObj',$jobSkillObj);
        $html = view('admin.partials.more_skills')->render();
        return \Response::json(['success'=>true,'html'=>$html]);
    }

    public function category_add(Request $request)
    {
        if(!Auth::check())
            return \Redirect::to(url(''));

        view()->share('categoryObj',[]);
        view()->share('parent_categories',UnitCategory::lists('name','id')->all());
        view()->share('method','category/add');
        if($request->isMethod('post')){
            $validator = \Validator::make($request->all(), [
                'name' => 'required',
                'status' => 'required'
            ]);

            if ($validator->fails())
                return redirect()->back()->withErrors($validator)->withInput();

            $categoryExist = UnitCategory::whereRaw('LOWER(name) = "'.strtolower($request->input('name').'"'))->count();

            if($categoryExist > 0)
                return redirect()->back()->withErrors(['name'=>'Name already exists.'])->withInput();

            $parent_id = $request->input('parent_id');
            if(empty($parent_id))
                $parent_id=null;
            $status = "pending";
            if(Auth::user()->role == "superadmin")
                $status =$request->input('status');

            UnitCategory::create([
                'name'=>$request->input('name'),
                'status'=>$status,
                'parent_id'=>$request->input('parent_id')
            ]);
            $request->session()->flash('msg_val', "Unit Category created successfully!!!");
            return redirect('site_admin');
        }
        $site_activity = SiteActivity::orderBy('id','desc')->paginate(\Config::get('app.site_activity_page_limit'));
        view()->share('site_activity',$site_activity);
        view()->share('site_activity_text','Global Activity Log');
        return view('admin.partials.add_category');
    }

    public function skill_add(Request $request){
        if(!Auth::check())
            return \Redirect::to(url(''));

        view()->share('skillObj',[]);
        view()->share('parent_skills',JobSkill::lists('skill_name','id')->all());
        view()->share('method','job_skills/add');
        if($request->isMethod('post')){
            $validator = \Validator::make($request->all(), [
                'skill_name' => 'required'
            ]);

            if ($validator->fails())
                return redirect()->back()->withErrors($validator)->withInput();

            $skillExist = JobSkill::whereRaw('LOWER(skill_name) = "'.strtolower($request->input('skill_name').'"'))->count();

            if($skillExist> 0)
                return redirect()->back()->withErrors(['skill_name'=>'Skill name already exists.'])->withInput();

            $parent_id = $request->input('parent_id');
            if(empty($parent_id))
                $parent_id=null;

            JobSkill::create([
                'skill_name'=>$request->input('skill_name'),
                'parent_id'=>$request->input('parent_id')
            ]);
            $request->session()->flash('msg_val', "Job skill created successfully!!!");
            return redirect('site_admin');
        }
        $site_activity = SiteActivity::orderBy('id','desc')->paginate(\Config::get('app.site_activity_page_limit'));
        view()->share('site_activity',$site_activity);
        view()->share('site_activity_text','Global Activity Log');
        return view('admin.partials.add_skill');
    }

    public function get_category_paginate(){
        if(!Auth::check())
            return \Response::json(['success'=>true,'html'=>'']);

        $page_limit = \Config::get('app.page_limit');
        $categoryObj = UnitCategory::paginate($page_limit);
        view()->share('categoryObj',$categoryObj);
        $html = view('admin.partials.more_categories')->render();
        return \Response::json(['success'=>true,'html'=>$html]);
    }

    public function category_view(Request $request,$category_id){
        if(!empty($category_id)){
            $unitCategoryIDHashID = new Hashids('unit category id hash',10,\Config::get('app.encode_chars'));
            $category_id = $unitCategoryIDHashID->decode($category_id);
            if(!empty($category_id)){
                $category_id= $category_id[0];
                $categoryObj = UnitCategory::find($category_id);
                if(!empty($categoryObj) && count($categoryObj) > 0){
                    view()->share('categoryObj',$categoryObj);
                    $site_activity = SiteActivity::orderBy('id','desc')->paginate(\Config::get('app.site_activity_page_limit'));
                    view()->share('site_activity',$site_activity);
                    view()->share('site_activity_text','Global Activity Log');
                    return view('admin.partials.category_view');
                }
            }
        }
        return view('errors.404');

    }
    public function skill_view(Request $request,$skill_id){
        if(!empty($skill_id)){
            $jobSkillIDHashID = new Hashids('job skills id hash',10,\Config::get('app.encode_chars'));
            $skill_id = $jobSkillIDHashID->decode($skill_id);
            if(!empty($skill_id)){
                $skill_id= $skill_id[0];
                $skillObj = JobSkill::find($skill_id);
                if(!empty($skillObj) && count($skillObj) > 0){
                    view()->share('skillObj',$skillObj);
                    $site_activity = SiteActivity::orderBy('id','desc')->paginate(\Config::get('app.site_activity_page_limit'));
                    view()->share('site_activity',$site_activity);
                    view()->share('site_activity_text','Global Activity Log');
                    return view('admin.partials.skill_view');
                }
            }
        }
        return view('errors.404');

    }

    public function category_edit(Request $request,$category_id){
        if(!empty($category_id)){
            $category_id_encoded = $category_id;
            $unitCategoryIDHashID = new Hashids('unit category id hash',10,\Config::get('app.encode_chars'));
            $category_id = $unitCategoryIDHashID->decode($category_id);
            if(!empty($category_id)){
                $category_id= $category_id[0];
                $categoryObj = UnitCategory::find($category_id);
                if(!empty($categoryObj) && count($categoryObj) > 0){
                    if($request->isMethod('post')){
                        $validator = \Validator::make($request->all(), [
                            'name' => 'required'
                        ]);

                        if ($validator->fails())
                            return redirect()->back()->withErrors($validator)->withInput();

                        
                        $categoryExist = UnitCategory::whereRaw('LOWER(name) = "'.strtolower($request->input('name').'" and id !="'.$category_id.'"'))
                                        ->count();


                        if($categoryExist > 0)
                            return redirect()->back()->withErrors(['name'=>'Name already exists.'])->withInput();

                        $category_name=$request->input('name');
                        $parent_id = $request->input('parent_id');

                        $status = "pending";
                        if(Auth::user()->role == "superadmin")
                            $status=$request->input('status');

                        if($categoryObj->name != $category_name || $categoryObj->parent_id != $parent_id || Auth::user()->role == "superadmin"){
                            if(empty($parent_id))
                                $parent_id=null;

                            $categoryObj->update([
                                'name'=>$request->input('name'),
                                'status'=>$status,
                                'parent_id'=>$request->input('parent_id')
                            ]);
                            $request->session()->flash('msg_val', "Unit category updated successfully!!!");
                            return redirect('site_admin');
                        }
                        $request->session()->flash('msg_val', "Nothing to update!!!");
                        return redirect('site_admin');



                    }
                    view()->share('categoryObj',$categoryObj);
                    $site_activity = SiteActivity::orderBy('id','desc')->paginate(\Config::get('app.site_activity_page_limit'));
                    view()->share('site_activity',$site_activity);
                    view()->share('site_activity_text','Global Activity Log');
                    view()->share('parent_categories',UnitCategory::where('id','!=',$category_id)->lists('name','id')->all());
                    view()->share('method','category/'.$category_id_encoded .'/edit');
                    return view('admin.partials.add_category');
                }
            }
        }
        return view('errors.404');
    }

    public function skill_edit(Request $request,$skill_id){
        if(!empty($skill_id)){
            $skill_id_encoded = $skill_id;
            $jobSkillIDHashID = new Hashids('job skills id hash',10,\Config::get('app.encode_chars'));
            $skill_id = $jobSkillIDHashID->decode($skill_id);
            if(!empty($skill_id)){
                $skill_id= $skill_id[0];
                $skillObj = JobSkill::find($skill_id);
                if(!empty($skillObj) && count($skillObj) > 0){
                    if($request->isMethod('post')){
                        $validator = \Validator::make($request->all(), [
                            'skill_name' => 'required'
                        ]);

                        if ($validator->fails())
                            return redirect()->back()->withErrors($validator)->withInput();

                        $skillExist = JobSkill::whereRaw('LOWER(skill_name) = "'.strtolower($request->input('skill_name').'" and id != "'
                                .$skill_id.'"'))->count();

                        if($skillExist> 0)
                            return redirect()->back()->withErrors(['skill_name'=>'Skill name already exists.'])->withInput();

                        $parent_id = $request->input('parent_id');
                        if(empty($parent_id))
                            $parent_id=null;

                        $skillObj->update([
                            'skill_name'=>$request->input('skill_name'),
                            'parent_id'=>$request->input('parent_id')
                        ]);
                        $request->session()->flash('msg_val', "Job skill updated successfully!!!");
                        return redirect('site_admin');
                    }
                    view()->share('skillObj',$skillObj);
                    $site_activity = SiteActivity::orderBy('id','desc')->paginate(\Config::get('app.site_activity_page_limit'));
                    view()->share('site_activity',$site_activity);
                    view()->share('site_activity_text','Global Activity Log');
                    view()->share('method','job_skills/'.$skill_id_encoded .'/edit');
                    view()->share('parent_skills',JobSkill::where('id','!=',$skill_id)->lists('skill_name','id')->all());
                    return view('admin.partials.add_skill');
                }
            }
        }
        return view('errors.404');
    }
}
