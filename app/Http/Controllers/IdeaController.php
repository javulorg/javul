<?php

namespace App\Http\Controllers;

use App\Models\ActivityPoint;
use App\Models\Category;
use App\Models\Forum;
use App\Models\Fund;
use App\Models\Idea;
use App\Models\Issue;
use App\Models\Task;
use App\Models\Type;
use App\Models\Unit;
use App\Services\Ideas\IdeaService;
use App\Traits\UnitTrait;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;

class IdeaController extends Controller
{
    use UnitTrait;
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
            $issueResolutions = $this->calculateIssueResolution($request->unit);

            view()->share('totalIssueResolutions',$issueResolutions);
            view()->share('availableFunds',$availableFunds);
            view()->share('awardedFunds',$awardedFunds);
            view()->share('unitData',$unitData);
            view()->share('unitObj',$unitData);
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

        $unitId = $unitHash->decode($unitId);
        $types = Category::where('unit_id', $unitId[0])->where('status', 1)->get();
        $tasks = Task::query()
            ->where('unit_id', $unitData->id)
            ->get();

        $issues = Issue::query()
            ->where('unit_id', $unitData->id)
            ->get();

        $homeCheck = isset($request->home) ??  false;
        $availableUnitFunds = Fund::getUnitDonatedFund($unitId[0]);
        $awardedUnitFunds   = Fund::getUnitAwardedFund($unitId[0]);
        $issueResolutions = $this->calculateIssueResolution($unitId[0]);

        view()->share('totalIssueResolutions',$issueResolutions);
        view()->share('unitData',$unitData);
        view()->share('homeCheck',$homeCheck);
        view()->share('availableFunds',$availableUnitFunds);
        view()->share('awardedFunds',$awardedUnitFunds);
        view()->share('unitHashId', $unitId);
        view()->share('types', $types);
        view()->share('tasks', $tasks);
        view()->share('issues', $issues);
        view()->share('unitObj',$unitData);
        return view('ideas.create');
    }

    public function store(Request $request)
    {
        $unitHash = new Hashids('unit id hash',10,Config::get('app.encode_chars'));

        $unit = Unit::where('id', $request->unit_id)->first();
        $validator = Validator::make($request->all(),[
           'title'        => 'required',
           'category_id'  => 'nullable',
           'task_id'      => 'nullable',
           'issue_id'     => 'nullable',
           'description'  => 'required',
           'comment'      => 'nullable',
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
           'category_id'    => $request->category_id,
           'description'    => $request->description,
           'comment'        => $request->comment,
           'status'         => 1,
        ]);
        if($idea)
        {
            ActivityPoint::create([
                'user_id'      => Auth::user()->id,
                'points'       => 2,
                'idea_id'      => $idea->id,
                'comments'     => 'Idea Created',
                'type'         => 'idea',
                'unit_id'      => $request->unit_id
            ]);
            return redirect('units/'. $unitHash->encode($request->unit_id) . '/' . $unit->slug);
        }
    }

    public function show($ideaHashId)
    {
        $service = new IdeaService();
        $hash = new Hashids('idea id hash',10,Config::get('app.encode_chars'));
        $ideaId = $hash->decode($ideaHashId);
        $idea = Idea::findOrFail($ideaId[0]);



        $unitData = Unit::where('id', $idea->unit_id)->first();
        $availableFunds = Fund::getUnitDonatedFund($idea->unit_id);
        $awardedFunds = Fund::getUnitAwardedFund($idea->unit_id);



        $forumID =  Forum::checkTopic(array(
            'unit_id'    => $idea->unit_id,
            'section_id' => 2,
            'object_id'  =>  $idea->id,
        ));

        if(!empty($forumID))
        {
            view()->share('addComments', url('forum/post/'. $forumID->topic_id .'/'. $forumID->slug ));
            $comments = $service->comments( $idea->unit_id, 4, $idea->id);
            view()->share('comments', $comments);
        }
        $comments = $service->comments( $idea->unit_id, 4, $idea->id);
        $issueResolutions = $this->calculateIssueResolution($idea->unit_id);

        $ratingResult = $this->calculateRate(2, $idea->id, $idea->unit_id);

        view()->share('ratingResult',$ratingResult);

        view()->share('totalIssueResolutions',$issueResolutions);

        view()->share('comments', $comments);

        view()->share("unit_id", $idea->unit_id);
        view()->share("section_id", 4);
        view()->share("object_id",$idea->id);

        view()->share('availableFunds',$availableFunds);
        view()->share('awardedFunds',$awardedFunds);
        view()->share('unitData',$unitData);
        view()->share('idea',$idea);
        view()->share('ideaHashId',$ideaHashId);
        view()->share('unitObj',$unitData);

        return view('ideas.show');
    }

    public function edit($ideaHashId)
    {
        $hash = new Hashids('idea id hash',10,Config::get('app.encode_chars'));
        $ideaId = $hash->decode($ideaHashId);
        $idea = Idea::findOrFail($ideaId[0]);
        $unitData = Unit::where('id', $idea->unit_id)->first();

        $types = Category::where('unit_id', $idea->unit_id)->where('status', 1)->get();
        $tasks = Task::query()
            ->where('unit_id', $unitData->id)
            ->get();

        $issues = Issue::query()
            ->where('unit_id', $unitData->id)
            ->get();


        $availableFunds = Fund::getUnitDonatedFund($idea->unit_id);
        $awardedFunds = Fund::getUnitAwardedFund($idea->unit_id);
        $issueResolutions = $this->calculateIssueResolution($idea->unit_id);

        view()->share('totalIssueResolutions',$issueResolutions);
        view()->share('availableFunds',$availableFunds);
        view()->share('awardedFunds',$awardedFunds);
        view()->share('unitData',$unitData);
        view()->share('idea',$idea);
        view()->share('ideaHashId',$ideaHashId);
        view()->share('types', $types);
        view()->share('tasks', $tasks);
        view()->share('issues', $issues);
        view()->share('unitObj',$unitData);
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
            'comment'      => 'nullable',
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
                'category_id'    => $request->category_id,
                'description'    => $request->description,
                'comment'        => $request->comment,
                'status'         => $request->status,
        ]);

        ActivityPoint::create([
            'user_id'      => Auth::user()->id,
            'points'       => 2,
            'idea_id'      => $request->idea_id,
            'comments'     => 'Idea Updated',
            'type'         => 'idea',
            'unit_id'      => $request->unit_id
        ]);

        if($idea)
        {
            return redirect('units/'. $unitHash->encode($request->unit_id) . '/' . $unit->slug);
        }
    }

    public function upvoteEdits(Request $request)
    {
        $cookieName = "upvoted_issue_{$request->revisionId}";
        if ($request->cookie($cookieName)) {
            // If the cookie exists, return an error response
            return response()->json(['error' => 'You have already upvoted this idea'], 422);
        }
        Idea::findOrFail($request->ideaId)
            ->increment('upvote_edit_count');

        // Set a cookie indicating that the objective has been upvoted
        return response()->json(['message' => 'Idea upvoted successfully'])
            ->cookie($cookieName, true, /* expiration time if needed */);
    }
}
