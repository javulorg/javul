<?php

namespace App\Http\Controllers;

use App\ActivityPoint;
use App\City;
use App\Country;
use App\CreditCards;
use App\Fund;
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
        \Stripe\Stripe::setApiKey(env('STRIPE_KEY'));
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
            $obj = [];
            $donateTo = '';
            $hashID='';
            $controller = '';
            $addFunds = [];
            $availableFunds =0;
            $awardedFunds =0;
            switch($type){
                case 'unit':
                    $exists = Unit::checkUnitExist($id,true);
                    $obj= Unit::getObj($id);
                    $donateTo =" unit ";
                    $controller="units";
                    $addFunds=['unit_id'=>$obj->id];
                    $hashID= new Hashids('unit id hash',10,\Config::get('app.encode_chars'));
                    $availableFunds =Fund::getUnitDonatedFund($obj->id);
                    $awardedFunds =Fund::getUnitAwardedFund($obj->id);
                    break;
                case 'objective':
                    $exists = Objective::checkObjectiveExist($id,true);
                    $obj= Objective::getObj($id);
                    $donateTo =" objective ";
                    $controller="objectives";
                    $addFunds=['objective_id'=>$obj->id];
                    $hashID= new Hashids('objective id hash',10,\Config::get('app.encode_chars'));
                    $availableFunds =Fund::getObjectiveDonatedFund($obj->id);
                    $awardedFunds =Fund::getObjectiveAwardedFund($obj->id);
                    break;
                case 'task':
                    $exists = Task::checkTaskExist($id,true);
                    $obj= Task::getObj($id);
                    $donateTo =" task ";
                    $controller="tasks";
                    $addFunds=['task_id'=>$obj->id];
                    $hashID= new Hashids('task id hash',10,\Config::get('app.encode_chars'));
                    $availableFunds =Fund::getTaskDonatedFund($obj->id);
                    $awardedFunds =Fund::getTaskAwardedFund($obj->id);
                    break;
                default:
                    $exists=false;
                    break;
            }

            if($exists){
                if($request->isMethod('post')){

                    $opt_typ = $request->input('opt_typ');
                    $field = 'cc-amount';
                    if($opt_typ == "used"){
                        $field="amount_reused_card";
                    }
                    $validator = \Validator::make($request->all(), [
                        $field => 'required|numeric'
                    ]);

                    if ($validator->fails())
                        return redirect()->back()->withErrors($validator)->withInput();

                    if(empty($obj) || count($obj) == 0)
                        return redirect()->back()->withErrors(['error'=>'Something goes wrong. Please try again.'])->withInput();

                    $message = Auth::user()->first_name.' '.Auth::user()->last_name. " donate $".$request->input($field).' to'
                        .$donateTo.' '.$obj->name;




                    $all = $request->all();
                    $all['message']=$message;

                    $response = User::donateUsingCreditCard($all);
                    if($response['success'])
                    {
                        //insert into site activity table for log.
                        $userIDHashID= new Hashids('user id hash',10,\Config::get('app.encode_chars'));
                        $user_id = $userIDHashID->encode(Auth::user()->id);

                        SiteActivity::create([
                            'user_id'=>Auth::user()->id,
                            'comment'=>'<a href="'.url('userprofiles/'.$user_id.'/'.strtolower(Auth::user()->first_name.'_'.Auth::user()->last_name)).'">'
                                .Auth::user()->first_name.' '.Auth::user()->last_name.'</a>
                                donate $'.$request->input($field).' to'.$donateTo.' '.$obj->name.' <a href="'.url($controller.'/'
                                .$hashID->encode
                                        ($obj->id).'/'
                                .$obj->slug).'">'.$obj->name.'</a>'
                        ]);
                        $addFunds['user_id']=Auth::user()->id;
                        $addFunds['amount']=$request->input($field);
                        $addFunds['transaction_type']='donated';
                        $addFunds['fund_type']=$donateTo;
                        // insert record into funds table to maintain fund availability for unit/objective/task
                        Fund::create($addFunds);

                        $request->session()->flash('msg_val', "Amount donate successfully");
                        $request->session()->flash('msg_type', "success");
                        return redirect($request->url());
                    }
                    else{
                        $request->session()->flash('msg_val', "Something goes wrong. Please try again.");
                        $request->session()->flash('msg_type', "error");
                        return redirect($request->url());
                    }

                }
                $creditedBalance = Transaction::where('user_id',Auth::user()->id)->where('trans_type','credit')->sum('amount');
                $debitedBalance = Transaction::where('user_id',Auth::user()->id)->where('trans_type','debit')->sum('amount');
                $availableBalance = $creditedBalance - $debitedBalance;
                view()->share('availableBalance',$availableBalance);

                $expiry_years = SiteConfigs::getCardExpiryYear();
                view()->share('expiry_years',$expiry_years);

                $users_cards = User::getAllCreditCards();
                view()->share('credit_cards',$users_cards);

                $msg_flag = false;
                $msg_val = '';
                $msg_type = '';
                if($request->session()->has('msg_val')){
                    $msg_val =  $request->session()->get('msg_val');
                    $request->session()->forget('msg_val');
                    $msg_type = $request->session()->get('msg_type');
                    $request->session()->forget('msg_type');
                    $msg_flag = true;
                }
                view()->share('msg_flag',$msg_flag);
                view()->share('msg_val',$msg_val);
                view()->share('msg_type',$msg_type);

                view()->share('availableFunds',$availableFunds);
                view()->share('awardedFunds',$awardedFunds);
                view()->share('obj',$obj);
                view()->share('donateTo',$donateTo);
                return view('funds.donation');
            }
        }
        return view('errors.404');
    }

    public function get_card_name(Request $request){
        $allCards = User::getAllCreditCards();
        $last4= $request->input('last4');
        $brand='';
        if(isset($allCards->data) && count($allCards->data) > 0){
            foreach($allCards->data as $card)
            {
                if($card->last4 == $last4)
                    $brand =  $card->brand;
            }
        }
        if($brand =="American Express")
            return 'amex.png';
        if($brand == "Discover")
            return 'discover.png';
        if($brand == "MasterCard")
            return 'mastercard.png';
        if($brand == "Visa")
            return 'visa.png';
        if($brand == "Diners Club")
            return 'dinersclub.png';
        if($brand == "JCB")
            return 'jcb.png';

    }
    public function show()
    {

    }
}
