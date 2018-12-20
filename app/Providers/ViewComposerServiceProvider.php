<?php

namespace App\Providers;

use App\Fund;
use App\Http\Controllers\Mc;
use App\Issue;
use App\Objective;
use App\SiteActivity;
use App\Task;
use App\Unit;
use App\UserNotification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\ServiceProvider;
use Hashids\Hashids;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*',function($view){
            $view->with('authUserObj',auth()->user());
            $view->with('totalUnits',Unit::count());
            $view->with('totalObjectives',Objective::count());
            $view->with('totalTasks',Task::count());
            $view->with('totalIssues',Issue::count());
            $view->with('totalFundsAvailable',Fund::where('status', 'approved')->where('transaction_type', 'donated')->sum('amount'));
        });

        //----------------- for footer ---------------------------
        $userIDHashID= new Hashids('user id hash',10,\Config::get('app.encode_chars'));
        $unitIDHashID = new Hashids('unit id hash',10,\Config::get('app.encode_chars'));
        $unitCategoryIDHashID = new Hashids('unit category id hash',10,\Config::get('app.encode_chars'));
        $objectiveIDHashID = new Hashids('objective id hash',10,\Config::get('app.encode_chars'));
        $taskIDHashID = new Hashids('task id hash',10,\Config::get('app.encode_chars'));
        $taskDocumentIDHashID = new Hashids('task document id hash',10,\Config::get('app.encode_chars'));
        $issueIDHashID = new Hashids('issue id hash',10,\Config::get('app.encode_chars'));
        $issueDocumentIDHashID = new Hashids('issue document id hash',10,\Config::get('app.encode_chars'));
        $jobSkillIDHashID = new Hashids('job skills id hash',10,\Config::get('app.encode_chars'));
        $areaOfInterestIDHashID = new Hashids('area of interest id hash',10,\Config::get('app.encode_chars'));
        $btcTransactionIDHashID = new Hashids('btc transaction id hash',10,\Config::get('app.encode_chars'));


        $loggedInUser = \DB::table('users')->whereRaw('unix_timestamp() - loggedin < 30')->count();
        view()->share('totalLoggedinUsers',$loggedInUser);

        $totalUsers = \App\User::count();
        view()->share('totalRegisteredUsers',$totalUsers );
        view()->share('userIDHashID',$userIDHashID );
        view()->share('unitIDHashID',$unitIDHashID );
        view()->share('unitCategoryIDHashID',$unitCategoryIDHashID);
        view()->share('objectiveIDHashID',$objectiveIDHashID );
        view()->share('taskIDHashID',$taskIDHashID );
        view()->share('taskDocumentIDHashID',$taskDocumentIDHashID);
        view()->share('issueIDHashID',$issueIDHashID);
        view()->share('issueDocumentIDHashID',$issueDocumentIDHashID);
        view()->share('jobSkillIDHashID',$jobSkillIDHashID);
        view()->share('areaOfInterestIDHashID',$areaOfInterestIDHashID);
        view()->share('btcTransactionIDHashID',$btcTransactionIDHashID);

        view()->composer('elements.header',function($view){
			Mc::putMcData();
            $question=Mc::getMcQuestion();
            $view->with('report_question',$question);

            $notificationCount = 0;
            if(auth()->check()) {
                $notificationCount = UserNotification::where('user_id',auth()->user()->id)->where('message_read',0)->count();
            }
            $view->with('notificationCount',$notificationCount);
        });

        /*view()->composer('elements.site_activities',function($view){
            $view->with('site_activity',SiteActivity::take(10)->orderBy('created_at','desc')->get());
        });*/
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
