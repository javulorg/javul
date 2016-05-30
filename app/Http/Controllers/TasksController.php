<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;

class TasksController extends Controller
{
    public function __construct(){
        view()->share('user_login',Auth::check());
        $username = '';
        if(Auth::check())
            $username = Auth::user()->first_name.' '.Auth::user()->last_name;

        view()->share('username',$username);
        $this->middleware('auth',['except'=>['index']]);
    }

    public function index(Request $request){
        return view('tasks.tasks');
    }


}
