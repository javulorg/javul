<?php

namespace App\Http\Controllers;

use App\Models\Fund;
use App\Models\Idea;
use App\Models\Issue;
use App\Models\Task;
use App\Models\Type;
use App\Models\Unit;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;

class IdeaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',['except'=>['index','view']]);
    }

    public function index(Request $request)
    {
        if(isset($request->unit))
        {
            $ideasTotal = Idea::where('unit_id', $request->unit)->get()->count();
            $unitData = Unit::where('id', $request->unit)->first();
            $availableFunds = Fund::getUnitDonatedFund($request->unit);
            $awardedFunds = Fund::getUnitAwardedFund($request->unit);

            view()->share('availableFunds',$availableFunds);
            view()->share('awardedFunds',$awardedFunds);
            view()->share('unitData',$unitData);
            view()->share('ideasTotal',$ideasTotal);

            $unitIdea = Idea::query()
                ->with('unit')
                ->where('unit_id', $request->unit)
                ->orderByDesc('id')
                ->get();
            view()->share('unitIdea',$unitIdea);
        }
        return view('ideas.index');
    }

    public function create($unitId)
    {
        $unitHash = new Hashids('unit id hash',10,Config::get('app.encode_chars'));
        $unitData = Unit::where('id', $unitHash->decode($unitId))->first();
        $types = Type::all();
        $tasks = Task::query()
            ->where('unit_id', $unitData->id)
            ->get();

        $issues = Issue::query()
            ->where('unit_id', $unitData->id)
            ->get();

        $homeCheck = isset($request->home) ??  false;
        $availableUnitFunds = Fund::getUnitDonatedFund($unitHash->decode($unitId));
        $awardedUnitFunds   = Fund::getUnitAwardedFund($unitHash->decode($unitId));
        view()->share('unitData',$unitData);
        view()->share('homeCheck',$homeCheck);
        view()->share('availableFunds',$availableUnitFunds);
        view()->share('awardedFunds',$awardedUnitFunds);
        view()->share('unitHashId', $unitId);
        view()->share('types', $types);
        view()->share('tasks', $tasks);
        view()->share('issues', $issues);
        return view('ideas.create');
    }

    public function store(Request $request)
    {
        $unitHash = new Hashids('unit id hash',10,Config::get('app.encode_chars'));

        $unit = Unit::where('id', $request->unit_id)->first();
        $validator = Validator::make($request->all(),[
           'title'        => 'required',
           'type_id'      => 'nullable',
           'task_id'      => 'nullable',
           'issue_id'     => 'nullable',
           'description'  => 'required',
           'comment'      => 'required',
           'file'         => 'nullable',
        ]);
        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $idea = Idea::create([
           'title'          => $request->title,
           'user_id'        => auth()->user()->id,
           'unit_id'        => $request->unit_id,
           'task_id'        => $request->task_id,
           'issue_id'       => $request->issue_id,
           'type_id'        => $request->type_id,
           'description'    => $request->description,
           'comment'        => $request->comment,
           'status'         => 1,
        ]);
        if($idea)
        {
            return redirect('units/'. $unitHash->encode($request->unit_id) . '/' . $unit->slug);
        }
    }

    public function show($ideaHashId)
    {
        $hash = new Hashids('idea id hash',10,Config::get('app.encode_chars'));
        $ideaId = $hash->decode($ideaHashId);
        $idea = Idea::findOrFail($ideaId[0]);



        $unitData = Unit::where('id', $idea->unit_id)->first();
        $availableFunds = Fund::getUnitDonatedFund($idea->unit_id);
        $awardedFunds = Fund::getUnitAwardedFund($idea->unit_id);

        view()->share('availableFunds',$availableFunds);
        view()->share('awardedFunds',$awardedFunds);
        view()->share('unitData',$unitData);
        view()->share('idea',$idea);
        view()->share('ideaHashId',$ideaHashId);


        return view('ideas.show');
    }

    public function edit($ideaHashId)
    {
        $hash = new Hashids('idea id hash',10,Config::get('app.encode_chars'));
        $ideaId = $hash->decode($ideaHashId);
        $idea = Idea::findOrFail($ideaId[0]);
        $unitData = Unit::where('id', $idea->unit_id)->first();

        $types = Type::all();
        $tasks = Task::query()
            ->where('unit_id', $unitData->id)
            ->get();

        $issues = Issue::query()
            ->where('unit_id', $unitData->id)
            ->get();


        $availableFunds = Fund::getUnitDonatedFund($idea->unit_id);
        $awardedFunds = Fund::getUnitAwardedFund($idea->unit_id);

        view()->share('availableFunds',$availableFunds);
        view()->share('awardedFunds',$awardedFunds);
        view()->share('unitData',$unitData);
        view()->share('idea',$idea);
        view()->share('ideaHashId',$ideaHashId);
        view()->share('types', $types);
        view()->share('tasks', $tasks);
        view()->share('issues', $issues);

        return view('ideas.edit');
    }

    public function update(Request $request, $ideaHashId)
    {
        $unitHash = new Hashids('unit id hash',10,Config::get('app.encode_chars'));
        $unit = Unit::where('id', $request->unit_id)->first();
        $validator = Validator::make($request->all(),[
            'title'        => 'required',
            'type_id'      => 'nullable',
            'task_id'      => 'nullable',
            'issue_id'     => 'nullable',
            'description'  => 'required',
            'comment'      => 'required',
            'file'         => 'nullable',
        ]);
        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $idea = Idea::where('id', $request->idea_id)
            ->update([
                'title'          => $request->title,
                'user_id'        => auth()->user()->id,
                'task_id'        => $request->task_id,
                'issue_id'       => $request->issue_id,
                'type_id'        => $request->type_id,
                'description'    => $request->description,
                'comment'        => $request->comment,
                'status'         => 1,
        ]);

        if($idea)
        {
            return redirect('units/'. $unitHash->encode($request->unit_id) . '/' . $unit->slug);
        }
    }
}
