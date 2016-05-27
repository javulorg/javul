<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;

class ObjectivesController extends Controller
{
    public function __construct(){
        view()->share('user_login',Auth::check());
        $this->middleware('auth',['except'=>['index']]);
    }

    public function index(Request $request){
        return view('objectives');
    }


}
