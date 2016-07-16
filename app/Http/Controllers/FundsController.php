<?php

namespace App\Http\Controllers;

use App\ActivityPoint;
use App\City;
use App\Country;
use App\CreditCards;
use App\Objective;
use App\RelatedUnit;
use App\SiteActivity;
use App\SiteConfigs;
use App\State;
use App\Task;
use App\TaskBidder;
use App\Transaction;
use App\Unit;
use App\UnitCategory;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use Hashids\Hashids;


class FundsController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
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
        return view('funds.units');
    }


    public function donate_to_unit_objective_task(Request $request,$id){
        if(!empty($id)){
            $type = $request->segment(3);
            $exists = false;
            switch($type){
                case 'unit':
                    $exists = Unit::checkUnitExist($id,true);
                    break;
                case 'objective':
                    $exists = Objective::checkObjectiveExist($id,true);
                    break;
                case 'task':
                    $exists = Task::checkTaskExist($id,true);
                    break;
                default:
                    $exists=false;
                    break;
            }

            if($exists){
                $creditedBalance = Transaction::where('user_id',Auth::user()->id)->where('trans_type','credit')->sum('amount');
                $debitedBalance = Transaction::where('user_id',Auth::user()->id)->where('trans_type','debit')->sum('amount');

                $availableBalance = $creditedBalance - $debitedBalance;
                $users_cards = User::getAllCreditCards(Auth::user()->id);
                $expiry_years = SiteConfigs::getCardExpiryYear();
                view()->share('expiry_years',$expiry_years);
                view()->share('credit_cards',$users_cards);
                view()->share('availableBalance',100);

                return view('funds.donation');
            }
        }
        return view('errors.404');
    }
    public function show()
    {

    }
}
