<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class TasksController extends Controller
{
    public function __construct(){}

    public function index(Request $request){
        return view('tasks');
    }


}
