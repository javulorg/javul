<?php

namespace App\Http\Controllers;

use App\AreaOfInterest;
use App\Http\Requests;
use App\Issue;
use App\JobSkill;
use App\JobSkillHistory;
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

        $where = '';
        if(Auth::user()->role != "superadmin")
            $where=" AND user_id=".Auth::user()->id;

        $categoriesObj =UnitCategory::paginate(\Config::get('app.site_activity_page_limit'));
        $jobSkillsObj = \DB::select('SELECT c.id, IF(ISNULL(c.parent_id), 0, c.parent_id) AS parent_id,c.skill_name,   p.skill_name AS Parentskill_name,IF(ISNULL(job_skills_history.`skill_name`),NULL,job_skills_history.`skill_name`) AS history_skill_name
                                    ,IF(ISNULL(job_skills_history.`prefix_id`),NULL,job_skills_history.`prefix_id`) AS prefix_id,IF(ISNULL(job_skills_history.`user_id`),NULL,job_skills_history.`user_id`) AS user_id
                                    FROM job_skills c LEFT JOIN job_skills p ON (c.parent_id = p.id) LEFT JOIN job_skills_history ON
                                    c.id=job_skills_history.`job_skill_id`'.$where.' WHERE IF(c.parent_id IS NULL, 0, c
                                    .parent_id) = 0 AND c.id <> 0 ORDER BY  c.id');

        $firstBox_skills = [];
        $need_approve_skills = [];
        if(count($jobSkillsObj) > 0 && !empty($jobSkillsObj)){
            foreach($jobSkillsObj as $skill){
                if(!empty($skill->history_skill_name) && $skill->user_id == Auth::user()->id)
                    $firstBox_skills[$skill->prefix_id]=['type'=>'old','name'=>$skill->history_skill_name];
                else
                    $firstBox_skills[$skill->id]=['type'=>'old','name'=>$skill->skill_name];
            }
        }

        // also list the skill he added but yet not approved by siteadmin.
        if(Auth::user()->role != "superadmin") {
            $pending_skills = JobSkillHistory::where('user_id', Auth::user()->id)->where('parent_id',0)->lists('skill_name','prefix_id')
                ->all();
            if(count($pending_skills) > 0){
                foreach($pending_skills as $index=>$skl_nm)
                    $firstBox_skills[$index]=['type'=>'new','name'=>$skl_nm];
            }
        }
        else
            $need_approve_skills = JobSkillHistory::orderBy('action_type')->get();


        $need_approve_skills =[];
        view()->share('need_approve_skills',$need_approve_skills);
        view()->share('firstBox_skills',$firstBox_skills);
        $area_of_interestObj = AreaOfInterest::paginate(\Config::get('app.site_activity_page_limit'));

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
        view()->share('area_of_interestObj',$area_of_interestObj);

        $site_activity = SiteActivity::orderBy('id','desc')->paginate(\Config::get('app.site_activity_page_limit'));
        view()->share('site_activity',$site_activity);
        view()->share('site_activity_text','Global Activity Log');

        return view('admin.site_admin');
    }

    public function get_area_of_interest_paginate(Request $request){
        if(!Auth::check())
            return \Response::json(['success'=>true,'html'=>'']);

        $page_limit = \Config::get('app.page_limit');
        $areaOfInterestObj = AreaOfInterest::paginate($page_limit);
        view()->share('areaOfInterestObj',$areaOfInterestObj);
        $html = view('admin.partials.more_area_of_interest')->render();
        return \Response::json(['success'=>true,'html'=>$html]);
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
        if(!Auth::check() || !$request->ajax())
            return \Response::json(['success'=>false,'errors'=>['You are not authorized person to perform this action.']]);

        $validator = \Validator::make($request->all(), [
            'skill_name' => 'required'
        ]);

        if ($validator->fails())
            return \Response::json(['success'=>false,'errors'=>$validator->messages()]);

        $skillExist = JobSkill::whereRaw('LOWER(skill_name) = "'.strtolower($request->input('skill_name').'"'))->count();

        if($skillExist> 0)
            return \Response::json(['success'=>false,'errors'=>['skill_name'=>'Skill name already exists']]);

        $parent_id = $request->input('parent_id');

        if(empty($parent_id))
            $parent_id=0;
        else
            $parent_id = str_replace("JBSH","",$parent_id);

        $data  = [
            'skill_name'=>$request->input('skill_name'),
            'parent_id'=>$parent_id
        ];

        $userIDHashID= new Hashids('user id hash',10,\Config::get('app.encode_chars'));
        $user_id = $userIDHashID->encode(Auth::user()->id);

        $skill_id = '';

        $path_text = $request->input('path_text');
        $html = '<a href="'.url('userprofiles/'.$user_id.'/'.strtolower(Auth::user()->first_name.'_'.Auth::user()->last_name)).'">'
            .Auth::user()->first_name.' '.Auth::user()->last_name.'</a> added skill <a href="'.url('site_admin').'">'
            .$data['skill_name'].'</a>';
        if(!empty($path_text)){
            $html.=' to the <a href="'.url('site_admin').'">'.$path_text.'</a>';
        }


        if(Auth::user()->role =="superadmin") {
            $data['status'] = "approved";
            $skill_id =JobSkill::create($data)->id;
        }
        else{
            $type = $request->input('tbl_type');
            if($type == "null")
                $type =null;
            $data['user_id']=Auth::user()->id;
            $data['skill_name']=$request->input('skill_name');
            $data['action_type']='add';
            $data['parent_id_belongs_to'] =$type;
            $skill_id = JobSkillHistory::create($data)->id;
        }
        SiteActivity::create([
            'user_id'=>Auth::user()->id,
            'comment'=>$html
        ]);
        return \Response::json(['success'=>true,'skill_id'=>$skill_id,'skill_name'=>$data['skill_name']]);
        /*view()->share('skillObj',[]);
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
        return view('admin.partials.add_skill');*/
    }
    public function skill_edit(Request $request)
    {

        if (!Auth::check() || !$request->ajax())
            return \Response::json(['success' => false, 'errors' => ['You are not authorized person to perform this action.']]);

        $validator = \Validator::make($request->all(), [
            'skill_name' => 'required'
        ]);

        if ($validator->fails())
            return \Response::json(['success' => false, 'errors' => $validator->messages()]);

        $selected_id = $request->input('selected_id');
        if (empty($selected_id))
            return \Response::json(['success' => false, 'errors' => ['Something goes wrong please try again later.']]);

        $skill_name = $request->input('skill_name');
        $skillExist = JobSkill::whereRaw('LOWER(skill_name) = "'.$skill_name.'"')->count();

        if ($skillExist > 0)
            return \Response::json(['success' => false, 'errors' => ['skill_name' => 'Skill name already exists']]);

        $type = $request->input('tbl_type');
        $userIDHashID= new Hashids('user id hash',10,\Config::get('app.encode_chars'));
        $user_id = $userIDHashID->encode(Auth::user()->id);
        if(Auth::user()->role == "superadmin") {
            $data['status'] = "approved";
            //$jobSkillObj->update($data);
        }
        else {
            if ($type == "old") {
                $job_skill_id= $selected_id;
                if(strpos($selected_id,"JBSH") !== false) {
                    $job_skill_id = JobSkillHistory::where('prefix_id', $selected_id)->first()->job_skill_id;
                    $selected_id = str_replace("JBSH","",$selected_id);
                }

                $jobSkillObj= JobSkill::find($job_skill_id );
                if(count($jobSkillObj) > 0 && !empty($jobSkillObj)) {
                    $obj = JobSkillHistory::where('job_skill_id', $jobSkillObj->id)->where('user_id', Auth::user()->id)->first();
                    if (!empty($obj) && count($obj) > 0) {
                        $obj->delete();
                    }

                    $data['parent_id_belongs_to'] = null;
                    $data['job_skill_id'] = $selected_id;
                    $data['user_id'] = Auth::user()->id;
                    $data['skill_name'] = $request->input('skill_name');
                    $data['action_type'] = 'edit';

                    $skill_id = JobSkillHistory::create($data)->id;

                    $path_text = $request->input('path_text');
                    $html = '<a href="'.url('userprofiles/'.$user_id.'/'.strtolower(Auth::user()->first_name.'_'.Auth::user()->last_name)).'">'
                        .Auth::user()->first_name.' '.Auth::user()->last_name.'</a> edited skill <a href="'.url('site_admin').'">'
                        .$data['skill_name'].'</a>';
                    if(!empty($path_text)){
                        $html.=' in the <a href="'.url('site_admin').'">'.$path_text.'</a>';
                    }

                    SiteActivity::create([
                        'user_id'=>Auth::user()->id,
                        'comment'=>$html
                    ]);
                    return \Response::json(['success'=>true,'skill_id'=>$jobSkillObj->id,'type'=>$type,'skill_name'=>$data['skill_name'] ]);
                }

            } else {
                $obj = JobSkillHistory::find($selected_id);
                if(!empty($obj) && count($obj) > 0) {
                    $obj->update(['skill_name' => $request->input('skill_name')]);
                    $path_text = $request->input('path_text');
                    $html = '<a href="'.url('userprofiles/'.$user_id.'/'.strtolower(Auth::user()->first_name.'_'.Auth::user()->last_name)).'">'
                        .Auth::user()->first_name.' '.Auth::user()->last_name.'</a> edited skill <a href="'.url('site_admin').'">'
                        .$request->input('skill_name').'</a>';
                    if(!empty($path_text)){
                        $html.=' in the <a href="'.url('site_admin').'">'.$path_text.'</a>';
                    }

                    SiteActivity::create([
                        'user_id'=>Auth::user()->id,
                        'comment'=>$html
                    ]);
                    return \Response::json(['success'=>true,'skill_id'=>$obj->id,'type'=>$type,'skill_name'=>$request->input('skill_name')]);
                }
            }
        }
        return \Response::json(['success'=>false,'errors'=>['Something goes wrong please try again later.']]);


        /*if(!empty($skill_id)){
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
        return view('errors.404');*/
    }
    public function skill_delete(Request $request){
        if(Auth::check() && $request->ajax()){
            $id = $request->input('id');
            $type = $request->input('type');
            $path_text = $request->input('path_text');

            $userIDHashID= new Hashids('user id hash',10,\Config::get('app.encode_chars'));
            $user_id = $userIDHashID->encode(Auth::user()->id);


            $html = '<a href="'.url('userprofiles/'.$user_id.'/'.strtolower(Auth::user()->first_name.'_'.Auth::user()->last_name)).'">'
                .Auth::user()->first_name.' '.Auth::user()->last_name.'</a> deleted skill <a href="'.url('site_admin').'">';

            if($type == "new"){
                $obj = JobSkillHistory::where('id',$id)->where('user_id',Auth::user()->id)->first();
                if(!empty($obj) && count($obj) > 0) {
                    $html.=$obj->skill_name.'</a>';
                    if(!empty($path_text)){
                        $html.=' in the <a href="'.url('site_admin').'">'.$path_text.'</a>';
                    }
                    $obj->delete();
                    SiteActivity::create([
                        'user_id'=>Auth::user()->id,
                        'comment'=>$html
                    ]);
                    return \Response::json(['success'=>true,'msg'=>'Skill deleted successfully']);
                }
            }
            else{
                $data['parent_id_belongs_to'] = null;
                $data['job_skill_id'] = $id;
                $data['user_id'] = Auth::user()->id;
                $data['action_type'] = 'delete';
                JobSkillHistory::create($data);

                $jobObj = JobSkill::find($id);
                if(count($jobObj) > 0 && !empty($jobObj))
                    $html.=$jobObj->skill_name.'</a>';
                if(!empty($path_text)){
                    $html.=' in the <a href="'.url('site_admin').'">'.$path_text.'</a>';
                }
                SiteActivity::create([
                    'user_id'=>Auth::user()->id,
                    'comment'=>$html
                ]);

                return \Response::json(['success'=>true]);
            }
            /*$jobSkillExist = JobSkill::whereRaw('parent_id = "'.$id.'"')->count();
            if($jobSkillExist == 0){
                $cnt = JobSkill::find($id)->count();
                if($cnt > 0) {
                    JobSkill::find($id)->forceDelete();
                }
                return \Response::json(['success'=>true,'msg'=>'Skill deleted successfully']);
            }*/
        }
        return \Response::json(['success'=>false,'msg'=>'You are not authorized person to perform this action.']);
    }
    public function area_of_interest_add(Request $request){
        if(!Auth::check())
            return \Redirect::to(url(''));

        view()->share('areaOfInterestObj',[]);
        view()->share('parent_area_of_interest',AreaOfInterest::lists('title','id')->all());
        view()->share('method','area_of_interest/add');
        if($request->isMethod('post')){
            $validator = \Validator::make($request->all(), [
                'title' => 'required'
            ]);

            if ($validator->fails())
                return redirect()->back()->withErrors($validator)->withInput();

            $areaOfInterestExist = AreaOfInterest::whereRaw('LOWER(title) = "'.strtolower($request->input('title').'"'))->count();

            if($areaOfInterestExist> 0)
                return redirect()->back()->withErrors(['skill_name'=>'Area of interest already exists.'])->withInput();

            $parent_id = $request->input('parent_id');
            if(empty($parent_id))
                $parent_id=null;

            AreaOfInterest::create([
                'title'=>$request->input('title'),
                'parent_id'=>$request->input('parent_id')
            ]);
            $request->session()->flash('msg_val', "Area of interest created successfully!!!");
            return redirect('site_admin');
        }
        $site_activity = SiteActivity::orderBy('id','desc')->paginate(\Config::get('app.site_activity_page_limit'));
        view()->share('site_activity',$site_activity);
        view()->share('site_activity_text','Global Activity Log');
        return view('admin.partials.add_area_of_interest');
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

    public function area_of_interest_view(Request $request,$area_id){
        if(!empty($area_id)){
            $areaOfInterestIDHashID = new Hashids('area of interest id hash',10,\Config::get('app.encode_chars'));
            $area_id = $areaOfInterestIDHashID->decode($area_id);
            if(!empty($area_id)){
                $area_id= $area_id[0];
                $areaOfInterestObj = AreaOfInterest::find($area_id);
                if(!empty($areaOfInterestObj) && count($areaOfInterestObj) > 0){
                    view()->share('areaOfInterestObj',$areaOfInterestObj);
                    $site_activity = SiteActivity::orderBy('id','desc')->paginate(\Config::get('app.site_activity_page_limit'));
                    view()->share('site_activity',$site_activity);
                    view()->share('site_activity_text','Global Activity Log');
                    return view('admin.partials.area_of_interest_view');
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



    public function area_of_interest_edit(Request $request,$area_id){
        if(!empty($area_id)){
            $area_id_encoded = $area_id;
            $areaOfInterestIDHashID = new Hashids('area of interest id hash',10,\Config::get('app.encode_chars'));
            $area_id = $areaOfInterestIDHashID->decode($area_id);
            if(!empty($area_id)){
                $area_id= $area_id[0];
                $areaOfInterestObj = AreaOfInterest::find($area_id);
                if(!empty($areaOfInterestObj) && count($areaOfInterestObj) > 0){
                    if($request->isMethod('post')){
                        $validator = \Validator::make($request->all(), [
                            'title' => 'required'
                        ]);

                        if ($validator->fails())
                            return redirect()->back()->withErrors($validator)->withInput();

                        $areaOfInterestExist = AreaOfInterest::whereRaw('LOWER(title) = "'.strtolower($request->input('title').'" and id != "'.$area_id.'"'))->count();

                        if($areaOfInterestExist > 0)
                            return redirect()->back()->withErrors(['title'=>'Area of Interest already exists.'])->withInput();

                        $parent_id = $request->input('parent_id');
                        if(empty($parent_id))
                            $parent_id=null;

                        $areaOfInterestObj->update([
                            'title'=>$request->input('title'),
                            'parent_id'=>$request->input('parent_id')
                        ]);
                        $request->session()->flash('msg_val', "Area of Interest updated successfully!!!");
                        return redirect('site_admin');
                    }
                    view()->share('areaOfInterestObj',$areaOfInterestObj);
                    $site_activity = SiteActivity::orderBy('id','desc')->paginate(\Config::get('app.site_activity_page_limit'));
                    view()->share('site_activity',$site_activity);
                    view()->share('site_activity_text','Global Activity Log');
                    view()->share('method','area_of_interest/'.$area_id_encoded .'/edit');
                    view()->share('parent_area_of_interest',AreaOfInterest::where('id','!=',$area_id)->lists('title','id')->all());
                    return view('admin.partials.add_area_of_interest');
                }
            }
        }
        return view('errors.404');
    }

    public function get_skills(Request $request){
        $terms = $request->input('term');
        $page = $request->input('page');
        if(!empty($terms)){
            if($page == 0 || empty($page))
                $page =0;
            $str = JobSkill::getHierarchy($terms,$page );

            if(!empty($str)){
                foreach($str as $index=>$s){
                    if(is_array($s['name'])){
                        $str[$index]['name']=implode(" > ",array_reverse($s['name']));
                    }

                }
                return \Response::json(['items'=>$str,'total_counts'=>$obj = JobSkill::where('skill_name','like',$terms.'%')->count()]);
            }
        }
        return \Response::json([]);

    }

    public function get_next_level_skills(Request $request){
        $id = $request->input('id');
        $type = $request->input('type');
        if (strpos($id, 'JBSH') !== false) {
            if($type == "old")
                $id = JobSkillHistory::where('prefix_id',$id)->first()->job_skill_id;
            else
                $id = JobSkillHistory::where('prefix_id',$id)->first()->id;
        }

        if($type == "new"){
            $dataObj=JobSkillHistory::where('parent_id',$id)->where('parent_id_belongs_to','new')->get();
        }
        else {

            $where=" AND user_id=".Auth::user()->id;

            $dataObj = \DB::select('SELECT
                                      job_skills.id AS id,
                                      NULL AS history_id,
                                      NULL AS job_id,
                                      job_skills.skill_name AS skill_name,
                                      NULL AS history_skill_name,
                                      job_skills.parent_id AS parent_id,
                                      NULL AS history_parent_id,
                                      NULL AS action_type
                                    FROM
                                      `job_skills` , job_skills_history
                                    WHERE job_skills.parent_id = ' . $id . ' AND job_skills.id !=  job_skills_history.job_skill_id
                                    UNION ALL
                                    SELECT
                                      job_skills.id AS id,
                                      history.history_id AS history_id,
                                      history.job_id AS job_id,
                                      job_skills.skill_name AS skill_name,
                                      history.history_skill_name AS history_skill_name,
                                      job_skills.parent_id AS parent_id,
                                      history.history_parent_id AS history_parent_id,
                                      history.action_type AS action_type
                                    FROM
                                      `job_skills`
                                      LEFT JOIN
                                        (SELECT
                                          job_skills_history.id AS history_id,
                                          job_skill_id AS job_id,user_id,
                                          job_skills_history.`skill_name` AS history_skill_name,
                                          job_skills_history.parent_id AS history_parent_id,
                                          action_type FROM job_skills_history WHERE (parent_id_belongs_to="old" OR parent_id_belongs_to IS
                                           NULL)'.$where.') history
                                          ON job_skills.id = history.`job_id`
                                        WHERE job_skills.parent_id = '.$id.'
                                    UNION
                                    ALL
                                    SELECT
                                      id,
                                      id as history_id,
                                      job_skill_id AS job_id,
                                      skill_name,
                                      skill_name AS history_skill_name,
                                      parent_id,
                                      parent_id AS history_parent_id,
                                      action_type
                                    FROM
                                      job_skills_history
                                    WHERE parent_id = ' . $id . $where.' AND parent_id_belongs_to="old" AND action_type != "delete" order by id');
        }


        $skills =  [];
        $deleted_ids = [];
        if(!empty($dataObj)){
            foreach($dataObj as $skillObj){
                if(in_array($skillObj->id,$deleted_ids))
                    continue;
                if($skillObj->action_type == "delete") {
                    $deleted_ids[]=$skillObj->id;
                    if(isset($skills[$skillObj->id])) {
                        unset($skills[$skillObj->id]);
                    }
                    continue;
                }
                if($type == "new"){
                    $skills[$skillObj->id] = ['type' => 'new', 'name' => $skillObj->skill_name];
                }
                else {
                    if (!empty($skillObj->action_type) && $skillObj->action_type == "edit")
                        $skills[$skillObj->id] = ['type' => 'old', 'name' => $skillObj->history_skill_name];
                    elseif (!empty($skillObj->action_type) && $skillObj->action_type == "add")
                        $skills[$skillObj->history_id] = ['type' => 'new', 'name' => $skillObj->history_skill_name];
                    else
                        $skills[$skillObj->id] = ['type' => 'old', 'name' => $skillObj->skill_name];
                }
            }
        }

       /* dd($dataObj);
        if($type  == "old")
            $skills = JobSkill::where('parent_id',$id)->lists('skill_name','id')->all();
        else
            $skills=JobSkillHistory::where('parent_id',$id)->lists('skill_name','id')->all();*/
        return \Response::json(['success'=>true,'data'=>$skills]);
    }

    public function approveSkill(Request $request){
        if($request->ajax() && Auth::check()){
            if(Auth::user()->role=="superadmin"){
                $prefix_id = $request->input('id');
                if(!empty($prefix_id)){
                    $jobSkillHistory = JobSkillHistory::where('prefix_id',$prefix_id)->first();
                    if(!empty($jobSkillHistory) && count($jobSkillHistory) > 0){
                        if($jobSkillHistory->parent_id_belongs_to == "old"){
                            $data['skill_name']=$jobSkillHistory->skill_name;
                            $data['parent_id']=$jobSkillHistory->parent_id;
                            $data['status']='approved';
                            if($jobSkillHistory->action_type == "add"){
                                JobSkill::create($data);
                                $jobSkillHistory->delete();
                                return \Response::json(['success'=>true]);
                            }
                            elseif($jobSkillHistory->action_type == "add"){

                            }
                        }
                    }
                }
            }
        }
        return \Response::json(['success'=>false]);

    }
}
