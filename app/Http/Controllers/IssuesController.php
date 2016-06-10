<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;

class IssuesController extends Controller
{
    public function __construct(){
        $this->middleware('auth',['except'=>['index']]);
    }

    public function index(Request $request){

    }
}
