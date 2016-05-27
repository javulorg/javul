<?php

namespace App\Http\Controllers;

use App\Unit;
use Illuminate\Http\Request;

use App\Http\Requests;

class UnitsController extends Controller
{
    public function __construct(){}

    public function index(Request $request){
        return view('units');
    }


}
