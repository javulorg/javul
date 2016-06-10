<?php

namespace App\Http\Controllers;

use App\ActivityPoint;
use App\Objective;
use App\SiteActivity;
use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use Hashids\Hashids;

class ObjectivesController extends Controller
{
    public function __construct(){
        $this->middleware('auth',['except'=>['index']]);
    }

    /**
     * Objectives listing
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
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

        // get all objectives for listing
       /* $object = Unit::with(['objectives','tasks'])->get();
        dd($object );*/
        $objectives = Objective::join('units','objectives.unit_id','=','units.id')
                                ->join('users','objectives.user_id','=','users.id')
                                ->select(['objectives.*','units.name as unit_name','users.first_name','users.last_name',
                'users.id as user_id'])->get();
        view()->share('objectives',$objectives );
        return view('objectives.objectives');
    }

    /**
     * create objectives under unit.
     * @param Request $request
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function create(Request $request){
        $unitsObj = Unit::where('status','active')->lists('name','id');
        $parentObjectivesObj = Objective::lists('name','id');
        view()->share('parentObjectivesObj',$parentObjectivesObj);
        view()->share('unitsObj',$unitsObj);
        view()->share('objectiveObj',[]);
        if($request->isMethod('post'))
        {
            $validator = \Validator::make($request->all(), [
                'unit' => 'required',
                'objective_name' => 'required'
            ]);

            if ($validator->fails())
                return redirect()->back()->withErrors($validator)->withInput();

            $status = "in-progress";

            $unitID = $request->input('unit');
            $unitIDHashID = new Hashids('unit id hash',10,\Config::get('app.encode_chars'));
            $unitID = $unitIDHashID->decode($unitID);
            if(empty($unitID))
                return redirect()->back()->withErrors(['unit'=>'Unit doesn\'t exist in database.'])->withInput();
            $unitID = $unitID[0];

            if(Unit::find($unitID)->count() == 0)
                return redirect()->back()->withErrors(['unit'=>'Unit doesn\'t exist in database.'])->withInput();

            // create objective
            $objectiveId = Objective::create([
                'user_id'=>Auth::user()->id,
                'unit_id'=>$unitID,
                'name'=>$request->input('objective_name'),
                'description'=>$request->input('description'),
                'status'=>$status
            ])->id;

            // add activity point for created unit and user.
            ActivityPoint::create([
                'user_id'=>Auth::user()->id,
                'objective_id'=>$objectiveId,
                'points'=>2,
                'comments'=>'Objective Created',
                'type'=>'objective'
            ]);

            // add site activity record for global statistics.
            $userIDHashID= new Hashids('user id hash',10,\Config::get('app.encode_chars'));
            $user_id = $userIDHashID->encode(Auth::user()->id);

            $objectiveIDHashID = new Hashids('objective id hash',10,\Config::get('app.encode_chars'));
            $objectiveId = $objectiveIDHashID->encode($objectiveId);

            SiteActivity::create([
                'user_id'=>Auth::user()->id,
                'comment'=>'<a href="'.url('users/'.$user_id).'">'.Auth::user()->first_name.' '.Auth::user()->last_name.'</a>
                        created objective <a href="'.url('objectives/'.$objectiveId).'">'.$request->input('objective_name').'</a>'
            ]);

            $request->session()->flash('msg_val', "Objective created successfully!!!");
            return redirect('objectives');

        }
        return view('objectives.create');
    }

    /**
     * Update objectives
     * @param $objective_id
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($objective_id,Request $request){
        if(!empty($objective_id)){
            $objectiveIDHashID = new Hashids('objective id hash',10,\Config::get('app.encode_chars'));
            $objective_id = $objectiveIDHashID->decode($objective_id);
            if(!empty($objective_id)){
                $objective_id = $objective_id[0];
                $objectiveObj = Objective::find($objective_id);

                //update data of objective
                if(!empty($objectiveObj) && $request->isMethod('post')){
                    $validator = \Validator::make($request->all(), [
                        'unit' => 'required',
                        'objective_name' => 'required'
                    ]);

                    if ($validator->fails())
                        return redirect()->back()->withErrors($validator)->withInput();

                    $unitID = $request->input('unit');
                    $unitIDHashID = new Hashids('unit id hash',10,\Config::get('app.encode_chars'));
                    $unitID = $unitIDHashID->decode($unitID);
                    if(empty($unitID))
                        return redirect()->back()->withErrors(['unit'=>'Unit doesn\'t exist in database.'])->withInput();
                    $unitID = $unitID[0];

                    if(Unit::find($unitID)->count() == 0)
                        return redirect()->back()->withErrors(['unit'=>'Unit doesn\'t exist in database.'])->withInput();

                    // create objective
                    if(Objective::where('id',$objective_id)->count() > 0){
                        Objective::where('id',$objective_id)->update([
                            'user_id'=>Auth::user()->id,
                            'unit_id'=>$unitID,
                            'name'=>$request->input('objective_name'),
                            'description'=>$request->input('description'),
                        ]);
                    }

                    // add activity point for created unit and user.
                    ActivityPoint::create([
                        'user_id'=>Auth::user()->id,
                        'objective_id'=>$objective_id,
                        'points'=>1,
                        'comments'=>'Objective updated',
                        'type'=>'objective'
                    ]);

                    // add site activity record for global statistics.
                    $userIDHashID= new Hashids('user id hash',10,\Config::get('app.encode_chars'));
                    $user_id = $userIDHashID->encode(Auth::user()->id);

                    $objectiveIDHashID = new Hashids('objective id hash',10,\Config::get('app.encode_chars'));
                    $objectiveId = $objectiveIDHashID->encode($objective_id);

                    SiteActivity::create([
                        'user_id'=>Auth::user()->id,
                        'comment'=>'<a href="'.url('users/'.$user_id).'">'.Auth::user()->first_name.' '.Auth::user()->last_name.'</a>
                        updated objective <a href="'.url('objectives/'.$objectiveId).'">'.$request->input('objective_name').'</a>'
                    ]);

                    $request->session()->flash('msg_val', "Objective updated successfully!!!");
                    return redirect('objectives');

                }
                elseif(!empty($objectiveObj)){
                    //display update page to user
                    view()->share('objectiveObj',$objectiveObj);
                    $unitsObj = Unit::where('status','active')->lists('name','id');
                    $parentObjectivesObj = Objective::where('id','!=',$objective_id)->lists('name','id');
                    view()->share('parentObjectivesObj',$parentObjectivesObj);
                    view()->share('unitsObj',$unitsObj);
                    return view('objectives.create');
                }
            }
        }
        return view('errors.404');
    }

    public function view($objective_id){
        if(!empty($objective_id)){

            $objectiveIDHashID = new Hashids('objective id hash',10,\Config::get('app.encode_chars'));
            $objective_id = $objectiveIDHashID->decode($objective_id);
            if(!empty($objective_id)){
                $objective_id = $objective_id[0];
                $objectiveObj = Objective::with(['unit','tasks'])->where('id',$objective_id)->first();
                if(!empty($objectiveObj)){
                    view()->share('objectiveObj',$objectiveObj);
                    return view('objectives.view');
                }
            }
        }
        return view('errors.404');

    }
}
