<?php

namespace App\Providers;

use App\Http\Controllers\Mc;
use App\Http\Controllers\UserController;
use App\Models\Fund;
use App\Models\Idea;
use App\Models\Issue;
use App\Models\Objective;
use App\Models\SiteActivity;
use App\Models\Task;
use App\Models\TaskBidder;
use App\Models\Unit;
use App\Models\User;
use App\Models\UserMessages;
use App\Models\UserNotification;
use Carbon\Carbon;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    public function boot(Request $request)
    {
        view()->composer('*', function ($view) {
            $view->with('authUserObj', auth()->user());
            if (auth()->check()) {
                if (DB::connection()->getSchemaBuilder()->hasTable('task_bidders') && DB::connection()->getSchemaBuilder()->hasTable('tasks')) {
                    $notifications = TaskBidder::join('tasks', 'task_bidders.task_id', '=', 'tasks.id')
                        ->whereIn('task_bidders.status', ['offer_sent', 're_assigned'])
                        ->where('task_bidders.user_id', Auth::user()->id)
                        ->select(['tasks.name', 'tasks.slug', 'task_bidders.*'])
                        ->get();
                    view()->share('notifications', $notifications);
                } else {
                    view()->share('notifications', collect());
                }
            }

            $view->with('totalUnits', DB::connection()->getSchemaBuilder()->hasTable('units') ? Unit::count() : 0);
            $view->with('totalObjectives', DB::connection()->getSchemaBuilder()->hasTable('objectives') ? Objective::count() : 0);
            $view->with('totalTasks', DB::connection()->getSchemaBuilder()->hasTable('tasks') ? Task::count() : 0);
            $view->with('totalIdeas', DB::connection()->getSchemaBuilder()->hasTable('ideas') ? Idea::count() : 0);
            $view->with('totalIssues', DB::connection()->getSchemaBuilder()->hasTable('issues') ? Issue::count() : 0);
            $view->with('totalFundsAvailable', DB::connection()->getSchemaBuilder()->hasTable('funds') ? Fund::where('status', 'approved')->where('transaction_type', 'donated')->sum('amount') : 0);
        });

        // Hashids
        $ideaHashID             = new Hashids('idea id hash', 10, Config::get('app.encode_chars'));
        $userIDHashID           = new Hashids('user id hash', 10, Config::get('app.encode_chars'));
        $unitIDHashID           = new Hashids('unit id hash', 10, Config::get('app.encode_chars'));
        $unitCategoryIDHashID   = new Hashids('unit category id hash', 10, Config::get('app.encode_chars'));
        $objectiveIDHashID      = new Hashids('objective id hash', 10, Config::get('app.encode_chars'));
        $taskIDHashID           = new Hashids('task id hash', 10, Config::get('app.encode_chars'));
        $taskDocumentIDHashID   = new Hashids('task document id hash', 10, Config::get('app.encode_chars'));
        $issueIDHashID          = new Hashids('issue id hash', 10, Config::get('app.encode_chars'));
        $issueDocumentIDHashID  = new Hashids('issue document id hash', 10, Config::get('app.encode_chars'));
        $jobSkillIDHashID       = new Hashids('job skills id hash', 10, Config::get('app.encode_chars'));
        $areaOfInterestIDHashID = new Hashids('area of interest id hash', 10, Config::get('app.encode_chars'));
        $btcTransactionIDHashID = new Hashids('btc transaction id hash', 10, Config::get('app.encode_chars'));

        $loggedInUser = 0;
        if (DB::connection()->getSchemaBuilder()->hasTable('users')) {
            $loggedInUser = DB::table('users')->whereRaw('unix_timestamp() - loggedin < 30')->count();
        }
        view()->share('totalLoggedinUsers', $loggedInUser);

        //Get all system messages
        $user_msg      = new UserMessages;
        $user_messages = $user_msg->getAllMessages();
        view()->share('user_messages', json_encode($user_messages));

        $totalUsers = 0;
        if (DB::connection()->getSchemaBuilder()->hasTable('users')) {
            $totalUsers = User::count();
        }
        view()->share('totalRegisteredUsers', $totalUsers);

        view()->share('userIDHashID', $userIDHashID);
        view()->share('ideaHashID', $ideaHashID);
        view()->share('unitIDHashID', $unitIDHashID);
        view()->share('unitCategoryIDHashID', $unitCategoryIDHashID);
        view()->share('objectiveIDHashID', $objectiveIDHashID);
        view()->share('taskIDHashID', $taskIDHashID);
        view()->share('taskDocumentIDHashID', $taskDocumentIDHashID);
        view()->share('issueIDHashID', $issueIDHashID);
        view()->share('issueDocumentIDHashID', $issueDocumentIDHashID);
        view()->share('jobSkillIDHashID', $jobSkillIDHashID);
        view()->share('areaOfInterestIDHashID', $areaOfInterestIDHashID);
        view()->share('btcTransactionIDHashID', $btcTransactionIDHashID);

        view()->composer('elements.header', function ($view) {
            Mc::putMcData();
            $question = Mc::getMcQuestion();
            $view->with('report_question', $question);

            $notificationCount = 0;
            if (auth()->check() && DB::connection()->getSchemaBuilder()->hasTable('user_notifications')) {
                $notificationCount = UserNotification::where('user_id', auth()->user()->id)->where('message_read', 0)->count();
            }
            $view->with('notificationCount', $notificationCount);
        });

        view()->share('site_activity_text', 'Activity Log');
        if (DB::connection()->getSchemaBuilder()->hasTable('site_activities')) {
            $site_activity = SiteActivity::orderBy('created_at', 'desc')->paginate(Config::get('app.site_activity_page_limit'));
            view()->share('site_activity', $site_activity);
        } else {
            view()->share('site_activity', collect());
        }

        $userController = new UserController;

        if (DB::connection()->getSchemaBuilder()->hasTable('tasks')) {
            $tasksMaster = Task::query()
                ->with('unit')
                ->when($request->filled('search'), function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->search . '%');
                    // ya agar 'name' column nahi ho to 'title' ya 'task_name' lagao
                })
                ->orderByDesc('id')
                ->limit(5)
                ->get();


            $tasksMasterData = Task::query()
                ->with('unit')
                ->orderByDesc('id')
                ->get();

            $tasksMasterTotal = Task::count();
        } else {
            $tasksMaster = collect();
            $tasksMasterData = collect();
            $tasksMasterTotal = 0;
        }

        if (DB::connection()->getSchemaBuilder()->hasTable('objectives')) {
            $objectivesTotal  = Objective::count();
            $objectivesMaster = Objective::query()
                ->with('unit')
                ->when($request->filled('search'), function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->search . '%');
                })
                ->orderBy('id', 'DESC')
                ->limit(5)
                ->get();


            $objectivesMasterData = Objective::query()
                ->with('unit')
                ->orderBy('id', 'DESC')
                ->limit(5)
                ->get();
        } else {
            $objectivesTotal = 0;
            $objectivesMaster = collect();
            $objectivesMasterData = collect();
        }

        if (DB::connection()->getSchemaBuilder()->hasTable('units')) {
            $units      = Unit::query();
            $unitsTotal = Unit::count();

            $allUnits = Unit::query()
                ->orderBy('id', 'DESC')
                ->get();
            // $unitsMaster = Unit::query()
            //     ->orderBy('id', 'DESC')
            //     ->limit(5)
            //     ->get();

            $unitsMaster = Unit::query()
                ->when($request->filled('search'), function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->search . '%');
                })
                ->orderBy('id', 'DESC')
                ->limit(5)
                ->get();
        } else {
            $units = collect();
            $unitsTotal = 0;
            $allUnits = collect();
            $unitsMaster = collect();
        }

        if (DB::connection()->getSchemaBuilder()->hasTable('issues')) {
            $issuesMaster = Issue::query()
                ->with('unit')
                ->orderBy('id', 'DESC')
                ->limit(5)
                ->get();
            $issuesMasterTotal = Issue::count();

            $issuesMasterData = Issue::query()
                ->with('unit')
                ->when($request->filled('search'), function ($query) use ($request) {
                    $query->where('title', 'like', '%' . $request->search . '%');
                    // Agar `name` ki jagah `title` ya `subject` ho to yaha change kar lena
                })
                ->orderBy('id', 'DESC')
                ->get();
        } else {
            $issuesMaster = collect();
            $issuesMasterTotal = 0;
            $issuesMasterData = collect();
        }

        if (DB::connection()->getSchemaBuilder()->hasTable('ideas')) {
            $ideasMasterTotal = Idea::count();
            $ideasMaster = Idea::query()
                ->with('unit')
                ->when($request->filled('search'), function ($query) use ($request) {
                    $query->where('title', 'like', '%' . $request->search . '%');
                })
                ->orderBy('id', 'DESC')
                ->get();
        } else {
            $ideasMasterTotal = 0;
            $ideasMaster = collect();
        }

        if (DB::connection()->getSchemaBuilder()->hasTable('tasks')) {
            $changeOpenForBiddingTasks = Task::where('status', 'open_for_bidding')
                ->where('open_for_bidding_date', '<', Carbon::now()->format('Y-m-d'))
                ->get();
            if ($changeOpenForBiddingTasks) {
                foreach ($changeOpenForBiddingTasks as $task) {
                    $task->update([
                        'status'                => 'bid_selection',
                        'open_for_bidding_date' => null,
                    ]);
                }
            }
        }

        view()->share('tasksMaster', $tasksMaster);
        view()->share('tasksMasterData', $tasksMasterData);
        view()->share('tasksMasterTotal', $tasksMasterTotal);
        view()->share('objectivesTotal', $objectivesTotal);
        view()->share('objectivesMaster', $objectivesMaster);
        view()->share('unitsData', $units);
        view()->share('unitsTotal', $unitsTotal);
        view()->share('objectivesMasterData', $objectivesMasterData);
        view()->share('allUnits', $allUnits);
        view()->share('unitsMaster', $unitsMaster);
        view()->share('issuesMaster', $issuesMaster);
        view()->share('issuesMasterTotal', $issuesMasterTotal);
        view()->share('issuesMasterData', $issuesMasterData);
        view()->share('ideasMasterTotal', $ideasMasterTotal);
        view()->share('ideasMaster', $ideasMaster);
    }

    public function register()
    {
        //
    }
}
