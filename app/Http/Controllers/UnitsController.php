<?php

namespace App\Http\Controllers;

use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;

class UnitsController extends Controller
{
    public function __construct(){
        view()->share('user_login',Auth::check());
        $this->middleware('auth',['except'=>['index']]);
    }

    public function index(Request $request){
        return view('units');
    }
}
