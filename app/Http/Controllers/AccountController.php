<?php

namespace App\Http\Controllers;

use App\City;
use App\Http\Requests;
use App\Objective;
use App\SiteActivity;
use App\State;
use App\Task;
use App\Unit;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Hashids\Hashids;

class AccountController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        \Stripe\Stripe::setApiKey(env('STRIPE_KEY'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $acct_id = Auth::user()->stripe_account_id;

        //$account = \Stripe\Account::retrieve($acct_id);
        $fp = fopen(url('assets/images/success.png'), 'r');
        dd($fp);
        try{
        $file_obj = \Stripe\FileUpload::create(
            array(
                "purpose" => "identity_document",
                "file" => $fp
            ),
            array(
                "stripe_account" => $acct_id
            )
        );
        }catch(Exception $e){
            dd($e->getMessage());
        }
        $file = $file_obj->id;
        //$account->legal_entity->verification->document = $file;
        //$account->save();
        dd(\Stripe\Account::retrieve($acct_id));
        dd('');







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

        $countries = Unit::getAllCountryWithFrequent();
        $states = State::where('country_id',Auth::user()->country_id)->lists('name','id');
        $cities = City::where('state_id',Auth::user()->state_id)->lists('name','id');
        view()->share('countries',$countries);
        view()->share('states',$states);
        view()->share('cities',$cities);
        return view('users.my_account');
    }

    public function logout(){
        Auth::user()->update(['loggedin'=>null]);
        return redirect('logout');
    }
}
