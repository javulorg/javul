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
use App\Models\Unit;
use App\Models\User;
use App\Models\UserMessages;
use App\Models\UserNotification;
use Hashids\Hashids;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
//        view()->composer('*',function($view){
//            $view->with('authUserObj',auth()->user());
//            $view->with('totalUnits',Unit::count());
//            $view->with('totalObjectives',Objective::count());
//            $view->with('totalTasks',Task::count());
//            $view->with('totalIssues',Issue::count());
//            $view->with('totalFundsAvailable',Fund::where('status', 'approved')->where('transaction_type', 'donated')->sum('amount'));
//        });
//
//        //----------------- for footer ---------------------------
//        $ideaHashID = new Hashids('idea id hash',10,Config::get('app.encode_chars'));
//        $userIDHashID = new Hashids('user id hash',10,Config::get('app.encode_chars'));
//        $unitIDHashID = new Hashids('unit id hash',10,Config::get('app.encode_chars'));
//        $unitCategoryIDHashID = new Hashids('unit category id hash',10,Config::get('app.encode_chars'));
//        $objectiveIDHashID = new Hashids('objective id hash',10,Config::get('app.encode_chars'));
//        $taskIDHashID = new Hashids('task id hash',10,Config::get('app.encode_chars'));
//        $taskDocumentIDHashID = new Hashids('task document id hash',10,Config::get('app.encode_chars'));
//        $issueIDHashID = new Hashids('issue id hash',10,Config::get('app.encode_chars'));
//        $issueDocumentIDHashID = new Hashids('issue document id hash',10,Config::get('app.encode_chars'));
//        $jobSkillIDHashID = new Hashids('job skills id hash',10,Config::get('app.encode_chars'));
//        $areaOfInterestIDHashID = new Hashids('area of interest id hash',10,Config::get('app.encode_chars'));
//        $btcTransactionIDHashID = new Hashids('btc transaction id hash',10,Config::get('app.encode_chars'));
//
//        $loggedInUser = 0;
//        if(DB::connection()->getSchemaBuilder()->hasTable('users')){
//            $loggedInUser = DB::table('users')->whereRaw('unix_timestamp() - loggedin < 30')->count();
//        }
//
//        view()->share('totalLoggedinUsers',$loggedInUser);
//
//        //Get all system messages
//        $user_msg = new UserMessages;
//        $user_messages = $user_msg->getAllMessages();
//        view()->share('user_messages',json_encode($user_messages));
//        //end
//
//        $totalUsers = 0;
//        if(DB::connection()->getSchemaBuilder()->hasTable('users'))
//        {
//            $totalUsers = User::count();
//        }
//        view()->share('totalRegisteredUsers',$totalUsers );
//        view()->share('userIDHashID',$userIDHashID );
//        view()->share('ideaHashID',$ideaHashID);
//        view()->share('unitIDHashID',$unitIDHashID );
//        view()->share('unitCategoryIDHashID',$unitCategoryIDHashID);
//        view()->share('objectiveIDHashID',$objectiveIDHashID );
//        view()->share('taskIDHashID',$taskIDHashID );
//        view()->share('taskDocumentIDHashID',$taskDocumentIDHashID);
//        view()->share('issueIDHashID',$issueIDHashID);
//        view()->share('issueDocumentIDHashID',$issueDocumentIDHashID);
//        view()->share('jobSkillIDHashID',$jobSkillIDHashID);
//        view()->share('areaOfInterestIDHashID',$areaOfInterestIDHashID);
//        view()->share('btcTransactionIDHashID',$btcTransactionIDHashID);
//
//        view()->composer('elements.header',function($view){
//            Mc::putMcData();
//            $question=Mc::getMcQuestion();
//            $view->with('report_question',$question);
//
//            $notificationCount = 0;
//            if(auth()->check()) {
//                $notificationCount = UserNotification::where('user_id',auth()->user()->id)->where('message_read',0)->count();
//            }
//            $view->with('notificationCount',$notificationCount);
//        });
//
//        view()->share('site_activity_text','Activity Log');
//        $site_activity = SiteActivity::orderBy('created_at','desc')->paginate(Config::get('app.site_activity_page_limit'));
//        view()->share('site_activity',$site_activity);
//
//        $userController = new UserController;
//
//
//
//        $tasksMaster = Task::query()
//            ->with('unit')
//            ->orderByDesc('id')
//            ->limit(5)
//            ->get();
//
//        $tasksMasterData = Task::query()
//            ->with('unit')
//            ->orderByDesc('id')
//            ->get();
//
//        $tasksMasterTotal = Task::count();
//
//
//        $objectivesTotal = Objective::get()->count();
//        $objectivesMaster = Objective::query()
//            ->with('unit')
//            ->orderBy('id', 'DESC')
//            ->limit(5)
//            ->get();
//
//        $objectivesMasterData = Objective::query()
//            ->with('unit')
//            ->orderBy('id', 'DESC')
//            ->limit(5)
//            ->get();
//
//
//        $units = Unit::query();
//        $unitsTotal = Unit::count();
//
//        view()->share('tasksMaster',$tasksMaster);
//        view()->share('tasksMasterData',$tasksMasterData);
//        view()->share('tasksMasterTotal',$tasksMasterTotal);
//        view()->share('objectivesTotal',$objectivesTotal);
//        view()->share('objectivesMaster',$objectivesMaster);
//        view()->share('unitsData',$units);
//        view()->share('unitsTotal',$unitsTotal);
//        view()->share('objectivesMasterData',$objectivesMasterData);
//
//
//        $allUnits = Unit::query()
//            ->orderBy('id', 'DESC')
//            ->get();
//        view()->share('allUnits',$allUnits);
//        $unitsMaster = Unit::query()
//            ->orderBy('id', 'DESC')
//            ->limit(5)
//            ->get();
//        $issuesMaster = Issue::query()
//            ->with('unit')
//            ->orderBy('id', 'DESC')
//            ->limit(5)
//            ->get();
//        $issuesMasterTotal = Issue::count();
//
//        $issuesMasterData = Issue::query()
//            ->with('unit')
//            ->orderBy('id', 'DESC')
//            ->get();
//        view()->share('issuesMasterData',$issuesMasterData);
//
//        $ideasMasterTotal = Idea::count();
//        $ideasMaster = Idea::query()
//            ->with('unit')
//            ->orderBy('id', 'DESC')
//            ->get();
//
//
//        view()->share('issuesMaster',$issuesMaster);
//        view()->share('issuesMasterTotal',$issuesMasterTotal);
//        view()->share('unitsMaster',$unitsMaster);
//        view()->share('ideasMasterTotal',$ideasMasterTotal);
//        view()->share('ideasMaster',$ideasMaster);

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
