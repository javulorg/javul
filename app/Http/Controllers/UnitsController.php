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
        $countries = Unit::getAllCountryWithFrequent();
        $unitsObj = Unit::lists('name','id');

        view()->share('relatedUnitsObj',$unitsObj);
        view()->share('parentUnitsObj',$unitsObj);
        view()->share('countries',$countries);
        view()->share('unit_category_arr',$unit_category_arr);
        view()->share('unit_credibility_arr',$unit_credibility_arr);
        view()->share('unitObj',[] );
        view()->share('states',[]);
        view()->share('cities',[]);
        view()->share('relatedUnitsofUnitObj',[]);
        //if page is submitted
        if($request->isMethod('post')){
            $validator = \Validator::make($request->all(), [
                'unit_name' => 'required',
                'unit_category' => 'required',
                'credibility' => 'required',
                'country' => 'required',
                'state' => 'required',
                'city' => 'required',
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
                'category_id'=>implode(",",$request->input('unit_category')),
                'description'=>trim($request->input('description')),
                'credibility'=>$request->input('credibility'),
                'country_id'=>$request->input('country'),
                'state_id'=>$request->input('state'),
                'city_id'=>$request->input('city'),
                'status'=>$status,
                'parent_id'=>$request->input('parent_unit')
            ])->id;

            //if user selected related to unit then insert record to related_units table
            $related_unit = $request->input('related_to');
            if(!empty($related_unit)){
                RelatedUnit::create([
                    'unit_id'=>$unitID,
                    'related_to'=>implode(",",$related_unit)
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
                'comment'=>'<a href="'.url('users/'.$user_id).'">'.Auth::user()->first_name.' '.Auth::user()->last_name.'</a> created
                 unit <a href="'.url('units/'.$unit_id).'">'.$request->input('unit_name').'</a>'
            ]);

            $request->session()->flash('msg_val', "Unit created successfully!!!");
            return redirect('units');
        }


        return view('units.create');
    }

    /**
     * Update Unit information
     * @param $unit_id
     * @param Request $request
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function edit($unit_id,Request $request){
        if(!empty($unit_id))
        {
            $unitIDHashID = new Hashids('unit id hash',10,\Config::get('app.encode_chars'));
            $unit_id = $unitIDHashID->decode($unit_id);
            if(!empty($unit_id)){
                $unit_id = $unit_id[0];
                $units = Unit::getUnitWithCategories($unit_id);
                //dd($request->all());
                if(!empty($units) && $request->isMethod('post')){
                    //update unit and redirect to units page
                    $validator = \Validator::make($request->all(), [
                        'unit_name' => 'required',
                        'unit_category' => 'required',
                        'credibility' => 'required',
                        'country' => 'required',
                        'state' => 'required',
                        'city' => 'required',
                    ]);

                    if ($validator->fails())
                        return redirect()->back()->withErrors($validator)->withInput();

                    // insert record into units table.
                    $status = $request->input('status');
                    if(empty($status))
                        $status="disabled";
                    else
                        $status="active";

                    // update unit data.
                    Unit::where('id',$unit_id)->update([
                        'name'=>$request->input('unit_name'),
                        'category_id'=>implode(",",$request->input('unit_category')),
                        'description'=>trim($request->input('description')),
                        'credibility'=>$request->input('credibility'),
                        'country_id'=>$request->input('country'),
                        'state_id'=>$request->input('state'),
                        'city_id'=>$request->input('city'),
                        'status'=>$status,
                        'parent_id'=>$request->input('parent_unit'),
                        'modified_by'=>Auth::user()->id
                    ]);

                    //if user selected related to unit then insert record to related_units table
                    $related_unit = $request->input('related_to');
                    if(!empty($related_unit)){
                        $relatedUnitExist = RelatedUnit::where('unit_id',$unit_id)->count();
                        if($relatedUnitExist > 0){
                            RelatedUnit::where('unit_id',$unit_id)->update([
                                'related_to'=>implode(",",$related_unit)
                            ]);
                        }
                        else{
                            RelatedUnit::create([
                                'unit_id'=>$unit_id,
                                'related_to'=>implode(",",$related_unit)
                            ]);
                        }
                    }
                    else
                    {
                        $cnt = RelatedUnit::where('unit_id',$unit_id)->count();
                        if($cnt > 0)
                            RelatedUnit::where('unit_id',$unit_id)->forceDelete();
                    }
                    // add activity point for created unit and user.
                    ActivityPoint::create([
                        'user_id'=>Auth::user()->id,
                        'unit_id'=>$unit_id,
                        'points'=>1,
                        'comments'=>'Unit Edited',
                        'type'=>'unit'
                    ]);
                    // add site activity record for global statistics.
                    $userIDHashID= new Hashids('user id hash',10,\Config::get('app.encode_chars'));
                    $user_id = $userIDHashID->encode(Auth::user()->id);

                    $unitIDHashID = new Hashids('unit id hash',10,\Config::get('app.encode_chars'));
                    $unit_id = $unitIDHashID->encode($unit_id);
                    SiteActivity::create([
                        'user_id'=>Auth::user()->id,
                        'comment'=>'<a href="'.url('users/'.$user_id).'">'.Auth::user()->first_name.' '.Auth::user()->last_name.'</a>
                        updated unit <a href="'.url('units/'.$unit_id).'">'.$request->input('unit_name').'</a>'
                    ]);

                    $request->session()->flash('msg_val', "Unit updated successfully!!!");
                    return redirect('units');

                }
                elseif(!empty($units)){

                    //redirect to edit page
                    $units = array_shift($units);
                    $unit_category_arr = UnitCategory::where('status','approved')->lists('name','id');
                    $unit_credibility_arr= SiteConfigs::getUnitCredibilityTypes();
                    $countries = Country::lists('name','id');
                    $states = State::where('country_id',$units->country_id)->lists('name','id');
                    $cities = City::where('state_id',$units->state_id)->lists('name','id');
                    $unitsObj = Unit::where('id','!=',$unit_id)->lists('name','id');

                    $relatedUnitsofUnitObj = RelatedUnit::where('unit_id',$unit_id)->first();
                    if(!empty($relatedUnitsofUnitObj))
                        $relatedUnitsofUnitObj = explode(",",$relatedUnitsofUnitObj->related_to);
                    else
                        $relatedUnitsofUnitObj  = [];

                    view()->share('relatedUnitsObj',$unitsObj);
                    view()->share('relatedUnitsofUnitObj',$relatedUnitsofUnitObj);

                    view()->share('parentUnitsObj',$unitsObj);
                    view()->share('countries',$countries);
                    view()->share('states',$states);
                    view()->share('cities',$cities);

                    view()->share('unit_category_arr',$unit_category_arr);
                    view()->share('unit_credibility_arr',$unit_credibility_arr);


                    view()->share('unitObj',$units );
                    return view('units.create');
                }
            }

        }
        return view('errors.404');
    }

    /**
     * Display Unit information only.
     * @param $unit_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view($unit_id){
        if(!empty($unit_id))
        {
            $unitIDHashID = new Hashids('unit id hash',10,\Config::get('app.encode_chars'));
            $unit_id = $unitIDHashID->decode($unit_id);
            if(!empty($unit_id)){
                $unit_id = $unit_id[0];
                $units = Unit::getUnitWithCategories($unit_id);
                $objectives = Objective::where('unit_id',$unit_id)->get();
                $tasks = Task::where('objective_id',1)->get();
                if(!empty($units)){
                    $units = array_shift($units);
                    $cityName = City::find($units->city_id);
                    view()->share('cityName',$cityName);
                    view()->share('unitObj',$units );
                    view()->share('objectivesObj',$objectives );
                    view()->share('taskObj',$tasks );
                    return view('units.view');
                }
            }

        }
        return view('errors.404');
    }

    public function show()
    {

    }
}
