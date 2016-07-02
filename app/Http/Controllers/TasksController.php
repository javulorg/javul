<?php

namespace App\Http\Controllers;

use App\ActivityPoint;
use App\JobSkill;
use App\Objective;
use App\SiteActivity;
use App\Task;
use App\TaskAction;
use App\TaskDocuments;
use App\TaskEditor;
use App\TaskHistory;
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
        $this->middleware('auth',['except'=>['index','view']]);
    }

    /**
     * Task Listing
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View]
     */
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


        //\DB::enableQueryLog();
        $tasks = \DB::table('tasks')
            ->join('objectives','tasks.objective_id','=','objectives.id')
            ->join('units','tasks.unit_id','=','units.id')
            ->join('users','tasks.user_id','=','users.id')
            ->select(['tasks.*','units.name as unit_name','users.first_name','users.last_name',
                'users.id as user_id','objectives.name as objective_name'])
            ->whereNull('tasks.deleted_at')
            ->get();
        //dd(\DB::getQueryLog());


        view()->share('tasks',$tasks);
        return view('tasks.tasks');
    }

    /**
     * create task.
     * @param Request $request
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function create(Request $request){

        $segments =$request->segments();

        $taskObjectiveObj = [];
        $task_unit_id = null;
        $task_objective_id = null;

        $unitIDHashID= new Hashids('unit id hash',10,\Config::get('app.encode_chars'));
        $objectiveIDHashID = new Hashids('objective id hash',10,\Config::get('app.encode_chars'));
        if(count($segments) == 4){

            $task_unit_id = $request->segment(2);
            $task_objective_id = $request->segment(3);

            if(empty($task_unit_id) || empty($task_objective_id))
                return view('errors.404');


            $task_unit_id = $unitIDHashID->decode($task_unit_id);


            $task_objective_id = $objectiveIDHashID->decode($task_objective_id);

            if(empty($task_unit_id) || empty($task_objective_id))
                return view('errors.404');

            $task_unit_id = $task_unit_id[0];
            $task_objective_id = $task_objective_id[0];

            $taskUnitObj = Unit::find($task_unit_id);
            $taskObjectiveObj = Objective::find($task_objective_id);

            if(empty($taskUnitObj) || empty($taskObjectiveObj))
                return view('errors.404');

            $taskObjectiveObj = Objective::where('unit_id',$task_unit_id)->get();
        }
        // ********************* make selected unitid and objectiveid from url in "add" mode **************************


        view()->share('task_unit_id',$task_unit_id);
        view()->share('task_objective_id',$task_objective_id);

        // ********************* end **************************

        $unitsObj = Unit::where('status','active')->lists('name','id');
        $task_skills = JobSkill::lists('skill_name','id');
        $assigned_toUsers = User::where('id','!=',Auth::user()->id)->where('role','!=','superadmin')->get();
        $assigned_toUsers= $assigned_toUsers->lists('full_name','id');
        view()->share('assigned_toUsers',$assigned_toUsers);
        view()->share('task_skills',$task_skills );
        view()->share('unitsObj',$unitsObj);
        view()->share('objectiveObj',$taskObjectiveObj );
        view()->share('taskObj',[]);
        view()->share('taskDocumentsObj',[]);
        //view()->share('taskActionsObj',[]);
        view()->share('exploded_task_list',[]);
        view()->share('editFlag',false);
        view()->share('actionListFlag',false);
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


            $unit_id = $unitIDHashID->decode($unit_id);
            $objective_id = $objectiveIDHashID->decode($objective_id);

            $start_date = '';
            $end_date = '';
            try {
                $start_date  = new \DateTime($request->input('estimated_completion_time_start'));
                $end_date     = new \DateTime($request->input('estimated_completion_time_end'));
            } catch (Exception $e) {
                echo $e->getMessage();
                exit(1);
            }
            $start_date = $start_date->getTimestamp();
            $end_date  = $end_date->getTimestamp();

            // create task
            $slug=substr(str_replace(" ","_",strtolower($request->input('task_name'))),0,20);
            $task_id = Task::create([
                'user_id'=>Auth::user()->id,
                'unit_id'=>$unit_id[0],
                'objective_id'=>$objective_id[0],
                'name'=>$request->input('task_name'),
                'slug'=>$slug,
                'description'=>$request->input('description'),
                'summary'=>$request->input('summary'),
                'skills'=>$request->input('task_skills'),
                'estimated_completion_time_start'=>date('Y-m-d h:i',$start_date),
                'estimated_completion_time_end'=>date('Y-m-d h:i',$end_date),
                'task_action'=>$request->input('action_items'),
                'compensation'=>$request->input('compensation'),
                'status'=>'editable'
            ])->id;

            $task_id_decoded= $task_id;
            $taskIDHashID= new Hashids('task id hash',10,\Config::get('app.encode_chars'));
            $task_id = $taskIDHashID->encode($task_id);

            // insert action items of task.
            /*$action_items_ar = $request->input('action_items_array');
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
            }*/

            // upload documents of task.

            if($request->hasFile('documents')) {
                $files = $request->file('documents');
                if(count($files) > 0){
                    $totalAvailableDocs = TaskDocuments::where('task_id',$task_id_decoded)->get();
                    $totalAvailableDocs= count($totalAvailableDocs) + 1;
                    foreach($files as $index=>$file){
                        if(!empty($file)){
                            $rules = ['document' => 'required', 'extension' => 'required|in:doc,docx,pdf,txt,jpg,png,ppt,pptx,jpeg,doc,xls,xlsx'];
                            $fileData = ['document' => $file, 'extension' => strtolower($file->getClientOriginalExtension())];

                            // doing the validation, passing post data, rules and the messages
                            $validator = \Validator::make($fileData, $rules);
                            if (!$validator->fails()) {
                               if ($file->isValid()) {
                                    $destinationPath = base_path().'/uploads/tasks/'.$task_id; // upload path
                                    if(!\File::exists($destinationPath)){
                                        $oldumask = umask(0);
                                        @mkdir($destinationPath, 0775); // or even 01777 so you get the sticky bit set
                                        umask($oldumask);
                                    }
                                    $file_name =$file->getClientOriginalName();
                                    $extension = $file->getClientOriginalExtension(); // getting image extension
                                    //$fileName = $task_id.'_'.$index . '.' . $extension; // renaming image
                                    $fileName = $task_id.'_'.$totalAvailableDocs . '.' . $extension; // renaming image
                                    $file->move($destinationPath, $fileName); // uploading file to given path

                                    // insert record into task_documents table
                                    $path = $destinationPath.'/'.$fileName;
                                    TaskDocuments::create([
                                        'task_id'=>$task_id_decoded,
                                        'file_name'=>$file_name,
                                        'file_path'=>'uploads/tasks/'.$task_id.'/'.$fileName
                                    ]);
                                   $totalAvailableDocs++;
                                }
                            }
                        }
                    }
                }
            }
            // add activity point for created task.

            ActivityPoint::create([
                'user_id'=>Auth::user()->id,
                'task_id'=>$task_id,
                'points'=>5,
                'comments'=>'Task Created',
                'type'=>'task'
            ]);

            // add site activity record for global statistics.


            $userIDHashID= new Hashids('user id hash',10,\Config::get('app.encode_chars'));
            $user_id = $userIDHashID->encode(Auth::user()->id);

            SiteActivity::create([
                'user_id'=>Auth::user()->id,
                'comment'=>'<a href="'.url('userprofiles/'.$user_id.'/'.strtolower(Auth::user()->first_name.'_'.Auth::user()->last_name)).'">'
                    .Auth::user()->first_name.' '.Auth::user()->last_name.'</a>
                        created task <a href="'.url('tasks/'.$task_id.'/'.$slug).'">'.$request->input('task_name').'</a>'
            ]);

            // TODO: create forum entry when task is created : in PDF page no - 10

            $request->session()->flash('msg_val', "Task created successfully!!!");
            return redirect('tasks');
        }

        return view('tasks.create');
    }

    /**
     * edit task function
     * @param Request $request
     * @param $task_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request,$task_id){
        if(!empty($task_id))
        {
            $taskIDHashID = new Hashids('task id hash',10,\Config::get('app.encode_chars'));
            $task_id = $taskIDHashID->decode($task_id);
            if(!empty($task_id)){
                $task_id = $task_id[0];
                $tempTask = Task::find($task_id);

                $taskEditorObj= TaskEditor::where('task_id',$task_id)->where('user_id',Auth::user()->id)->count();
                if($taskEditorObj > 0){
                    $task  = Task::join('task_editors','tasks.id','=','task_editors.task_id')
                            ->join('task_history','task_editors.task_history_id','=','task_history.id')
                            ->where('task_id',$task_id)->where('task_editors.user_id',Auth::user()->id)
                            ->orderBy('task_history.id','desc')
                            ->select(['tasks.status','task_history.*','tasks.id as id'])
                            ->first();
                    $task->task_documents=json_decode($task->task_documents);
                }
                else{
                    $task = Task::find($task_id);
                    $task->task_documents = [];
                }


                // if user submit the form then update the data.
                if($request->isMethod('post') && !empty($task)){
                    if(!empty($tempTask) && $tempTask->status == "awaiting_approval"){
                        return redirect()->back()->withErrors(['unit'=>'You can\'t edit task.'])->withInput();
                    }
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

                    // if user didn't change anything then just redirect to task listing page.
                    $updatedFields= $request->input('changed_items');
                    if(empty($updatedFields)){
                        $request->session()->flash('msg_val', "Task updated successfully!!!");
                        return redirect('tasks');
                    }

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

                    $start_date = '';
                    $end_date = '';
                    try {
                        $start_date  = new \DateTime($request->input('estimated_completion_time_start'));
                        $end_date     = new \DateTime($request->input('estimated_completion_time_end'));
                    } catch (Exception $e) {
                        echo $e->getMessage();
                        exit(1);
                    }
                    $start_date = $start_date->getTimestamp();
                    $end_date  = $end_date->getTimestamp();

                    // update task
                    $slug=substr(str_replace(" ","_",strtolower($request->input('task_name'))),0,20);

                    $task_id_decoded= $task_id;
                    $taskIDHashID= new Hashids('task id hash',10,\Config::get('app.encode_chars'));
                    $task_id = $taskIDHashID->encode($task_id);

                    // upload documents of task.
                    $task_documents = [];
                    if($request->hasFile('documents')) {
                        $files = $request->file('documents');
                        if(count($files) > 0){
                           \DB::enableQueryLog();
                            $totalAvailableDocs = TaskDocuments::where('task_id',$task_id_decoded)->get();
                            $totalAvailableDocs= count($totalAvailableDocs) + 1;
                            foreach($files as $index=>$file){
                                if(!empty($file)){

                                    $rules = ['document' => 'required', 'extension' => 'required|in:doc,docx,pdf,txt,jpg,png,ppt,pptx,jpeg,doc,xls,xlsx'];
                                    $fileData = ['document' => $file, 'extension' => strtolower($file->getClientOriginalExtension())];

                                    // doing the validation, passing post data, rules and the messages
                                    $validator = \Validator::make($fileData, $rules);
                                    if (!$validator->fails()) {
                                        if ($file->isValid()) {
                                            $destinationPath = base_path().'/uploads/tasks/'.$task_id; // upload path
                                            if(!\File::exists($destinationPath)){
                                                $oldumask = umask(0);
                                                @mkdir($destinationPath, 0775); // or even 01777 so you get the sticky bit set
                                                umask($oldumask);
                                            }
                                            $destinationPath=$destinationPath.'/edited_task_docs';
                                            if(!\File::exists($destinationPath)){
                                                $oldumask = umask(0);
                                                @mkdir($destinationPath, 0775); // or even 01777 so you get the sticky bit set
                                                umask($oldumask);
                                            }
                                            $file_name =$file->getClientOriginalName();
                                            $extension = $file->getClientOriginalExtension(); // getting image extension
                                            $fileName = $task_id.'_'.$totalAvailableDocs . '.' . $extension; // renaming image
                                            $file->move($destinationPath, $fileName); // uploading file to given path

                                            $task_documents[]=['task_id'=>$task_id_decoded,'file_name'=>$file_name,
                                                'file_path'=>'uploads/tasks/'.$task_id.'/edited_task_docs/'.$fileName];
                                            $totalAvailableDocs++;
                                        }
                                    }
                                }

                            }
                        }
                    }

                    // if user edited record second time or more than get updatedFields of last edited record and merge with new
                    // updatefields and store into new history. because we will display only updated value to unit admin.

                    $taskHistoryObj = TaskEditor::join('task_history','task_editors.task_history_id','=','task_history.id')
                        ->where('task_editors.user_id',Auth::user()->id)
                        ->where('task_id',$task_id_decoded)
                        ->orderBy('task_history.id','desc')
                        ->first();
                    if(!empty($taskHistoryObj)){
                        $oldUpdatedFields= json_decode($taskHistoryObj->updatedFields);
                        if(!empty($oldUpdatedFields))
                            $updatedFields = array_merge($updatedFields,$oldUpdatedFields );

                    }

                    // add record into task_history for task history.
                    $task_history_id =TaskHistory::create([
                        'unit_id'=>$unit_id[0],
                        'objective_id'=>$objective_id[0],
                        'name'=>$request->input('task_name'),
                        'description'=>$request->input('description'),
                        'summary'=>$request->input('summary'),
                        'skills'=>$request->input('task_skills'),
                        'estimated_completion_time_start'=>date('Y-m-d h:i',$start_date),
                        'estimated_completion_time_end'=>date('Y-m-d h:i',$end_date),
                        'task_action'=>trim($request->input('action_items')),
                        'task_documents'=>json_encode($task_documents),
                        'compensation'=>$request->input('compensation'),
                        'updatedFields'=>json_encode($updatedFields)
                    ])->id;

                    $taskEditorObj = TaskEditor::where('task_id',$task_id_decoded)->where('user_id',Auth::user()->id)->count();
                    if($taskEditorObj > 0){
                        TaskEditor::where('task_id',$task_id_decoded)->where('user_id',Auth::user()->id)->update([
                            'task_history_id'=>$task_history_id
                        ]);
                    }
                    else{
                        TaskEditor::create([
                            'task_id'=>$task_id_decoded,
                            'task_history_id'=>$task_history_id,
                            'user_id'=>Auth::user()->id,
                            'submit_for_approval'=>'not_submitted'
                        ]);
                    }

                    // add activity point for created task.

                    ActivityPoint::create([
                        'user_id'=>Auth::user()->id,
                        'task_id'=>$task_id_decoded,
                        'points'=>2,
                        'comments'=>'Task Updated',
                        'type'=>'task'
                    ]);

                    // add site activity record for global statistics.


                    $userIDHashID= new Hashids('user id hash',10,\Config::get('app.encode_chars'));
                    $user_id = $userIDHashID->encode(Auth::user()->id);

                    SiteActivity::create([
                        'user_id'=>Auth::user()->id,
                        'comment'=>'<a href="'.url('userprofiles/'.$user_id.'/'.strtolower(Auth::user()->first_name.'_'.Auth::user()->last_name)).'">'
                            .Auth::user()->first_name.' '.Auth::user()->last_name
                            .'</a>
                        updated task <a href="'.url('tasks/'.$task_id.'/'.$slug).'">'.$request->input('task_name').'</a>'
                    ]);

                    $request->session()->flash('msg_val', "Task updated successfully!!!");
                    return redirect('tasks');
                }

                $unitsObj = Unit::where('status','active')->lists('name','id');
                $task_skills = JobSkill::lists('skill_name','id');
                $assigned_toUsers = User::where('id','!=',Auth::user()->id)->where('role','!=','superadmin')->get();
                $assigned_toUsers= $assigned_toUsers->lists('full_name','id');
                $taskObj = $task;
                $taskObj->task_action = str_replace(array("\r", "\n"), '', $taskObj->task_action);
                $objectiveObj = Objective::where('unit_id',$taskObj->unit_id)->get();
                $taskDocumentsObj = TaskDocuments::where('task_id',$task_id)->get();
                //$taskActionsObj = TaskAction::where('task_id',$task_id)->get();
                $taskEditor = TaskEditor::where('task_id',$task_id)->where('user_id',Auth::user()->id)->first();
                $otherRemainEditors = TaskEditor::where('task_id',$task_id)
                                    ->where('user_id','!=',Auth::user()->id)->where('submit_for_approval','not_submitted')->get();
                $otherEditorsDone = TaskEditor::where('task_id',$task_id)
                    ->where('user_id','!=',Auth::user()->id)->where('submit_for_approval','submitted')->get();

                $firstUserSubmitted = TaskEditor::where('task_id',$task_id)
                    ->where('user_id','!=',Auth::user()->id)->where('submit_for_approval','submitted')->where('first_user_to_submit','yes')
                    ->first();

                $availableDays ='';
                if(count($firstUserSubmitted) > 0){
                    $submittedDate = strtotime($firstUserSubmitted->updated_at);
                    $availableDays = time() - $submittedDate;
                    $availableDays = 8 - (int)date('d',$availableDays );

                }

                view()->share('objectiveObj',$objectiveObj);
                view()->share('assigned_toUsers',$assigned_toUsers);
                view()->share('task_skills',$task_skills );
                view()->share('unitsObj',$unitsObj);
                view()->share('taskObj',$taskObj);
                view()->share('taskDocumentsObj',$taskDocumentsObj);
                view()->share('taskEditor',$taskEditor);
                view()->share('otherRemainEditors',$otherRemainEditors );
                view()->share('otherEditorsDone',$otherEditorsDone);
                view()->share('availableDays',$availableDays);

                //view()->share('taskActionsObj',$taskActionsObj);
                $taskObj->estimated_completion_time_start = date('Y/m/d h:i',strtotime($taskObj->estimated_completion_time_start));
                $taskObj->estimated_completion_time_end = date('Y/m/d h:i',strtotime($taskObj->estimated_completion_time_end));
                $exploded_task_list = explode(",",$taskObj->skills);
                view()->share('exploded_task_list',$exploded_task_list );
                view()->share('editFlag',true);
                view()->share('actionListFlag',$taskObj->task_action);
                /*if(count($taskDocumentsObj) > 0)
                    view()->share('actionListFlag',true);
                else
                    view()->share('actionListFlag',false);*/
                return view('tasks.create');
            }
        }
    }

    /**
     * soft deleting the document of given task_id
     * @param Request $request
     * @return mixed
     */
    public function remove_task_documents(Request $request){
        $task_id = $request->input('task_id');
        $id = $request->input('id');
        $fromEdit = $request->input('fromEdit');

        $taskIDHashID = new Hashids('task id hash',10,\Config::get('app.encode_chars'));
        $taskDocumentIDHashID = new Hashids('task document id hash',10,\Config::get('app.encode_chars'));

        $task_id = $taskIDHashID->decode($task_id);

        if(empty($task_id)){
            return \Response::json(['success'=>false]);
        }
        $task_id = $task_id[0];

        if($fromEdit  == "yes"){
            $taskHistoryObj = TaskEditor::join('task_history','task_editors.task_history_id','=','task_history.id')
                            ->where('task_id',$task_id)->where('user_id',Auth::user()->id)->orderBy('task_history.id','desc')->first();
            if(!empty($taskHistoryObj)){
                $taskDocuments = json_decode($taskHistoryObj->task_documents);
                if(!empty($taskDocuments)){
                    foreach($taskDocuments as $index=>$document)
                    {
                        if($id == $index){
                            if(file_exists($document->file_path))
                                unlink($document->file_path);
                            unset($taskDocuments[$index]);
                        }
                    }
                    TaskHistory::find($taskHistoryObj->id)->update(['task_documents'=>json_encode($taskDocuments)]);
                    return \Response::json(['success'=>true]);
                }
            }
        }
        else{
            $id = $taskDocumentIDHashID->decode($id);
            if(empty($id)){
                return \Response::json(['success'=>false]);
            }
            $id= $id[0];
            $taskDocumentObj = TaskDocuments::where('task_id',$task_id)->where('id',$id)->get();

            if(count($taskDocumentObj) > 0){
                TaskDocuments::where('task_id',$task_id)->where('id',$id)->delete();
                return \Response::json(['success'=>true]);
            }
        }
        return \Response::json(['success'=>false]);
    }

    /**
     * retrieve objective of selected unit_id
     * @param Request $request
     * @return mixed
     */
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

    /**
     * function is used to display task details.
     * @param $task_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view($task_id){
        if(!empty($task_id)){
            $taskIDHashID = new Hashids('task id hash',10,\Config::get('app.encode_chars'));
            $task_id = $taskIDHashID->decode($task_id);
            if(!empty($task_id)){
                $task_id = $task_id[0];
                $taskObj = Task::with(['objective','task_documents'])->find($task_id);
                $taskObj->unit=[];
                if(!empty($taskObj->objective))
                    $taskObj->unit = Unit::getUnitWithCategories($taskObj->objective->unit_id);
                if(!empty($taskObj)){
                    view()->share('taskObj',$taskObj );
                    return view('tasks.view');
                }
            }
        }
        return view('errors.404');
    }

    /**
     * function will delete the task.
     * @param Request $request
     * @return mixed
     */
    public function delete_task(Request $request)
    {
        // remove task related data from all table. like task_documents and task_actions etc with task deletion
        $task_id = $request->input('id');
        if(!empty($task_id)){
            $taskIDHashID = new Hashids('task id hash',10,\Config::get('app.encode_chars'));
            $task_id = $taskIDHashID->decode($task_id);
            if(!empty($task_id)){
                $task_id = $task_id[0];
                $taskObj = Task::find($task_id);
                if(count($taskObj) > 0){
                    $tasktempObj = $taskObj;

                    // delete task documents, task action and task
                    Task::deleteTask($task_id);

                    // add activity points for task deletion
                    ActivityPoint::create([
                        'user_id'=>Auth::user()->id,
                        'objective_id'=>$task_id,
                        'points'=>1,
                        'comments'=>'Task Deleted',
                        'type'=>'task'
                    ]);

                    // add site activity record for global statistics.
                    $userIDHashID= new Hashids('user id hash',10,\Config::get('app.encode_chars'));
                    $user_id = $userIDHashID->encode(Auth::user()->id);

                    SiteActivity::create([
                        'user_id'=>Auth::user()->id,
                        'comment'=>'<a href="'.url('userprofiles/'.$user_id.'/'.strtolower(Auth::user()->first_name.'_'.Auth::user()->last_name)).'">'
                            .Auth::user()->first_name.' '.Auth::user()->last_name
                            .'</a>
                        deleted task '.$tasktempObj->name
                    ]);
                }
                return \Response::json(['success'=>true]);
            }
        }
        return \Response::json(['success'=>false]);
    }

    /**
     * when user click on Submit for Approval button after edit task.
     * @param Request $request
     * @return mixed
     */
    public function submit_for_approval(Request $request){
        $task_id = $request->input('task_id');
        if(!empty($task_id)){
            $taskIDHashID = new Hashids('task id hash',10,\Config::get('app.encode_chars'));
            $task_id = $taskIDHashID->decode($task_id);
            if(!empty($task_id)){
                $task_id = $task_id[0];
                $taskObj = Task::find($task_id);
                $taskEditor = TaskEditor::where('task_id',$task_id)->where('user_id',Auth::user()->id)->get();
                if(!empty($taskObj) && count($taskEditor) > 0){
                    $otherEditor = TaskEditor::where('task_id',$task_id)->where('user_id','!=',Auth::user()->id)
                                    ->where('submit_for_approval','submitted')->where('first_user_to_submit','yes')->get();

                    $first_user_to_submit ="yes";
                    if(count($otherEditor) > 0)
                        $first_user_to_submit ="no";

                    TaskEditor::where('task_id',$task_id)->where('user_id',Auth::user()->id)->update(['submit_for_approval'=>'submitted',
                        'first_user_to_submit'=>$first_user_to_submit]);

                    $taskEditorObj =  TaskEditor::where('task_id',$task_id)->where('submit_for_approval','not_submitted')->count();
                    if($taskEditorObj == 0){
                        $taskObj = Task::find($task_id);
                        if(!empty($taskObj)){
                            $taskObj->update(['status'=>'awaiting_approval']);
                            return \Response::json(['success'=>true,'status'=>'awaiting_approval']);
                        }
                    }


                    return \Response::json(['success'=>true,'status'=>'']);
                }
            }
        }
        return \Response::json(['success'=>false]);
    }
}
