<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Objective;
use App\SiteActivity;
use App\Task;
use App\Unit;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Hashids\Hashids;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        view()->share('user_login',Auth::check());
        $username = '';
        if(Auth::check())
            $username = Auth::user()->first_name.' '.Auth::user()->last_name;

        view()->share('username',$username);
        $this->middleware('auth',['except'=>['index']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recentUnits = Unit::take(5)->orderBy('created_at','desc')->get();
        $recentObjectives = Objective::take(5)->orderBy('created_at','desc')->get();
        $recentTasks= Task::take(5)->orderBy('created_at','desc')->get();
        $recentUsers= User::take(5)->orderBy('created_at','desc')->get();

        view()->share('recentUnits',$recentUnits);
        view()->share('recentObjectives',$recentObjectives);
        view()->share('recentTasks',$recentTasks);
        view()->share('recentUsers',$recentUsers);

        return view('home');
    }
}
