<?php

namespace App\Http\Controllers;

use App\Models\ActivityPoint;
use App\Models\Category;
use App\Models\Forum;
use App\Models\Fund;
use App\Models\Idea;
use App\Models\IdeaRevision;
use App\Models\Issue;
use App\Models\SiteActivity;
use App\Models\Task;
use App\Models\Watchlist;
use App\Models\Type;
use App\Models\Unit;
use App\Services\Ideas\IdeaService;
use App\Traits\UnitTrait;
use Carbon\Carbon;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;

class IdeaController extends Controller
{
    use UnitTrait;
    protected $service;
    public function __construct(IdeaService $service)
    {
        $this->service = $service;
        // $this->middleware('auth', ['except' => ['index', 'view']]);
    }

    public function index(Request $request)
    {

        // $pagination = $this->service->listAll()->paginate(10);
        $pagination = $this->service->listAll($request)
            ->paginate(10)
            ->appends($request->all());


        if (isset($request->unit)) {
            $ideasTotal = Idea::where('unit_id', $request->unit)->get()->count();
            $unitData = Unit::where('id', $request->unit)->first();
            $availableFunds = Fund::getUnitDonatedFund($request->unit);
            $awardedFunds = Fund::getUnitAwardedFund($request->unit);
            $issueResolutions = $this->calculateIssueResolution($request->unit);

            view()->share('totalIssueResolutions', $issueResolutions);
            view()->share('availableFunds', $availableFunds);
            view()->share('awardedFunds', $awardedFunds);
            view()->share('unitData', $unitData);
            view()->share('unitObj', $unitData);
            view()->share('ideasTotal', $ideasTotal);

            $unitIdea = Idea::query()
                ->with('unit')
                ->where('unit_id', $request->unit)
                ->orderByDesc('id')
                ->get();
            view()->share('unitIdea', $unitIdea);
        }
        return view('ideas.index', compact('pagination'));
    }

    public function create($unitId)
    {
        $unitHash = new Hashids('unit id hash', 10, Config::get('app.encode_chars'));
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

        view()->share('totalIssueResolutions', $issueResolutions);
        view()->share('unitData', $unitData);
        view()->share('homeCheck', $homeCheck);
        view()->share('availableFunds', $availableUnitFunds);
        view()->share('awardedFunds', $awardedUnitFunds);
        view()->share('unitHashId', $unitId);
        view()->share('types', $types);
        view()->share('tasks', $tasks);
        view()->share('issues', $issues);
        view()->share('unitObj', $unitData);
        return view('ideas.create');
    }

