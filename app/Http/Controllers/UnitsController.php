<?php

namespace App\Http\Controllers;

use App\SiteConfigs;
use App\Unit;
use App\UnitCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;

class UnitsController extends Controller
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
        return view('units.units');
    }

    /**
     * To create new unit
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request){
        $unit_category_arr = UnitCategory::all();
        $unit_credibility_arr= SiteConfigs::getUnitCredibilityTypes();
        view()->share('unit_category_arr',$unit_category_arr);
        view()->share('unit_credibility_arr',$unit_credibility_arr);
        return view('units.create');
    }
}
