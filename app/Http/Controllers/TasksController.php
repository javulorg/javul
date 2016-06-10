<?php

namespace App\Http\Controllers;

use App\ActivityPoint;
use App\JobSkill;
use App\Objective;
use App\SiteActivity;
use App\Task;
use App\TaskAction;
use App\TaskDocuments;
use App\Unit;
use Hashids\Hashids;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;

class TasksController extends Controller
{
    public function __construct(){
        $this->middleware('auth',['except'=>['index']]);
    }

    public function index(Request $request){
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


        $tasks = \DB::table('tasks')
            ->join('objectives','tasks.objective_id','=','objectives.id')
            ->join('units','tasks.unit_id','=','units.id')
            ->join('users','tasks.user_id','=','users.id')
            ->select(['tasks.*','units.name as unit_name','users.first_name','users.last_name',
                'users.id as user_id','objectives.name as objective_name'])->get();


        view()->share('tasks',$tasks);
        return view('tasks.tasks');
    }

    public function create(Request $request){
        $unitsObj = Unit::where('status','active')->lists('name','id');
        $task_skills = JobSkill::lists('skill_name','id');
        $assigned_toUsers = User::where('id','!=',Auth::user()->id)->where('role','!=','superadmin')->get();
        $assigned_toUsers= $assigned_toUsers->lists('full_name','id');
        view()->share('assigned_toUsers',$assigned_toUsers);
        view()->share('task_skills',$task_skills );
        view()->share('unitsObj',$unitsObj);
        view()->share('taskObj',[]);
        view()->share('taskDocumentsObj',[]);

        if($request->isMethod('post')){

            $validator = \Validator::make($request->all(), [
                'unit' => 'required',
                'objective' => 'required',
                'task_name' => 'required',
                'task_skills' => 'required',
                'estimated_completion_time_start' => 'required',
                'estimated_completion_time_end' => 'required',
                'description'=>'required'
            ]);

            if ($validator->fails())
                return redirect()->back()->withErrors($validator)->withInput();

            // check unit id exist in db
            $unit_id = $request->input('unit');
            $flag =Unit::checkUnitExist($unit_id ,true);
            if(!$flag)
                return redirect()->back()->withErrors(['unit'=>'Unit doesn\'t exist in database.'])->withInput();


            // check objective id exist in db
            $objective_id = $request->input('objective');
            $flag =Objective::checkObjectiveExist($objective_id ,true); // pass objective_id and true for decode the string
            if(!$flag)
                return redirect()->back()->withErrors(['objective'=>'Objective doesn\'t exist in database.'])->withInput();

            $unitIDHashID= new Hashids('unit id hash',10,\Config::get('app.encode_chars'));
            $unit_id = $unitIDHashID->decode($unit_id);

            $objectiveIDHashID = new Hashids('objective id hash',10,\Config::get('app.encode_chars'));
            $objective_id = $objectiveIDHashID->decode($objective_id);

            // create task
            $task_id = Task::create([
                'user_id'=>Auth::user()->id,
                'unit_id'=>$unit_id[0],
                'objective_id'=>$objective_id[0],
                'name'=>$request->input('task_name'),
                'description'=>$request->input('description'),
                'summary'=>$request->input('summary'),
                'skills'=>$request->input('task_skills'),
                'estimated_completion_time_start'=>$request->input('estimated_completion_time_start'),
                'estimated_completion_time_end'=>$request->input('estimated_completion_time_end'),
                'status'=>'editable'
            ])->id;

            $task_id_decoded= $task_id;
            $taskIDHashID= new Hashids('task id hash',10,\Config::get('app.encode_chars'));
            $task_id = $taskIDHashID->encode($task_id);

            // insert action items of task.
            $action_items_ar = $request->input('action_items_array');
            if(!empty($action_items_ar)){
                foreach($action_items_ar as $item){
                    $item = strip_tags($item);
                    if(!empty($item)){
                        TaskAction::create([
                            'user_id'=>Auth::user()->id,
                            'task_id'=>$task_id_decoded,
                            'name'=>$item,
                            'description'=>'',
                            'status'=>'active'
                        ]);
                    }
                }
            }

            // upload documents of task.

            if($request->hasFile('documents')) {
                $files = $request->file('documents');
                if(count($files) > 0){
                    foreach($files as $index=>$file){
                        $rules = ['document' => 'required', 'extension' => 'required|in:doc,docx,pdf,txt,jpg,png,ppt,pptx,jpeg,doc,xls,xlsx'];
                        $fileData = ['document' => $file, 'extension' => strtolower($file->getClientOriginalExtension())];

                        // doing the validation, passing post data, rules and the messages
                        $validator = \Validator::make($fileData, $rules);
                        if (!$validator->fails()) {
                           if ($file->isValid()) {
                                $destinationPath = 'uploads/tasks/'.$task_id; // upload path
                                if(!\File::exists($destinationPath)){
                                    $oldumask = umask(0);
                                    @mkdir($destinationPath, 0775); // or even 01777 so you get the sticky bit set
                                    umask($oldumask);
                                }
                                $extension = $file->getClientOriginalExtension(); // getting image extension
                                $fileName = $task_id.'_'.$index . '.' . $extension; // renaming image
                                $file->move($destinationPath, $fileName); // uploading file to given path

                                // insert record into task_documents table
                                $path = $destinationPath.'/'.$fileName;
                                TaskDocuments::create([
                                    'task_id'=>$task_id_decoded,
                                    'file_path'=>$path
                                ]);
                            }
                        }
                    }
                }
            }
            // add activity point for created task.

            ActivityPoint::create([
                'user_id'=>Auth::user()->id,
                'objective_id'=>$task_id,
                'points'=>5,
                'comments'=>'Task Created',
                'type'=>'task'
            ]);

            // add site activity record for global statistics.


            $userIDHashID= new Hashids('user id hash',10,\Config::get('app.encode_chars'));
            $user_id = $userIDHashID->encode(Auth::user()->id);

            SiteActivity::create([
                'user_id'=>Auth::user()->id,
                'comment'=>'<a href="'.url('users/'.$user_id).'">'.Auth::user()->first_name.' '.Auth::user()->last_name.'</a>
                        created task <a href="'.url('tasks/'.$task_id).'">'.$request->input('task_name').'</a>'
            ]);

            // TODO: create forum entry when task is created : in PDF page no - 10


        }

        return view('tasks.create');
    }

    public function get_objective(Request $request){
        $unit_id = $request->input('unit_id');
        if(!empty($unit_id)){
            $unitIDHashID = new Hashids('unit id hash',10,\Config::get('app.encode_chars'));
            $unit_id = $unitIDHashID->decode($unit_id);

            $objectiveIDHashID = new Hashids('objective id hash',10,\Config::get('app.encode_chars'));


            if(!empty($unit_id)){
                $unit_id = $unit_id[0];
                $unitObj = Unit::where('id',$unit_id)->get();
                if(count($unitObj) > 0){
                    $objectivesObj = Objective::where('unit_id',$unit_id)->lists('name','id');
                    $return_arr = [];
                    if(count($objectivesObj) > 0){
                        foreach($objectivesObj as $id=>$val)
                            $return_arr[$objectiveIDHashID->encode($id)] = $val;
                    }
                    return \Response::json(['success'=>true,'objectives'=>$return_arr]);
                }
            }
        }
        return \Response::json(['success'=>false]);
    }
}
