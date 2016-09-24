<?php

namespace App\Http\Controllers;

use App\ActivityPoint;
use App\Fund;
use App\ImportanceLevel;
use App\Issue;
use App\IssueDocuments;
use App\Objective;
use App\SiteActivity;
use App\Task;
use App\Unit;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;

class IssuesController extends Controller
{
    public function __construct(){
        $this->middleware('auth',['except'=>['index']]);
    }


    /**
     * Create issue page
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request){
        $unit_id = $request->segment(2);
        $objective_id = $request->segment(4);
        $task_id = $request->segment(5);

        $unitObj = [];
        $objectiveObj = [];
        $taskObj = [];
        if(!empty($unit_id))
        {
            $unitIDHashID= new Hashids('unit id hash',10,\Config::get('app.encode_chars'));
            $unit_id = $unitIDHashID->decode($unit_id);
            if(!empty($unit_id)){
                $unit_id = $unit_id[0];
                $unitObj = Unit::find($unit_id);
                if(!empty($unitObj)){

                    if($request->isMethod('post')) {

                        $validator = \Validator::make($request->all(), [
                            'title' => 'required',
                            'description' => 'required'
                        ]);

                        if ($validator->fails())
                            return redirect()->back()->withErrors($validator)->withInput();


                        // get selected objective_id
                        $selected_objective_id = Issue::getSelectedObjective($request);

                        //get all selected task_id
                        $selected_task_id_arr= Issue::getSelectedTask($request);

                        $issue_id = Issue::create([
                            'title'=>$request->input('title'),
                            'description'=>$request->input('description'),
                            'user_id'=>Auth::user()->id,
                            'status'=>'unverified',
                            'unit_id'=>$unit_id,
                            'objective_id'=>$selected_objective_id,
                            'task_id'=>$selected_task_id_arr
                        ])->id;

                        // upload issue documents
                        IssueDocuments::uploadDocuments($issue_id,$request);
                        // upload finish

                        ActivityPoint::create([
                            'user_id'=>Auth::user()->id,
                            'issue_id'=>$issue_id,
                            'points'=>2,
                            'comments'=>'Issue Created',
                            'type'=>'issue'
                        ]);

                        // add site activity record for global statistics.
                        $issueIDHashID = new Hashids('issue id hash',10,\Config::get('app.encode_chars'));
                        $issue_id_encoded = $issueIDHashID->encode($issue_id);

                        $userIDHashID= new Hashids('user id hash',10,\Config::get('app.encode_chars'));
                        $user_id = $userIDHashID->encode(Auth::user()->id);

                        SiteActivity::create([
                            'user_id'=>Auth::user()->id,
                            'unit_id'=>$unit_id[0],
                            'objective_id'=>$objective_id[0],
                            'task_id'=>$task_id,
                            'comment'=>'<a href="'.url('userprofiles/'.$user_id.'/'.strtolower(Auth::user()->first_name.'_'.Auth::user()->last_name)).'">'
                                .Auth::user()->first_name.' '.Auth::user()->last_name.'</a>
                        created issue <a href="'.url('issues/'.$issue_id_encoded.'/view').'">'.$request->input('title').'</a>'
                        ]);

                        $request->session()->flash('msg_val', "Issue created successfully!!!");
                        return redirect('issues/'.$unitIDHashID->encode($unitObj->id).'/lists');
                    }
                    $availableUnitFunds =Fund::getUnitDonatedFund($unit_id);
                    $awardedUnitFunds =Fund::getUnitAwardedFund($unit_id);

                    view()->share('availableUnitFunds',$availableUnitFunds);
                    view()->share('awardedUnitFunds',$awardedUnitFunds);

                    $site_activity = SiteActivity::where('unit_id',$unit_id)->orderBy('id','desc')->paginate(\Config::get('app
                    .site_activity_page_limit'));

                    view()->share('awardedUnitFunds',$awardedUnitFunds);
                    view()->share('site_activity',$site_activity);
                    view()->share('unit_activity_id',$unit_id);
                    view()->share('site_activity_text','Unit activity log');
                    $objectiveObj = Objective::where('unit_id',$unitObj->id)->get();
                    view()->share('objectiveObj',$objectiveObj);


                    view()->share('unitObj',$unitObj);
                    view()->share('objectiveObj',$objectiveObj);
                    view()->share('taskObj',$taskObj);
                    view()->share('user_can_change_status',false);
                    view()->share('user_can_resolve_issue',false);
                    view()->share('taskObj',[]);
                    view()->share('issueDocumentsObj',[]);

                    view()->share('action_method','add');
                    return view('issues.create');
                }
            }
        }
        return view('errors.404');
        /*if(!empty($objective_id) || !empty($unit_id))
        {
            $objectiveIDHashID= new Hashids('objective id hash',10,\Config::get('app.encode_chars'));
            $objective_id= $objectiveIDHashID->decode($objective_id);
            if(!empty($objective_id)){
                $objective_id = $objective_id[0];
                $objectiveObj = Objective::where('id',$objective_id)->where('unit_id',$unit_id)->get();

            }
            else if(!empty($unit_id)){
                $objectiveObj = Objective::where('unit_id',$unit_id)->get();
            }
        }
        if(!empty($task_id) || !empty($objective_id))
        {
            $taskIDHashID= new Hashids('task id hash',10,\Config::get('app.encode_chars'));
            $task_id = $taskIDHashID->decode($task_id);
            if(!empty($task_id)){
                $task_id = $task_id[0];
                $taskObj = Task::where('id',$task_id)->where('objective_id',$objective_id)->where('unit_id',$unit_id)->get();
            }
            else if(!empty($objective_id))
                $taskObj = Task::where('objective_id',$objective_id)->get();
            else if(!empty($unit_id))
                $taskObj = Task::where('unit_id',$unit_id)->get();
        }*/


    }

    public function edit(Request $request,$issue_id){
        $unit_id = $request->segment(2);
        if(!empty($issue_id)){
            $issueIDHashID = new Hashids('issue id hash',10,\Config::get('app.encode_chars'));
            $issue_id_encoded = $issue_id;
            $issue_id = $issueIDHashID->decode($issue_id);
            if(!empty($issue_id)){
                $issue_id = $issue_id[0];
                $issueObj = Issue::find($issue_id);
                if(!empty($issueObj)){

                    // check if issue resolved then redirect to view not edit mode
                    if($issueObj->status == "resolved")
                        return redirect('issues/'.$issue_id_encoded.'/view');
                    //display update page to user

                    if($request->isMethod('post')) {
                        $validator = \Validator::make($request->all(), [
                            'title' => 'required',
                            'description' => 'required'
                        ]);

                        if ($validator->fails())
                            return redirect()->back()->withErrors($validator)->withInput();


                        // get selected objective_id
                        $selected_objective_id = Issue::getSelectedObjective($request);

                        //get all selected task_id
                        $selected_task_id_arr= Issue::getSelectedTask($request);
                        $status = $request->input('status');

                        if(empty($status))
                            $status = $issueObj->status;
                        $updateArr = [
                            'title'=>$request->input('title'),
                            'description'=>$request->input('description'),
                            'status'=>$status,
                            'objective_id'=>$selected_objective_id,
                            'task_id'=>$selected_task_id_arr
                        ];

                        if($status == "verified" && empty($issueObj->verified_by))
                            $updateArr['verified_by']=Auth::user()->id;
                        else if($status == "resolved") {
                            $updateArr['resolved_by'] = Auth::user()->id;
                            $updateArr['resolution']=$request->input('resolution');
                        }

                        $issueObj->update($updateArr);

                        // upload issue documents
                        IssueDocuments::uploadDocuments($issueObj->id,$request);
                        // upload finish

                        if($status == "verified") {
                            ActivityPoint::create([
                                'user_id' => Auth::user()->id,
                                'issue_id' => $issueObj->id,
                                'points' => 2,
                                'comments' => 'Issue Verified',
                                'type' => 'issue'
                            ]);
                        }
                        else{
                            ActivityPoint::create([
                                'user_id' => Auth::user()->id,
                                'issue_id' => $issueObj->id,
                                'points' => 1,
                                'comments' => 'Issue Updated',
                                'type' => 'issue'
                            ]);
                        }

                        // add site activity record for global statistics.
                        $issueIDHashID = new Hashids('issue id hash',10,\Config::get('app.encode_chars'));
                        $issue_id_encoded = $issueIDHashID->encode($issueObj->id);

                        $userIDHashID= new Hashids('user id hash',10,\Config::get('app.encode_chars'));
                        $user_id = $userIDHashID->encode(Auth::user()->id);

                        SiteActivity::create([
                            'user_id'=>Auth::user()->id,
                            'unit_id'=>$issueObj->unit_id,
                            'comment'=>'<a href="'.url('userprofiles/'.$user_id.'/'.strtolower(Auth::user()->first_name.'_'.Auth::user()->last_name)).'">'
                                .Auth::user()->first_name.' '.Auth::user()->last_name.'</a>
                        updated issue <a href="'.url('issues/'.$issue_id_encoded.'/view').'">'.$request->input('title').'</a>'
                        ]);

                        $unitIDHashID= new Hashids('unit id hash',10,\Config::get('app.encode_chars'));
                        $request->session()->flash('msg_val', "Issue updated successfully!!!");
                        return redirect('issues/'.$unitIDHashID->encode($issueObj->unit_id).'/lists');
                    }
                    $user_can_change_status = true;
                    $user_can_resolve_issue = true;
                    if($issueObj->user_id == Auth::user()->id) {
                        $user_can_change_status = false;
                        $user_can_resolve_issue = false;
                    }else {
                        $unitAdmin = \App\Task::checkUnitAdmin($issueObj->unit_id);
                        if (Auth::user()->role == "superadmin" || Auth::user()->id == $unitAdmin) {
                            $user_can_change_status = true;
                            $user_can_resolve_issue = true;
                        }
                    }

                    $unitObj = Unit::find($issueObj->unit_id);
                    $objectiveObj = Objective::where('unit_id',$issueObj->unit_id)->get();

                    $site_activity = SiteActivity::where('unit_id',$issueObj->unit_id)->orderBy('id','desc')->paginate(\Config::get('app
                    .site_activity_page_limit'));

                    $availableUnitFunds =Fund::getUnitDonatedFund($issueObj->unit_id);
                    $awardedUnitFunds =Fund::getUnitAwardedFund($issueObj->unit_id);

                    $taskObj = Task::where('objective_id',$issueObj->objective_id)->get();
                    $issueDocumentsObj = IssueDocuments::where('issue_id',$issue_id)->get();
                    view()->share('issueDocumentsObj',$issueDocumentsObj);
                    view()->share('taskObj',$taskObj);
                    view()->share('availableUnitFunds',$availableUnitFunds);
                    view()->share('awardedUnitFunds',$awardedUnitFunds);
                    view()->share('unitObj',$unitObj);
                    view()->share('site_activity',$site_activity);
                    view()->share('unit_activity_id',$issueObj->unit_id);
                    view()->share('site_activity_text','Unit activity log');
                    view()->share('objectiveObj',$objectiveObj);
                    view()->share('issueObj',$issueObj);
                    view()->share('user_can_change_status',$user_can_change_status);
                    view()->share('user_can_resolve_issue',$user_can_resolve_issue);
                    view()->share('action_method','edit');
                    return view('issues.create');
                }
            }
        }
        return view('errors.404');
    }

    /**
     * Issue details page.
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view(Request $request){
        $issue_id  = $request->segment(2);
        if(!empty($issue_id)){
            $issueIDHashID = new Hashids('issue id hash',10,\Config::get('app.encode_chars'));
            $issue_id = $issueIDHashID ->decode($issue_id);
            if(!empty($issue_id)){
                $issue_id = $issue_id[0];
                $issueObj = Issue::with(['issue_documents'])->find($issue_id);
                if(!empty($issueObj)  && count($issueObj) > 0){
                    $unitObj = Unit::find($issueObj->unit_id);
                    view()->share('unitObj',$unitObj);
                    view()->share('issueObj',$issueObj);
                    $site_activity = SiteActivity::where('unit_id',$issueObj->unit_id)->orderBy('id','desc')->paginate(\Config::get('app
                    .site_activity_page_limit'));

                    $availableUnitFunds =Fund::getUnitDonatedFund($issueObj->unit_id);
                    $awardedUnitFunds =Fund::getUnitAwardedFund($issueObj->unit_id);

                    $upvotedCnt = ImportanceLevel::where('issue_id',$issue_id)->where('importance_level','+1')->count();
                    $downvotedCnt = ImportanceLevel::where('issue_id',$issue_id)->where('importance_level','-1')->count();

                    if($upvotedCnt == 0 && $downvotedCnt == 0)
                        $importancePercentage = 0;
                    else
                        $importancePercentage =  ($upvotedCnt * 100) / ($upvotedCnt + $downvotedCnt);

                    if(is_float($importancePercentage))
                        $importancePercentage = ceil($importancePercentage);

                    $status_class='';
                    if($issueObj->status=="unverified")
                        $status_class="text-danger";
                    elseif($issueObj->status=="verified")
                        $status_class="text-info";
                    elseif($issueObj->status == "resolved")
                        $status_class = "text-success";
                    view()->share('status_class',$status_class);
                    view()->share('importancePercentage',$importancePercentage);
                    view()->share('upvotedCnt',$upvotedCnt);
                    view()->share('downvotedCnt',$downvotedCnt);
                    view()->share('importancePercentage',$importancePercentage);
                    view()->share('availableUnitFunds',$availableUnitFunds);
                    view()->share('awardedUnitFunds',$awardedUnitFunds);
                    view()->share('site_activity',$site_activity);
                    view()->share('site_activity_text','unit activity log');

                    return view('issues.view');
                }
            }
        }
        return view('errors.404');
    }

    /**
     * Issue listing
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function lists(Request $request){
        $unit_id = $request->segment(2);
        if(!empty($unit_id))
        {
            $unitIDHashID= new Hashids('unit id hash',10,\Config::get('app.encode_chars'));
            $unit_id = $unitIDHashID->decode($unit_id);
            if(!empty($unit_id)){
                $unit_id = $unit_id[0];
                $unitObj = Unit::find($unit_id);
                if(!empty($unitObj)){
                    view()->share('unitObj',$unitObj);
                    $issuesObj = Issue::where('unit_id',$unit_id)->orderBy('id','desc')->paginate(\Config::get('app.page_limit'));
                    view()->share('issuesObj',$issuesObj);
                    $site_activity = SiteActivity::where('unit_id',$unit_id)->orderBy('id','desc')->paginate(\Config::get('app
                    .site_activity_page_limit'));

                    $availableUnitFunds =Fund::getUnitDonatedFund($unit_id);
                    $awardedUnitFunds =Fund::getUnitAwardedFund($unit_id);

                    view()->share('availableUnitFunds',$availableUnitFunds);
                    view()->share('awardedUnitFunds',$awardedUnitFunds);
                    view()->share('site_activity',$site_activity);
                    view()->share('unit_activity_id',$unit_id);
                    view()->share('site_activity_text','Unit activity log');

                    $msg_flag = false;
                    $msg_val = '';
                    $msg_type = '';
                    if($request->session()->has('msg_val')){
                        $msg_val =  $request->session()->get('msg_val');
                        $request->session()->forget('msg_val');
                        $msg_flag = true;
                        $msg_type = "success";
                        if($request->session()->has('msg_type')){
                            $msg_type = $request->session()->get('msg_type');
                            $request->session()->forget('msg_type');
                        }
                    }
                    view()->share('msg_flag',$msg_flag);
                    view()->share('msg_val',$msg_val);
                    view()->share('msg_type',$msg_type);


                    return view('issues.list');
                }

            }
        }
        return view('errors.404');
    }

    /**
     * soft deleting the document of given issue_id
     * @param Request $request
     * @return mixed
     */
    public function remove_document(Request $request){
        $issue_id = $request->input('issue_id');
        $id = $request->input('id');

        $issueIDHashID = new Hashids('issue id hash',10,\Config::get('app.encode_chars'));
        $issueDocumentIDHashID = new Hashids('issue document id hash',10,\Config::get('app.encode_chars'));

        $issue_id = $issueIDHashID->decode($issue_id);

        if(empty($issue_id))
            return \Response::json(['success'=>false]);

        $issue_id = $issue_id[0];
        $issueObj = Issue::find($issue_id);
        if(empty($issueObj))
            return \Response::json(['success'=>false]);

        $id = $issueDocumentIDHashID->decode($id);
        if(empty($id))
            return \Response::json(['success'=>false]);

        $id= $id[0];
        $issueDocumentObj = IssueDocuments::where('issue_id',$issue_id)->where('id',$id)->get();

        if(count($issueDocumentObj ) > 0){
            IssueDocuments::where('issue_id',$issue_id)->where('id',$id)->delete();
            return \Response::json(['success'=>true]);
        }

        return \Response::json(['success'=>false]);
    }

    public function add_importance(Request $request){
        $issue_id = $request->input('id');
        $issue_idEncoded = $issue_id;
        $type = $request->input('type');
        if(!empty($issue_id)){
            $issueIDHashID = new Hashids('issue id hash',10,\Config::get('app.encode_chars'));
            $issue_id = $issueIDHashID->decode($issue_id);
            if(!empty($issue_id)){
                $issue_id = $issue_id[0];
                $issueObj = Issue::find($issue_id);
                if(!empty($issueObj)){
                    $importanceLevelObj = ImportanceLevel::where('issue_id',$issue_id)->where('user_id',Auth::user()->id)->first();
                    $site_activity_text = '';
                    if($type == "up"){
                        $levelValue = "+1";
                        $site_activity_text =" upvote objective ";
                    }
                    else{
                        $levelValue = "-1";
                        $site_activity_text =" downvote objective ";
                    }
                    if(count($importanceLevelObj) > 0)
                        $importanceLevelObj->update(['importance_level'=>$levelValue]);
                    else{
                        ImportanceLevel::create([
                            'user_id'=>Auth::user()->id,
                            'issue_id'=>$issue_id,
                            'importance_level'=>$levelValue,
                            'type'=>'Objective'
                        ]);
                    }

                    $upvotedCnt = ImportanceLevel::where('issue_id',$issue_id)->where('importance_level','+1')->count();
                    $downvotedCnt = ImportanceLevel::where('issue_id',$issue_id)->where('importance_level','-1')->count();

                    $importancePercentage =  ($upvotedCnt * 100) / ($upvotedCnt + $downvotedCnt);

                    if(is_float($importancePercentage))
                        $importancePercentage = ceil($importancePercentage);
                    view()->share('upvotedCnt',$upvotedCnt);
                    view()->share('downvotedCnt',$downvotedCnt);
                    view()->share('importancePercentage',$importancePercentage);

                    $importance_level_html = view('issues.partials.importance_level',['issue_id'=>$issue_id])->render();

                    return \Response::json(['success'=>true,'html'=>$importance_level_html]);
                }
            }
        }
        return \Response::json(['success'=>false]);

    }

    public function sort_issues(Request $request){
        $unit_id = $request->input('unit_id');
        $order_by = $request->input('order_by');
        if(!empty($unit_id))
        {
            $unitIDHashID= new Hashids('unit id hash',10,\Config::get('app.encode_chars'));
            $unit_id = $unitIDHashID->decode($unit_id);
            if(!empty($unit_id)){
                $unit_id = $unit_id[0];
                $unitObj = Unit::find($unit_id);
                if(!empty($unitObj)){
                    view()->share('unitObj',$unitObj);
                    if($order_by == "older")
                        $order_by = "asc";
                    else
                        $order_by = "desc";

                    $issuesObj = Issue::where('unit_id',$unit_id)->orderBy('id',$order_by)->paginate(\Config::get('app.page_limit'));
                    view()->share('issuesObj',$issuesObj);
                    view()->share('unit_activity_id',$unit_id);
                    $html = view('issues.partials.issue_listing')->render();
                    return \Response::json(['success'=>true,'html'=>$html ]);
                }

            }
        }
        return \Response::json(['success'=>false]);
    }
}