    public function store(Request $request)
    {
        $unitHash = new Hashids('unit id hash', 10, Config::get('app.encode_chars'));

        $unit = Unit::where('id', $request->unit_id)->first();
        $validator = Validator::make($request->all(), [
            'title'        => 'required',
            'category_id'  => 'nullable',
            'task_id'      => 'nullable',
            'issue_id'     => 'nullable',
            'description'  => 'required',
            'comment'      => 'nullable',
            'file'         => 'nullable',
        ]);
        if ($validator->fails()) {
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
        if ($idea) {
            ActivityPoint::create([
                'user_id'      => Auth::user()->id,
                'points'       => 3,
                'idea_id'      => $idea->id,
                'comments'     => 'Idea Created',
                'type'         => 'idea',
                'unit_id'      => $request->unit_id
            ]);


            $ideaIDHash = new \Hashids\Hashids('idea id hash', 10, config('app.encode_chars'));
            $ideaIdEncoded = $ideaIDHash->encode($idea->id);

            $userIDHashID = new \Hashids\Hashids('user id hash', 10, config('app.encode_chars'));
            $user_id_encoded = $userIDHashID->encode(auth()->id());

            $userName = auth()->user()->username ?? (auth()->user()->first_name . ' ' . auth()->user()->last_name);
            $unitSlug = $unit->slug ?? 'unit';
            SiteActivity::create([
                'user_id'  => auth()->id(),
                'unit_id'  => $idea->unit_id,
                'idea_id'  => $idea->id, // ✅ this is key
                'comment'  => '<a href="' . url('userprofiles/' . $user_id_encoded . '/' . strtolower($userName)) . '">' . e($userName) . '</a>' .
                    ' created idea <a href="' . url('ideas/' . $ideaIdEncoded . '/' . \Str::slug($idea->title)) . '">' . e($idea->title) . '</a>',
            ]);


            // $encodedObjectiveID = $objectiveIDHashID->encode($objective_id);

            // return redirect('objectives/' . $encodedObjectiveID . '/' . $unitObj->slug)
            //     ->with('success', 'Task created successfully!');

            // return redirect('objectives/' . $unitHash->encode($request->unit_id) . '/' . $unit->slug)
            //     ->with('success', 'Idea created successfully!');
            // return redirect('units/'. $unitHash->encode($request->unit_id) . '/' . $unit->slug);
            return response('Idea created successfully!', 200);
        }
    }


    // public function store(Request $request)

    // {
    //     $unitHash = new \Hashids\Hashids('unit id hash', 10, config('app.encode_chars'));

    //     $unit = \App\Models\Unit::where('id', $request->unit_id)->first();

    //     $validator = Validator::make($request->all(), [
    //         'title'        => 'required',
    //         'category_id'  => 'nullable',
    //         'task_id'      => 'nullable',
    //         'issue_id'     => 'nullable',
    //         'description'  => 'required',
    //         'comment'      => 'nullable',
    //         'file'         => 'nullable',
    //     ]);

    //     if ($validator->fails()) {
    //         return redirect()->back()->withErrors($validator)->withInput();
    //     }

    //     $idea = \App\Models\Idea::create([
    //         'title'        => $request->title,
    //         'user_id'      => auth()->id(),
    //         'unit_id'      => $request->unit_id,
    //         'task_id'      => $request->task_id,
    //         'issue_id'     => $request->issue_id,
    //         'category_id'  => $request->category_id,
    //         'description'  => $request->description,
    //         'comment'      => $request->comment,
    //         'status'       => 1,
    //     ]);

    //     if ($idea) {
    //         \App\Models\ActivityPoint::create([
    //             'user_id'  => auth()->id(),
    //             'points'   => 3,
    //             'idea_id'  => $idea->id,
    //             'comments' => 'Idea Created',
    //             'type'     => 'idea',
    //             'unit_id'  => $request->unit_id,
    //         ]);

    //         // Generate hash IDs
    //         $ideaIDHash = new \Hashids\Hashids('idea id hash', 10, config('app.encode_chars'));
    //         $ideaIdEncoded = $ideaIDHash->encode($idea->id);

    //         $userIDHashID = new \Hashids\Hashids('user id hash', 10, config('app.encode_chars'));
    //         $user_id_encoded = $userIDHashID->encode(auth()->id());

    //         $userName = auth()->user()->username ?? (auth()->user()->first_name . ' ' . auth()->user()->last_name);
    //         $unitSlug = $unit->slug ?? 'unit';

    //         SiteActivity::create([
    //             'user_id'  => auth()->id(),
    //             'unit_id'  => $idea->unit_id,
    //             'idea_id'  => $idea->id, // ✅ this is key
    //             'comment'  => '<a href="' . url('userprofiles/' . $user_id_encoded . '/' . strtolower($userName)) . '">' . e($userName) . '</a>' .
    //                 ' created idea <a href="' . url('ideas/' . $ideaIdEncoded . '/' . \Str::slug($idea->title)) . '">' . e($idea->title) . '</a>',
    //         ]);

    //         return redirect()->back()->with('success', 'Idea created successfully and activity logged.');
    //     }

    //     return redirect()->back()->with('error', 'Something went wrong. Please try again.');
    // }


    public function show($ideaHashId)
    {
        $service = new IdeaService();
        $hash = new Hashids('idea id hash', 10, Config::get('app.encode_chars'));
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

        if (!empty($forumID)) {
            view()->share('addComments', url('forum/post/' . $forumID->topic_id . '/' . $forumID->slug));
            $comments = $service->comments($idea->unit_id, 4, $idea->id);
            view()->share('comments', $comments);
        }
        $comments = $service->comments($idea->unit_id, 4, $idea->id);
        $issueResolutions = $this->calculateIssueResolution($idea->unit_id);

        $ratingResult = $this->calculateRate(2, $idea->id, $idea->unit_id);

        view()->share('ratingResult', $ratingResult);

        view()->share('totalIssueResolutions', $issueResolutions);

        view()->share('comments', $comments);

        view()->share("unit_id", $idea->unit_id);
        view()->share("section_id", 4);
        view()->share("object_id", $idea->id);

        view()->share('availableFunds', $availableFunds);
        view()->share('awardedFunds', $awardedFunds);
        view()->share('unitData', $unitData);
        view()->share('idea', $idea);
        view()->share('ideaHashId', $ideaHashId);
        view()->share('unitObj', $unitData);

        return view('ideas.show');
    }

    public function edit($ideaHashId)
    {
        $hash = new Hashids('idea id hash', 10, Config::get('app.encode_chars'));
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

        view()->share('totalIssueResolutions', $issueResolutions);
        view()->share('availableFunds', $availableFunds);
        view()->share('awardedFunds', $awardedFunds);
        view()->share('unitData', $unitData);
        view()->share('idea', $idea);
        view()->share('ideaHashId', $ideaHashId);
        view()->share('types', $types);
        view()->share('tasks', $tasks);
        view()->share('issues', $issues);
        view()->share('unitObj', $unitData);
        return view('ideas.edit');
    }

    public function update(Request $request, $ideaHashId)
    {
        $unitHash = new Hashids('unit id hash', 10, Config::get('app.encode_chars'));
        $unit = Unit::where('id', $request->unit_id)->first();
        $validator = Validator::make($request->all(), [
            'title'        => 'required',
            'type_id'      => 'nullable',
            'task_id'      => 'nullable',
            'issue_id'     => 'nullable',
            'description'  => 'required',
            'comment'      => 'nullable',
            'file'         => 'nullable',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $idea = Idea::where('id', $request->idea_id)->first();
        $bytes    = IdeaRevision::strBytes(str_replace(' ', '', strip_tags($request->description)));
        $oldBytes = IdeaRevision::strBytes(str_replace(' ', '', strip_tags($idea->description)));

        $ideaRevision                = new IdeaRevision();
        $ideaRevision->unit_id       = $idea->unit_id;
        $ideaRevision->user_id       = $idea->user_id;
        $ideaRevision->description   = $idea->description;
        $ideaRevision->idea_id       = $idea->id;
        $ideaRevision->comment       = $idea->comment . " ";
        $ideaRevision->modified_by   = Auth::user()->id;
        $ideaRevision->size          = ($bytes - $oldBytes);
        $ideaRevision->created_at    = date("Y-m-d H:i:s");
        $ideaRevision->save();

        $idea->update([
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
            'points'       => 1,
            'idea_id'      => $request->idea_id,
            'comments'     => 'Idea Updated',
            'type'         => 'idea',
            'unit_id'      => $request->unit_id
        ]);


        if ($idea) {
            return redirect('units/' . $unitHash->encode($request->unit_id) . '/' . $unit->slug);
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


    public function revision($idea_id, Request $request)
    {
        if (!empty($idea_id)) {
            view()->share("idea_id", $idea_id);
            $hash = new Hashids('idea id hash', 10, Config::get('app.encode_chars'));
            $idea_id = $hash->decode($idea_id);

            if (!empty($idea_id)) {
                $idea_id = $idea_id[0];
                $idea = Idea::findOrFail($idea_id);
                if ($idea) {
                    view()->share('idea', $idea);

                    $availableUnitFunds = Fund::getUnitDonatedFund($idea->unit_id);
                    $awardedUnitFunds = Fund::getUnitAwardedFund($idea->unit_id);

                    view()->share('availableUnitFunds', $availableUnitFunds);
                    view()->share('awardedUnitFunds', $awardedUnitFunds);


                    $revisions = IdeaRevision::with('user')
                        ->where('unit_id', $idea->unit_id)
                        ->where('idea_id', $idea->id)
                        ->get();

                    $userIDHashID = new Hashids('user id hash', 10, Config::get('app.encode_chars'));

                    view()->share('userIDHashID', $userIDHashID);
                    view()->share('Carbon', new Carbon);
                    view()->share('revisions', $revisions);
                    view()->share("unit_id", $idea->unit_id);
                    view()->share("section_id", 1);
                    view()->share("object_id", $idea->id);

                    $site_activity = SiteActivity::where('unit_id', $idea->unit->id)->orderBy('id', 'desc')->paginate(Config::get('app.site_activity_page_limit'));
                    view()->share('site_activity', $site_activity);
                    view()->share('unit_activity_id', $idea->unit->id);


                    $unitData = Unit::where('id', $idea->unit->id)->first();
                    $availableFunds = Fund::getUnitDonatedFund($idea->unit->id);
                    $awardedFunds = Fund::getUnitAwardedFund($idea->unit->id);

                    $issueResolutions = $this->calculateIssueResolution($idea->unit->id);

                    view()->share('totalIssueResolutions', $issueResolutions);
                    view()->share('availableFunds', $availableFunds);
                    view()->share('awardedFunds', $awardedFunds);
                    view()->share('unitData', $unitData);
                    view()->share('unitObj', $unitData);
                    return view('ideas.revision.view');
                }
            }
        }
        return view('errors.404');
    }

    public function revisionView($idea_id, $revision_id, Request $request)
    {
        if (!empty($idea_id)) {
            view()->share("idea_id", $idea_id);
            $hash = new Hashids('idea id hash', 10, Config::get('app.encode_chars'));
            $idea_id = $hash->decode($idea_id);

            if (!empty($idea_id)) {
                $idea_id = $idea_id[0];
                $idea = Idea::findOrFail($idea_id);
                if ($idea) {
                    view()->share('idea', $idea);
                    $availableUnitFunds = Fund::getUnitDonatedFund($idea->unit_id);
                    $awardedUnitFunds = Fund::getUnitAwardedFund($idea->unit_id);

                    view()->share('availableUnitFunds', $availableUnitFunds);
                    view()->share('awardedUnitFunds', $awardedUnitFunds);


                    $revisions = IdeaRevision::with('user')
                        ->where('unit_id', $idea->unit_id)
                        ->where('idea_id', $idea->id)
                        ->first();

                    //                    dd($revisions->toArray());
                    $userIDHashID = new Hashids('user id hash', 10, Config::get('app.encode_chars'));
                    view()->share('userIDHashID', $userIDHashID);
                    view()->share('Carbon', new Carbon);
                    view()->share('revisions', $revisions);
                    view()->share("unit_id", $idea->unit_id);
                    view()->share("section_id", 1);
                    view()->share("object_id", $idea->id);

                    $site_activity = SiteActivity::where('unit_id', $idea->unit->id)->orderBy('id', 'desc')->paginate(Config::get('app.site_activity_page_limit'));
                    view()->share('site_activity', $site_activity);
                    view()->share('unit_activity_id', $idea->unit->id);


                    $unitData = Unit::where('id', $idea->unit->id)->first();
                    $availableFunds = Fund::getUnitDonatedFund($idea->unit->id);
                    $awardedFunds = Fund::getUnitAwardedFund($idea->unit->id);

                    $issueResolutions = $this->calculateIssueResolution($idea->unit->id);

                    view()->share('totalIssueResolutions', $issueResolutions);
                    view()->share('availableFunds', $availableFunds);
                    view()->share('awardedFunds', $awardedFunds);
                    view()->share('unitData', $unitData);
                    view()->share('unitObj', $unitData);
                    return view('ideas.revision.view_revision');
                }
            }
        }
        return view('errors.404');
    }

    // public function storeW($userId, $unitId, $idea_id)
    // {
    //     $existing = Watchlist::where('user_id', $userId)
    //         ->where('unit_id', $unitId)
    //         ->where('idea_id', $idea_id)
    //         ->first();

    //     if ($existing) {
    //         return response()->json(['message' => 'Already in watchlist'], 200);
    //     }

    //     $watchlist = new Watchlist();
    //     $watchlist->user_id = $userId;
    //     $watchlist->unit_id = $unitId;
    //     $watchlist->idea_id = $idea_id;
    //     $watchlist->save();

    //     return response()->json(['message' => 'Added to watchlist!']);
    // }

    public function storeW($idea_id)
    {
        try {
            $userId = auth()->id();

            if (!$userId) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }

            $exists = Watchlist::where('user_id', $userId)
                ->where('idea_id', $idea_id)
                ->exists();

            if ($exists) {
                return response()->json(['message' => 'Already in watchlist.']);
            }

            Watchlist::create([
                'user_id' => $userId,
                'idea_id' => $idea_id,
            ]);

            return response()->json(['message' => 'Added to watchlist!']);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Server error',
                'details' => $e->getMessage(),
            ], 500);
        }
    }

    public function removeFromWatchlist($idea_id)
    {
        $userId = auth()->id();

        $watch = \App\Models\Watchlist::where('user_id', $userId)
            ->where('idea_id', $idea_id)
            ->first();

        if ($watch) {
            $watch->delete();
            return response()->json(['message' => 'Removed from watchlist!']);
        } else {
            return response()->json(['message' => 'Item not found in watchlist.']);
        }
    }
}
