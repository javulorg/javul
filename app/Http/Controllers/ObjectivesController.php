<?php

namespace App\Http\Controllers;

use App\Models\ActivityPoint;
use App\Models\Fund;
use App\Models\ImportanceLevel;
use App\Models\Objective;
use App\Models\SiteActivity;
use App\Models\Task;
use App\Models\Unit;
use App\Models\User;
use App\Services\Objectives\ObjectiveService;
use App\Traits\UnitTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Hashids\Hashids;
use App\Models\Forum;
use App\Models\ObjectiveRevision;
use Carbon\Carbon;
use App\Models\UserMessages;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ObjectivesController extends Controller
{
    use UnitTrait;
    public $user_messages;

    public function __construct()
    {
        $this->middleware('auth',['except'=>['index','view','get_objectives_paginate','lists']]);
        $this->user_messages = new UserMessages();
    }

    public function index(Request $request)
    {
        $msg_flag = false;
        $msg_val = '';
        $msg_type = '';
        if($request->session()->has('msg_val'))
        {
            $msg_val =  $request->session()->get('msg_val');
            $request->session()->forget('msg_val');
            $msg_flag = true;
            $msg_type = "success";
        }
        view()->share('msg_flag',$msg_flag);
        view()->share('msg_val',$msg_val);
        view()->share('msg_type',$msg_type);

        $objectives = Objective::query();
        $objectivesTotal = 0;
        if(isset($request->unit))
        {
            $objectivesTotal = $objectives->where('unit_id', $request->unit)->get()->count();
            $unit = Unit::getUnitWithCategories( $request->unit);
            $unitData = Unit::where('id', $request->unit)->first();
            $availableFunds = Fund::getUnitDonatedFund($request->unit);
            $awardedFunds = Fund::getUnitAwardedFund($request->unit);

            $issueResolutions = $this->calculateIssueResolution($request->unit);

            view()->share('totalIssueResolutions',$issueResolutions);
            view()->share('availableFunds',$availableFunds );
            view()->share('awardedFunds',$awardedFunds );
            view()->share('unitData',$unitData);
            view()->share('unitObj',$unitData);
            $unitObjectives = Objective::query()
                ->with('unit')
                ->where('unit_id', $request->unit)
                ->orderByDesc('id')
                ->get();
            view()->share('unitObjectives',$unitObjectives);
        }

        $objectivesTotal = $objectives->get()->count();
        $homeCheck = isset($request->home) ??  false;
        return view('objectives.index', compact('homeCheck','objectivesTotal'));
    }

    public function show($objectiveId)
    {

    }

    public function create(Request $request)
    {
        $segments = $request->segments();
        $unit_id=null;
        $unitInfo = [];
        $availableUnitFunds = '';
        $awardedUnitFunds  = '';
        if(count($segments) == 3)
        {
            $unit_id=$request->segment(2);
            if(empty($unit_id) && count($segments) == 3)
                return view('errors.404');
            $unitIDHashID = new Hashids('unit id hash',10,Config::get('app.encode_chars'));
            $unit_id = $unitIDHashID->decode($unit_id);

            if(empty($unit_id))
                return view('errors.404');

            $unit_id = $unit_id[0];
            $unitInfo = Unit::find($unit_id);
            $availableUnitFunds = Fund::getUnitDonatedFund($unit_id);
            $awardedUnitFunds   = Fund::getUnitAwardedFund($unit_id);

        }

        view()->share('availableUnitFunds',$availableUnitFunds);
        view()->share('awardedUnitFunds',$awardedUnitFunds);

        $unitsObj = Unit::where('status','active')->pluck('name','id');
        $parentObjectivesObj = Objective::pluck('name','id');

        view()->share('parentObjectivesObj',$parentObjectivesObj);
        view()->share('unitsObj',$unitsObj);

        view()->share('objectiveObj',[]);
        view()->share('objectives_unit_id',$unit_id );
        view()->share('unit_activity_id',$unit_id );
        view()->share('unitInfo',$unitInfo);

        $issueResolutions = $this->calculateIssueResolution($unit_id);

        view()->share('totalIssueResolutions',$issueResolutions);


        $homeCheck = isset($request->home) ??  false;
        $unitData = Unit::where('id', $unit_id)->first();
        view()->share('unitData',$unitData);
        view()->share('unitObj',$unitData);
        view()->share('homeCheck',$homeCheck );
        view()->share('availableFunds',$availableUnitFunds );
        view()->share('awardedFunds',$awardedUnitFunds );
        return view('objectives.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'objective_name'  => 'required',
        ]);
        if ($validator->fails())
            return redirect()->back()->withErrors($validator)->withInput();

        $unitID = $request->unit;
        $unitIDEncoded = $unitID;
        $unitIDHashID = new Hashids('unit id hash',10,Config::get('app.encode_chars'));
        $unitID = $unitIDHashID->decode($unitID);

        if(empty($unitID))
            return redirect()->back()->withErrors(['unit'=>'Unit doesn\'t exist in database.'])->withInput();
        $unitID = $unitID[0];

        if(Unit::find($unitID)->count() == 0)
            return redirect()->back()->withErrors(['unit'=>'Unit doesn\'t exist in database.'])->withInput();

        $parent_id = $request->input('parent_objective');

        if(!empty($parent_id))
        {
            $objectiveIDHashID = new Hashids('objective id hash',10,Config::get('app.encode_chars'));
            $parent_id = $objectiveIDHashID->decode($parent_id);
            if(!empty($parent_id))
                $parent_id=$parent_id[0];
            else
                $parent_id =null;
        }
        else
            $parent_id = null;
        $slug = substr(str_replace(" ","_",strtolower($request->input('objective_name'))),0,20);

        $objective = Objective::create([
            'user_id'       => Auth::user()->id,
            'unit_id'       => $unitID,
            'name'          => $request->objective_name,
            'slug'          => $slug,
            'description'   => $request->description,
            'status'        => 'new',
            'parent_id'     => $parent_id,
            'comment'       => $request->comment
        ]);
        $unitObj = Unit::find($unitID);

        ImportanceLevel::create([
            'user_id'             => Auth::user()->id,
            'objective_id'        => $objective->id,
            'importance_level'    =>'+1',
            'type'                =>'Objective'
        ]);

        ActivityPoint::create([
            'user_id'          => Auth::user()->id,
            'objective_id'     => $objective->id,
            'points'           => 2,
            'comments'         => 'Objective Created',
            'type'             => 'objective'
        ]);

        $userIDHashID= new Hashids('user id hash',10,Config::get('app.encode_chars'));
        $user_id = $userIDHashID->encode(Auth::user()->id);

        $objectiveIDHashID = new Hashids('objective id hash',10,Config::get('app.encode_chars'));
        $objectiveId = $objectiveIDHashID->encode($objective->id);

        $userName = Auth::user()->first_name.' '.Auth::user()->last_name;
        if(!empty(Auth::user()->username))
            $userName = Auth::user()->username;

        // send alert to user(s) who has this unit in his/her watchlist
        $watchlistUserObjective = DB::table('my_watchlist')
            ->join('users','my_watchlist.user_id','=','users.id')
            ->where('my_watchlist.user_id','!=',Auth::user()->id)
            ->where('unit_id',$unitID)
            ->get();

        $content = 'User <a href="'.url('userprofiles/'.Auth::user()->id.'/'.strtolower(Auth::user()->first_name.'_'.Auth::user()->last_name)).'">'.strtolower(Auth::user()->first_name.'_'.Auth::user()->last_name).'</a>' .
            ' created Objective <a href="'.url('objectives/'.$objectiveId.'/'.$slug).'">'.$request->input('objective_name').'</a> in Unit <a href="'.url('units/'.$unitIDEncoded.'/'.$unitObj->slug).'">'.$unitObj->name.'</a>';

        $email_subject  ='User '.Auth::user()->first_name.' '.Auth::user()->last_name.' created Objective '.$request->input('objective_name').' in Unit '.$unitObj->name;
        User::SendEmailAndOnSiteAlert($content,$email_subject,$watchlistUserObjective,$onlyemail=false,'watched_items');

        SiteActivity::create([
            'user_id'       => Auth::user()->id,
            'unit_id'       => $unitID,
            'objective_id'  => $objective->id,
            'comment'       => '<a href="'.url('userprofiles/'.$user_id.'/'.strtolower(Auth::user()->first_name.'_'.Auth::user()->last_name)).'">'
                .$userName.'</a>
                        created objective <a href="'.url('objectives/'.$objectiveId.'/'.$slug).'">'.$request->input('objective_name').'</a>'
        ]);

        return redirect()->to('units/'.$request->unit.'/'.$unitObj->slug);
    }


    public function diff($objective_id,$rev1,$rev2,Request $request)
    {
        if(!empty($objective_id))
        {
            view()->share("objective_id",$objective_id);

            $objectiveIDHashID = new Hashids('objective id hash',10,Config::get('app.encode_chars'));
            $objective_id = $objectiveIDHashID->decode($objective_id);
            if(!empty($objective_id))
            {
                $objective_id = $objective_id[0];
                $obj = Objective::checkObjectiveExist($objective_id,false);
                if($obj){
                    $objectiveObj = Objective::where('id',$objective_id)->first();
                    $objectiveObj->tasks = Task::where('objective_id',$objective_id)->orderBy('id','desc')->paginate(Config::get('app.page_limit'));
                    $objectiveObj->unit = Unit::getUnitWithCategories($objectiveObj->unit_id);
                    $upvotedCnt = ImportanceLevel::where('objective_id',$objective_id)->where('importance_level','+1')->count();
                    $downvotedCnt = ImportanceLevel::where('objective_id',$objective_id)->where('importance_level','-1')->count();

                    if($upvotedCnt == 0 && $downvotedCnt == 0)
                        $importancePercentage = 0;
                    else
                    {
                        $importancePercentage =  ($upvotedCnt * 100) / ($upvotedCnt + $downvotedCnt);
                    }

                    if(is_float($importancePercentage)) $importancePercentage = ceil($importancePercentage);

                    view()->share('upvotedCnt',$upvotedCnt);
                    view()->share('downvotedCnt',$downvotedCnt);
                    view()->share('importancePercentage',$importancePercentage);
                    if(!empty($objectiveObj))
                    {
                        view()->share('objectiveObj',$objectiveObj);

                        $availableUnitFunds =Fund::getUnitDonatedFund($objectiveObj->unit_id);
                        $awardedUnitFunds =Fund::getUnitAwardedFund($objectiveObj->unit_id);

                        view()->share('availableUnitFunds',$availableUnitFunds );
                        view()->share('awardedUnitFunds',$awardedUnitFunds );

                        view()->share("unit_id", $objectiveObj->unit_id);
                        view()->share("section_id", 1);
                        view()->share("object_id",$objectiveObj->id);

                        $site_activity = SiteActivity::where('unit_id',$objectiveObj->unit->id)->orderBy('id','desc')->paginate(Config::get('app.site_activity_page_limit'));
                        view()->share('site_activity',$site_activity);
                        view()->share('unit_activity_id',$objectiveObj->unit->id);

                        $revisions = ObjectiveRevision::select(['objective_revisions.user_id','objective_revisions.description','objective_revisions.id','objective_revisions.unit_id','objective_revisions.comment','objective_revisions.size','objective_revisions.created_at','users.first_name','users.last_name',])
                            ->join('users', 'users.id', '=', 'objective_revisions.user_id')
                            ->where("objective_revisions.unit_id","=",$objectiveObj->unit_id)
                            ->whereIn("objective_revisions.id",[ (int)$rev1, (int)$rev2 ])
                            ->get();


                        if($revisions->count() == 2)
                        {
                            $userIDHashID= new Hashids('user id hash',10,Config::get('app.encode_chars'));

                            view()->share('userIDHashID', $userIDHashID);
                            view()->share('Carbon', new Carbon);
                            view()->share('revisions',$revisions );


                            $unitData = Unit::where('id', $objectiveObj->unit_id)->first();
                            $availableFunds = Fund::getUnitDonatedFund($objectiveObj->unit_id);
                            $awardedFunds = Fund::getUnitAwardedFund($objectiveObj->unit_id);

                            view()->share('availableFunds',$availableFunds);
                            view()->share('awardedFunds',$awardedFunds);
                            view()->share('unitData',$unitData);
                            view()->share('unitObj',$unitData);
                            return view("objectives.revison.changes_difference");
                        }

                    }
                }
            }
        }


        return view('errors.404');
    }

    public function revison($objective_id,Request $request)
    {

        if(!empty($objective_id)){
            view()->share("objective_id",$objective_id);

            $objectiveIDHashID = new Hashids('objective id hash',10,Config::get('app.encode_chars'));
            $objective_id = $objectiveIDHashID->decode($objective_id);
            if(!empty($objective_id)){
                $objective_id = $objective_id[0];
                $obj = Objective::checkObjectiveExist($objective_id,false);
                if($obj){
                    $objectiveObj = Objective::where('id',$objective_id)->first();
                    $objectiveObj->tasks = Task::where('objective_id',$objective_id)->orderBy('id','desc')->paginate(Config::get('app.page_limit'));
                    $objectiveObj->unit = Unit::getUnitWithCategories($objectiveObj->unit_id);
                    $upvotedCnt = ImportanceLevel::where('objective_id',$objective_id)->where('importance_level','+1')->count();
                    $downvotedCnt = ImportanceLevel::where('objective_id',$objective_id)->where('importance_level','-1')->count();

                    if($upvotedCnt == 0 && $downvotedCnt == 0)
                        $importancePercentage = 0;
                    else{

                        $importancePercentage =  ($upvotedCnt * 100) / ($upvotedCnt + $downvotedCnt);
                    }

                    if(is_float($importancePercentage)) $importancePercentage = ceil($importancePercentage);

                    view()->share('upvotedCnt',$upvotedCnt);
                    view()->share('downvotedCnt',$downvotedCnt);
                    view()->share('importancePercentage',$importancePercentage);
                    if(!empty($objectiveObj)){
                        view()->share('objectiveObj',$objectiveObj);

                        $availableUnitFunds =Fund::getUnitDonatedFund($objectiveObj->unit_id);
                        $awardedUnitFunds =Fund::getUnitAwardedFund($objectiveObj->unit_id);

                        view()->share('availableUnitFunds',$availableUnitFunds );
                        view()->share('awardedUnitFunds',$awardedUnitFunds );


                        $revisions = ObjectiveRevision::select(['objective_revisions.user_id','objective_revisions.id','objective_revisions.unit_id','objective_revisions.comment','objective_revisions.size','objective_revisions.created_at','users.first_name','users.last_name',])
                            ->join('users', 'users.id', '=', 'objective_revisions.user_id')
                            ->where("objective_revisions.unit_id","=",$objectiveObj->unit_id)
                            ->where("objective_revisions.objective_id","=",$objectiveObj->id)
                            ->get();

                        $userIDHashID= new Hashids('user id hash',10,Config::get('app.encode_chars'));

                        view()->share('userIDHashID', $userIDHashID);
                        view()->share('Carbon', new Carbon);
                        view()->share('revisions',$revisions );
                        view()->share("unit_id", $objectiveObj->unit_id);
                        view()->share("section_id", 1);
                        view()->share("object_id",$objectiveObj->id);

                        $site_activity = SiteActivity::where('unit_id',$objectiveObj->unit->id)->orderBy('id','desc')->paginate(Config::get('app.site_activity_page_limit'));
                        view()->share('site_activity',$site_activity);
                        view()->share('unit_activity_id',$objectiveObj->unit->id);


                        $unitData = Unit::where('id', $objectiveObj->unit->id)->first();
                        $availableFunds = Fund::getUnitDonatedFund($objectiveObj->unit->id);
                        $awardedFunds = Fund::getUnitAwardedFund($objectiveObj->unit->id);

                        $issueResolutions = $this->calculateIssueResolution($objectiveObj->unit->id);

                        view()->share('totalIssueResolutions',$issueResolutions);
                        view()->share('availableFunds',$availableFunds );
                        view()->share('awardedFunds',$awardedFunds );
                        view()->share('unitData',$unitData);
                        view()->share('unitObj',$unitData);
                        return view('objectives.revison.view');
                    }
                }
            }
        }
        return view('errors.404');
    }

    public function revisonview($objective_id,$revision_id,Request $request)
    {
        if(!empty($objective_id))
        {
            view()->share("objective_id",$objective_id);
            $objectiveIDHashID = new Hashids('objective id hash',10,Config::get('app.encode_chars'));
             $objective_id = $objectiveIDHashID->decode($objective_id);

            if(!empty($objective_id))
            {
                $objective_id = $objective_id[0];
                $obj = Objective::checkObjectiveExist($objective_id,false);
                if($obj)
                {
                    $objectiveObj = Objective::where('id',$objective_id)->first();
                    $objectiveObj->tasks = Task::where('objective_id',$objective_id)->orderBy('id','desc')->paginate(Config::get('app.page_limit'));
                    $objectiveObj->unit = Unit::getUnitWithCategories($objectiveObj->unit_id);
                    $upvotedCnt = ImportanceLevel::where('objective_id',$objective_id)->where('importance_level','+1')->count();
                    $downvotedCnt = ImportanceLevel::where('objective_id',$objective_id)->where('importance_level','-1')->count();

                    if($upvotedCnt == 0 && $downvotedCnt == 0)
                        $importancePercentage = 0;
                    else
                    {
                        $importancePercentage =  ($upvotedCnt * 100) / ($upvotedCnt + $downvotedCnt);
                    }

                    if(is_float($importancePercentage)) $importancePercentage = ceil($importancePercentage);

                    view()->share('upvotedCnt',$upvotedCnt);
                    view()->share('downvotedCnt',$downvotedCnt);
                    view()->share('importancePercentage',$importancePercentage);

                    if(!empty($objectiveObj))
                    {
                        view()->share('objectiveObj',$objectiveObj);

                        $availableUnitFunds =Fund::getUnitDonatedFund($objectiveObj->unit_id);
                        $awardedUnitFunds =Fund::getUnitAwardedFund($objectiveObj->unit_id);

                        $issueResolutions = $this->calculateIssueResolution($objectiveObj->unit_id);

                        view()->share('totalIssueResolutions',$issueResolutions);
                        view()->share('availableUnitFunds',$availableUnitFunds );
                        view()->share('awardedUnitFunds',$awardedUnitFunds );


                        $revisions = ObjectiveRevision::select(['objective_revisions.user_id','objective_revisions.description','objective_revisions.id','objective_revisions.unit_id','objective_revisions.comment','objective_revisions.size','objective_revisions.created_at','users.first_name','users.last_name',])
                            ->join('users', 'users.id', '=', 'objective_revisions.user_id')
                            ->where("objective_revisions.unit_id","=",$objectiveObj->unit_id)
                            ->where("objective_revisions.objective_id","=",$objectiveObj->id)
                            ->where("objective_revisions.id","=",$revision_id)
                            ->get();

                        if($revisions->count() == 1)
                        {
                            $userIDHashID= new Hashids('user id hash',10,Config::get('app.encode_chars'));
                            $unitIDHashID = new Hashids('unit id hash',10,Config::get('app.encode_chars'));
                            view()->share('unit_id_hash', $unitIDHashID->encode($objectiveObj->unit_id) );

                            view()->share('userIDHashID', $userIDHashID);
                            view()->share('Carbon', new Carbon);
                            view()->share('revisions',$revisions->first() );

                            view()->share("unit_id", $objectiveObj->unit_id);
                            view()->share("section_id", 1);
                            view()->share("object_id",$objectiveObj->id);

                            $site_activity = SiteActivity::where('unit_id',$objectiveObj->unit->id)->orderBy('id','desc')->paginate(Config::get('app.site_activity_page_limit'));
                            view()->share('site_activity',$site_activity);
                            view()->share('unit_activity_id',$objectiveObj->unit->id);


                            $unitData = Unit::where('id', $objectiveObj->unit->id)->first();
                            $availableFunds = Fund::getUnitDonatedFund($objectiveObj->unit->id);
                            $awardedFunds = Fund::getUnitAwardedFund($objectiveObj->unit->id);
                            view()->share('availableFunds',$availableFunds);
                            view()->share('awardedFunds',$awardedFunds);
                            view()->share('unitData',$unitData);
                            view()->share('unitObj',$unitData);
                            return view('objectives.revison.view_revision');
                        }
                    }
                }
            }
        }
        return view('errors.404');
    }


    public function edit($objective_id,Request $request)
    {
        $objectiveHashId = $objective_id;
        if(!empty($objective_id))
        {
            $objectiveIDHashID = new Hashids('objective id hash',10,Config::get('app.encode_chars'));
            $objective_id = $objectiveIDHashID->decode($objective_id);
            if(!empty($objective_id))
            {
                $objective_id = $objective_id[0];
                $objectiveObj = Objective::find($objective_id);

                //update data of objective

               if(!empty($objectiveObj))
                {
                    //display update page to user
                    view()->share('objectiveObj',$objectiveObj);
                    $unitsObj = Unit::where('status','active')->pluck('name','id');
                    $parentObjectivesObj = Objective::where('id','!=',$objective_id)->pluck('name','id');
                    view()->share('parentObjectivesObj',$parentObjectivesObj);
                    view()->share('unitsObj',$unitsObj);
                    $availableUnitFunds =Fund::getUnitDonatedFund($objectiveObj->unit->id);
                    $awardedUnitFunds =Fund::getUnitAwardedFund($objectiveObj->unit->id);

                    view()->share('availableUnitFunds',$availableUnitFunds);
                    view()->share('awardedUnitFunds',$awardedUnitFunds);
                    view()->share('unit_activity_id',$objectiveObj->unit->id);
                    view()->share('objectiveId', $objectiveHashId);



                    $unitData = Unit::where('id', $objectiveObj->unit->id)->first();
                    $availableFunds = Fund::getUnitDonatedFund($objectiveObj->unit->id);
                    $awardedFunds = Fund::getUnitAwardedFund($objectiveObj->unit->id);

                    $issueResolutions = $this->calculateIssueResolution($objectiveObj->unit->id);

                    view()->share('totalIssueResolutions',$issueResolutions);

                    view()->share('availableFunds',$availableFunds);
                    view()->share('awardedFunds',$awardedFunds);
                    view()->share('unitData',$unitData);
                    view()->share('unitObj',$unitData);
                    return view('objectives.edit');
                }
            }
        }
        return view('errors.404');
    }

    public function update(Request $request, $objectiveHashId)
    {
        $objectiveIDHashID = new Hashids('objective id hash',10,Config::get('app.encode_chars'));
        $objectiveId = $objectiveIDHashID->decode($objectiveHashId);
        $objectiveObj = Objective::find($objectiveId[0]);
        $validator = Validator::make($request->all(), [
            'unit'              => 'required',
            'objective_name'    => 'required'
        ]);

        if ($validator->fails())
            return redirect()->back()->withErrors($validator)->withInput();
        $unitID = $request->unit;


        $unitIDEncoded = $unitID;
        $unitIDHashID = new Hashids('unit id hash',10,Config::get('app.encode_chars'));
        $unitID = $unitIDHashID->decode($unitID);

        if(empty($unitID))
            return redirect()->back()->withErrors(['unit'=>'Unit doesn\'t exist in database.'])->withInput();
        $unitID = $unitID[0];

        if(Unit::find($unitID)->count() == 0)
            return redirect()->back()->withErrors(['unit'=>'Unit doesn\'t exist in database.'])->withInput();

        $slug = substr(str_replace(" ","_",strtolower($request->input('objective_name'))),0,20);
        $parent_id = $request->parent_objective;

        if(!empty($parent_id))
        {
            $parent_id = $objectiveIDHashID->decode($parent_id);
            if(!empty($parent_id))
                $parent_id = $parent_id[0];
        }

        if(Objective::where('id',$objectiveId[0])->count() > 0)
        {
            $bytes    = ObjectiveRevision::strBytes( str_replace(' ', '', strip_tags($request->input('description'))));
            $oldBytes = ObjectiveRevision::strBytes( str_replace(' ', '', strip_tags($objectiveObj->description)));

            $ObjectiveRevision                = new ObjectiveRevision();
            $ObjectiveRevision->unit_id       = $objectiveObj->unit_id;
            $ObjectiveRevision->user_id       = $objectiveObj->user_id;
            $ObjectiveRevision->description   = $objectiveObj->description;
            $ObjectiveRevision->objective_id  = $objectiveObj->id;
            $ObjectiveRevision->parent_id     = (int)$objectiveObj->parent_id ;
            $ObjectiveRevision->comment       = $objectiveObj->comment." ";
            $ObjectiveRevision->modified_by   = Auth::user()->id;
            $ObjectiveRevision->size          = (  $bytes - $oldBytes );
            $ObjectiveRevision->created_at    = date("Y-m-d H:i:s");
            $ObjectiveRevision->save();

            Objective::where('id',$objectiveObj->id)->update([
                'user_id'        => Auth::user()->id,
                'unit_id'        => $unitID,
                'name'           => $request->objective_name,
                'comment'        => $request->comment,
                'slug'           => $slug,
                'status'         => $request->status,
                'description'    => $request->description,
                'parent_id'      => $parent_id
            ]);

            ActivityPoint::create([
                'user_id'         => Auth::user()->id,
                'objective_id'    => $objectiveObj->id,
                'points'          => 1,
                'comments'        => 'Objective updated',
                'type'            => 'objective'
            ]);

            $userIDHashID = new Hashids('user id hash',10, Config::get('app.encode_chars'));
            $user_id = $userIDHashID->encode(Auth::user()->id);

            $userName = Auth::user()->first_name.' '.Auth::user()->last_name;
            if(!empty(Auth::user()->username))
                $userName = Auth::user()->username;


            $unitObj = Unit::find($unitID);

            $content = 'User <a href="'.url('userprofiles/'.Auth::user()->id.'/'.strtolower(Auth::user()->first_name.'_'.Auth::user()->last_name)).'">'.strtolower(Auth::user()->first_name.'_'.Auth::user()->last_name).'</a>' .
                ' updated Objective <a href="'.url('objectives/'.$objectiveHashId.'/'.$slug).'">'.$request->input('objective_name')
                .'</a> in Unit <a href="'.url('units/'.$unitIDEncoded.'/'.$unitObj->slug).'">'.$unitObj->name.'</a>';


            SiteActivity::create([
                'user_id'        => Auth::user()->id,
                'unit_id'        => $unitID,
                'objective_id'   => $objectiveObj->id,
                'comment'=>'<a href="'.url('userprofiles/'.$user_id.'/'.strtolower(Auth::user()->first_name.'_'.Auth::user()->last_name)).'">'
                    .$userName.'</a>
                        updated objective <a href="'.url('objectives/'.$objectiveHashId.'/'.$slug).'">'.$request->objective_name.'</a>'
            ]);

            return redirect('objectives/'.$objectiveHashId.'/'.$objectiveObj->slug);

        }

    }

    public function view($objective_id, Request $request)
    {
        $objectiveHashID = $objective_id;
        $service = new ObjectiveService();
        if(!empty($objective_id))
        {
            $objectiveIDHashID = new Hashids('objective id hash',10,Config::get('app.encode_chars'));
            $objective_id = $objectiveIDHashID->decode($objective_id);
            if(!empty($objective_id))
            {
                $objective_id = $objective_id[0];
                $obj = Objective::checkObjectiveExist($objective_id,false);
                if($obj)
                {
                    $objectiveObj = Objective::where('id',$objective_id)->first();
                    $objectiveObj->tasks = Task::where('objective_id',$objective_id)->orderBy('id','desc')->paginate(Config::get('app.page_limit'));
                    $objectiveObj->unit = Unit::getUnitWithCategories($objectiveObj->unit_id);
                    $upvotedCnt = 0;
                    $downvotedCnt = 0;
                    if(Auth::check())
                    {
                        $upvotedCnt = ImportanceLevel::where('objective_id', $objective_id)->where('user_id', Auth::user()->id)->where('importance_level', '+1')->count();
                        $downvotedCnt = ImportanceLevel::where('objective_id', $objective_id)->where('user_id', Auth::user()->id)->where('importance_level', '-1')->count();
                    }

                    if($upvotedCnt == 0 && $downvotedCnt == 0)
                        $importancePercentage = 0;
                    else{
                        $importancePercentage =  ($upvotedCnt * 100) / ($upvotedCnt + $downvotedCnt);
                    }

                    if($importancePercentage != 0 && is_float($importancePercentage))
                        $importancePercentage = ceil($importancePercentage);
                    view()->share('upvotedCnt',$upvotedCnt);
                    view()->share('downvotedCnt',$downvotedCnt);
                    view()->share('importancePercentage',$importancePercentage);
                    if(!empty($objectiveObj))
                    {
                        view()->share('objectiveObj',$objectiveObj);
                        $availableFunds = Fund::getObjectiveDonatedFund($objective_id);
                        $awardedFunds   = Fund::getObjectiveAwardedFund($objective_id);

                        view()->share('availableObjFunds',$availableFunds );
                        view()->share('awardedObjFunds',$awardedFunds );

                        $availableUnitFunds =Fund::getUnitDonatedFund($objectiveObj->unit_id);
                        $awardedUnitFunds =Fund::getUnitAwardedFund($objectiveObj->unit_id);

                        $issueResolutions = $this->calculateIssueResolution($objectiveObj->unit_id);

                        view()->share('totalIssueResolutions',$issueResolutions);
                        view()->share('availableUnitFunds',$availableUnitFunds );
                        view()->share('awardedUnitFunds',$awardedUnitFunds );

                        $site_activity = SiteActivity::where('unit_id',$objectiveObj->unit->id)->orderBy('id','desc')->paginate(Config::get('app.site_activity_page_limit'));
                        view()->share('site_activity',$site_activity);
                        view()->share('unit_activity_id',$objectiveObj->unit->id);


                        // Forum Object coading
                        view()->share("unit_id", $objectiveObj->unit_id);
                        view()->share("section_id", 1);
                        view()->share("object_id",$objectiveObj->id);
                        view()->share("object_hash_id",$objectiveHashID);

                        $forumID =  Forum::checkTopic(array(
                            'unit_id' => $objectiveObj->unit_id,
                            'section_id' => 1,
                            'object_id' => $objectiveObj->id,
                        ));

                        if(!empty($forumID))
                        {
                            view()->share('addComments', url('forum/post/'. $forumID->topic_id .'/'. $forumID->slug ));
                            $comments = $service->comments( $objectiveObj->unit_id, 1, $objectiveObj->id);
                            view()->share('comments', $comments);
                        }
                        $comments = $service->comments( $objectiveObj->unit_id, 1, $objectiveObj->id);
                        view()->share('comments', $comments);

                        $add_wl = session()->get('add_to_wl');
                        if( $add_wl  != null ){
                            $add_to_watchlist = session()->get('add_to_wl');
                            $arr = [];
                            if(is_array($add_to_watchlist) || is_object($add_to_watchlist)){
                                foreach ( $add_to_watchlist as $key => $add){
                                    $arr[$key] = $add;
                                }
                            }
                            session()->put('add_to_wl', 'null');
                            view()->share('add_to_watch',$arr);
                        }


                            $unitData = Unit::where('id', $objectiveObj->unit_id)->first();
                            $availableFunds = Fund::getUnitDonatedFund($objectiveObj->unit_id);
                            $awardedFunds = Fund::getUnitAwardedFund($objectiveObj->unit_id);

                            view()->share('availableFunds',$availableFunds);
                            view()->share('awardedFunds',$awardedFunds);
                            view()->share('unitData',$unitData);
                             view()->share('unitObj',$unitData);

                        return view('objectives.view');
                    }
                }
            }
        }
        return view('errors.404');

    }

    public function add_importance(Request $request)
    {
        $objectiveID = $request->input('id');
        $objectiveIDEndcoded = $objectiveID;
        $type = $request->input('type');
        if(!empty($objectiveID))
        {
            $objectiveIDHashID = new Hashids('objective id hash',10,Config::get('app.encode_chars'));
            $objectiveID = $objectiveIDHashID->decode($objectiveID);
            if(!empty($objectiveID)){
                $objectiveID = $objectiveID[0];
                $objectiveObj = Objective::find($objectiveID);
                if(!empty($objectiveObj)){
                    $importanceLevelObj = ImportanceLevel::where('objective_id',$objectiveID)->where('user_id',Auth::user()->id)->first();

                    $site_activity_text = '';
                    if($type == "up"){
                        $levelValue = "+1";
                        if(count($importanceLevelObj) > 0) {
                            if ($importanceLevelObj->importance_level == '+1')
                                $levelValue = '0';
                            else
                                $levelValue = '+1';

                        }
                        $site_activity_text =" upvote objective ";
                    }
                    else{
                        $levelValue = "-1";
                        if(count($importanceLevelObj) > 0) {
                            if ($importanceLevelObj->importance_level == '-1')
                                $levelValue = '0';
                            else
                                $levelValue = '-1';
                        }
                        $site_activity_text =" downvote objective ";
                    }
                    if(count($importanceLevelObj) > 0)
                        $importanceLevelObj->update(['importance_level'=>$levelValue]);
                    else{
                        ImportanceLevel::create([
                            'user_id'=>Auth::user()->id,
                            'objective_id'=>$objectiveID,
                            'importance_level'=>$levelValue,
                            'type'=>'Objective'
                        ]);
                    }

                    $upvotedCnt = ImportanceLevel::where('objective_id',$objectiveID)->where('user_id',Auth::user()->id)->where('importance_level','+1')->count();
                    $downvotedCnt = ImportanceLevel::where('objective_id',$objectiveID)->where('user_id',Auth::user()->id)->where('importance_level','-1')->count();

                    if($levelValue == '0' || $levelValue == 0)
                        $importancePercentage =0;
                    else
                        $importancePercentage =  ($upvotedCnt * 100) / ($upvotedCnt + $downvotedCnt);

                    if(is_float($importancePercentage))
                        $importancePercentage = ceil($importancePercentage);
                    view()->share('upvotedCnt',$upvotedCnt);
                    view()->share('downvotedCnt',$downvotedCnt);
                    view()->share('importancePercentage',$importancePercentage);

                    $importance_level_html = view('objectives.partials.importance_level',['objective_id'=>$objectiveID])->render();

                    $user_id = Auth::user()->id;
                    $userIDHashID = new Hashids('user id hash',10,Config::get('app.encode_chars'));
                    $user_id_encoded = $userIDHashID->encode($user_id);


                    // add comment : issue : skype text sir (26.07.2016)
                    /*SiteActivity::create([
                        'user_id'=>Auth::user()->id,
                        'comment'=>'<a href="'.url('userprofiles/'.$user_id_encoded.'/'.strtolower(Auth::user()->first_name.'_'.Auth::user()->last_name)).'">'.Auth::user()->first_name.' '.Auth::user()
                                ->last_name
                            .'</a>'.$site_activity_text .' <a href="'.url('objectives/'.$objectiveIDEndcoded.'/'.$objectiveObj->slug) .'">'
                            .$objectiveObj->name
                            .'</a>'
                    ]);*/

                    return response()->json(['success'=>true,'html'=>$importance_level_html]);
                }
            }
        }
        return response()->json(['success'=>false]);

    }

    public function delete_objective(Request $request)
    {
        $objectiveID = $request->input('id');
        if(!empty($objectiveID)){
            $objectiveIDHashID = new Hashids('objective id hash',10,Config::get('app.encode_chars'));
            $objectiveID = $objectiveIDHashID->decode($objectiveID);
            if(!empty($objectiveID)){
                $objectiveID = $objectiveID[0];
                $objectiveObj = Objective::find($objectiveID);
                $objectiveTemp = $objectiveObj;
                if(!empty($objectiveObj)){
                    $tasksObj = Task::where('objective_id',$objectiveID)->get();
                    if(count($tasksObj) > 0){
                        foreach($tasksObj  as $task)
                            Task::deleteTask($task->id);
                    }
                    $objectiveObj->delete();

                    // add activity point for created unit and user.
                    ActivityPoint::create([
                        'user_id'=>Auth::user()->id,
                        'objective_id'=>$objectiveID,
                        'points'=>1,
                        'comments'=>'Objective deleted',
                        'type'=>'objective'
                    ]);

                    // add site activity record for global statistics.
                    $userIDHashID= new Hashids('user id hash',10,Config::get('app.encode_chars'));
                    $user_id = $userIDHashID->encode(Auth::user()->id);

                    /*$objectiveIDHashID = new Hashids('objective id hash',10,Config::get('app.encode_chars'));
                    $objectiveId = $objectiveIDHashID->encode($objectiveID);*/

                    $user_name=Auth::user()->first_name.' '.Auth::user()->last_name;
                    if(!empty(Auth::user()->username))
                        $user_name =Auth::user()->username;

                    SiteActivity::create([
                        'user_id'=>Auth::user()->id,
                        'unit_id'=>$objectiveTemp->unit_id,
                        'objective_id'=>$objectiveID,
                        'comment'=>'<a href="'.url('userprofiles/'.$user_id.'/'.strtolower(Auth::user()->first_name.'_'.Auth::user()->last_name))
                            .'">'.$user_name.'</a>
                        deleted objective '.$objectiveTemp->name
                    ]);

                    // After Created Unit send mail to site admin
                    $siteAdminemails = User::where('role','superadmin')->pluck('email')->all();
                    $unitCreator = User::find(Auth::user()->id);

                    $toEmail = $unitCreator->email;
                    $toName= $unitCreator->first_name.' '.$unitCreator->last_name;
                    $subject="Objective Deleted";

//                    \Mail::send('emails.registration', ['userObj'=> $unitCreator ], function($message) use ($toEmail,$toName,$subject,$siteAdminemails)
//                    {
//                        $message->to($toEmail,$toName)->subject($subject);
//                        if(!empty($siteAdminemails))
//                            $message->bcc($siteAdminemails,"Admin")->subject($subject);
//
//                        $message->from(Config::get("app.notification_email"), Config::get("app.site_name"));
//                    });

                    return response()->json(['success'=>true]);
                }
            }

        }
        return response()->json(['success'=>false]);
    }

    public function pluck(Request $request)
    {
        $unit_id = $request->segment(2);
        if(!empty($unit_id)){
            $unitIDHashID= new Hashids('unit id hash',10,Config::get('app.encode_chars'));
            $unit_id = $unitIDHashID->decode($unit_id);
            if(!empty($unit_id)){
                $unit_id= $unit_id[0];
                $objectiveObj = Objective::where('unit_id',$unit_id)->orderBy('id','desc')->paginate(Config::get('app.page_limit'));
                view()->share('objectiveObj',$objectiveObj);
                $objectiveObj->unit = Unit::getUnitWithCategories($unit_id);


                $site_activity = SiteActivity::where('unit_id',$unit_id)->orderBy('id','desc')->paginate(Config::get('app.site_activity_page_limit'));
                //$taskObj = Task::where('unit_id',$unit_id)->get();
                view()->share('site_activity',$site_activity);
                view()->share('unit_activity_id',$unit_id);
                return view('objectives.partials.list');
            }
        }
        return view('errors.404');
    }

    public function get_objectives_paginate(Request $request)
    {
        $from_page = $request->input('from_page');
        $page_limit = Config::get('app.page_limit');
        $unit_id = $request->input('unit_id');
        $objectives = Objective::orderBy('id','desc');
        if(!empty($unit_id )) {
            $unitIDHashID= new Hashids('unit id hash',10,Config::get('app.encode_chars'));
            $unit_id = $unitIDHashID->decode($unit_id);
            if(!empty($unit_id)) {
                $unit_id = $unit_id[0];
                $objectives =$objectives->where('unit_id',$unit_id);
            }
        }
        $objectives = $objectives->paginate($page_limit);

        view()->share('objectives',$objectives);
        view()->share('from_page',$from_page);
        view()->share('unit_id',$unit_id);
        $html = view('objectives.partials.more_objectives')->render();
        return response()->json(['success'=>true,'html'=>$html]);
    }
}
