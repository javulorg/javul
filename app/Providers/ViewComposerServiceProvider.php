<?php

namespace App\Providers;

use App\Objective;
use App\SiteActivity;
use App\Task;
use App\Unit;
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
        //----------------- for footer ---------------------------
        $userIDHashID= new Hashids('user id hash',10,\Config::get('app.encode_chars'));
        $unitIDHashID = new Hashids('unit id hash',10,\Config::get('app.encode_chars'));
        $unitCategoryIDHashID = new Hashids('unit category id hash',10,\Config::get('app.encode_chars'));
        $objectiveIDHashID = new Hashids('objective id hash',10,\Config::get('app.encode_chars'));
        $taskIDHashID = new Hashids('task id hash',10,\Config::get('app.encode_chars'));

        view()->share('userIDHashID',$userIDHashID );
        view()->share('unitIDHashID',$unitIDHashID );
        view()->share('unitCategoryIDHashID',$unitCategoryIDHashID);
        view()->share('objectiveIDHashID',$objectiveIDHashID );
        view()->share('taskIDHashID',$taskIDHashID );

        view()->composer('elements.footer',function($view){
            $view->with('totalUnits',Unit::count());
            $view->with('totalObjectives',Objective::count());
            $view->with('totalTasks',Task::count());
        });

        view()->composer('elements.site_activities',function($view){
            $view->with('site_activity',SiteActivity::take(10)->orderBy('created_at','desc')->get());
        });
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
