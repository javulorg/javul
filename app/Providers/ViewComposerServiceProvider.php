<?php

namespace App\Providers;

use App\Issue;
use App\Objective;
use App\SiteActivity;
use App\Task;
use App\Unit;
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


        $loggedInUser = \App\User::where('loggedin',1)->count();
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

        view()->composer('elements.footer',function($view){

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
