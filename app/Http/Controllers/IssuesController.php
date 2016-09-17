<?php

namespace App\Http\Controllers;

use App\ActivityPoint;
use App\Fund;
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

                        $issue_id = Issue::create([
                            'title'=>$request->input('title'),
                            'description'=>$request->input('description'),
                            'user_id'=>Auth::user()->id,
                            'status'=>'unverified',
                            'unit_id'=>$unit_id
                        ])->id;

                        $issueIDHashID = new Hashids('issue id hash',10,\Config::get('app.encode_chars'));
                        $issue_id_encoded = $issueIDHashID->encode($issue_id);
                        if($request->hasFile('documents')) {
                            $files = $request->file('documents');
                            if(count($files) > 0){
                                $totalAvailableDocs = IssueDocuments::where('issue_id',$issue_id)->get();
                                $totalAvailableDocs= count($totalAvailableDocs) + 1;
                                foreach($files as $index=>$file){
                                    if(!empty($file)){
                                        $rules = ['document' => 'required', 'extension' => 'required|in:doc,docx,pdf,txt,jpg,png,ppt,pptx,jpeg,doc,xls,xlsx'];
                                        $fileData = ['document' => $file, 'extension' => strtolower($file->getClientOriginalExtension())];

                                        // doing the validation, passing post data, rules and the messages
                                        $validator = \Validator::make($fileData, $rules);
                                        if (!$validator->fails()) {
                                            if ($file->isValid()) {
                                                $destinationPath = base_path().'/uploads/issue/'.$issue_id_encoded; // upload path
                                                if(!\File::exists($destinationPath)){
                                                    $oldumask = umask(0);
                                                    @mkdir($destinationPath, 0775); // or even 01777 so you get the sticky bit set
                                                    umask($oldumask);
                                                }
                                                $file_name =$file->getClientOriginalName();
                                                $extension = $file->getClientOriginalExtension(); // getting image extension
                                                //$fileName = $task_id.'_'.$index . '.' . $extension; // renaming image
                                                $fileName = $issue_id_encoded.'_'.$totalAvailableDocs . '.' . $extension; // renaming image
                                                $file->move($destinationPath, $fileName); // uploading file to given path

                                                // insert record into task_documents table
                                                $path = $destinationPath.'/'.$fileName;
                                                IssueDocuments::create([
                                                    'issue_id'=>$issue_id,
                                                    'file_name'=>$file_name,
                                                    'file_path'=>'uploads/tasks/'.$issue_id_encoded.'/'.$fileName
                                                ]);
                                                $totalAvailableDocs++;
                                            }
                                        }
                                    }
                                }
                            }
                        }

                        ActivityPoint::create([
                            'user_id'=>Auth::user()->id,
                            'issue_id'=>$issue_id,
                            'points'=>2,
                            'comments'=>'Issue Created',
                            'type'=>'issue'
                        ]);

                        // add site activity record for global statistics.


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
}
