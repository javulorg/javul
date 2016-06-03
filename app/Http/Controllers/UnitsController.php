<?php

namespace App\Http\Controllers;

use App\ActivityPoint;
use App\City;
use App\Country;
use App\Objective;
use App\RelatedUnit;
use App\SiteActivity;
use App\SiteConfigs;
use App\State;
use App\Task;
use App\Unit;
use App\UnitCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use Hashids\Hashids;


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
        $msg_flag = false;
        $msg_val = '';
        $msg_type = '';
        if($request->session()->has('msg_val')){
            $msg_val =  $request->session()->get('msg_val');
            $request->session()->forget('msg_val');
            $msg_flag = true;
            $msg_type = "success";
        }
        view()->share('msg_flag',$msg_flag);
        view()->share('msg_val',$msg_val);
        view()->share('msg_type',$msg_type);

        // get all units for listing
        $units = Unit::getUnitWithCategories();
        view()->share('units',$units );
        return view('units.units');
    }

    /**
     * Function is used to retrieve states from country id
     * @param Request $request
     * @return mixed
     */
    public function get_state(Request $request){
        $country_id = $request->input('country_id');

        $states = State::where('country_id',$country_id)->lists('name','id');
        return \Response::json(['success'=>true,'states'=>$states]);
    }

    /**
     * function is used to retrieve cities from state id
     * @param Request $request
     * @return mixed
     */
    public function get_city(Request $request){
        $state_id = $request->input('state_id');
        $cities = City::where('state_id',$state_id)->lists('name','id');
        return \Response::json(['success'=>true,'cities'=>$cities]);
    }

    /**
     * To create new unit
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request){
        $unit_category_arr = UnitCategory::where('status','approved')->lists('name','id');
        $unit_credibility_arr= SiteConfigs::getUnitCredibilityTypes();
        $countries = Country::lists('name','id');
        $unitsObj = Unit::lists('name','id');

        view()->share('relatedUnitsObj',$unitsObj);
        view()->share('parentUnitsObj',$unitsObj);
        view()->share('countries',$countries);
        view()->share('unit_category_arr',$unit_category_arr);
        view()->share('unit_credibility_arr',$unit_credibility_arr);


        //if page is submitted
        if($request->isMethod('post')){
            $validator = \Validator::make($request->all(), [
                'unit_name' => 'required',
                'unit_category' => 'required',
                'credibility' => 'required',
                'country' => 'required',
                'state' => 'required',
                'location' => 'required',
            ]);

            if ($validator->fails())
                return redirect()->back()->withErrors($validator)->withInput();


            // insert record into units table.
            $status = $request->input('status');
            if(empty($status))
                $status="disabled";
            else
                $status="active";

            $unitID = Unit::create([
                'user_id'=>Auth::user()->id,
                'name'=>$request->input('unit_name'),
                'category_id'=>$request->input('unit_category'),
                'description'=>$request->input('description'),
                'credibility'=>$request->input('credibility'),
                'location'=>$request->input('location'),
                'status'=>$status,
                'parent_id'=>$request->input('parent_unit')
            ])->id;

            //if user selected related to unit then insert record to related_units table
            $related_unit = $request->input('related_to');
            if(!empty($related_unit)){
                RelatedUnit::create([
                    'unit_id'=>$unitID,
                    'related_to'=>$related_unit
                ]);
            }
            // add activity point for created unit and user.
            ActivityPoint::create([
                'user_id'=>Auth::user()->id,
                'unit_id'=>$unitID,
                'points'=>2,
                'comments'=>'Unit Created',
                'type'=>'unit'
            ]);
            // add site activity record for global statistics.
            $userIDHashID= new Hashids('user id hash',10,\Config::get('app.encode_chars'));
            $user_id = $userIDHashID->encode(Auth::user()->id);

            $unitIDHashID = new Hashids('unit id hash',10,\Config::get('app.encode_chars'));
            $unit_id = $unitIDHashID->encode($unitID);
            SiteActivity::create([
                'user_id'=>Auth::user()->id,
                'comment'=>'<a href="'.url('users/view/'.$user_id).'">'.Auth::user()->first_name.' '.Auth::user()->last_name.'</a> created
                 unit <a href="'.url('units/view/'.$unit_id).'">'.$request->input('unit_name').'</a>'
            ]);

            $request->session()->flash('msg_val', "Unit created successfully!!!");
            return redirect('units');
        }


        return view('units.create');
    }

    public function edit($unit_id){
        dd($unit_id);
    }

    public function show()
    {

    }
}
