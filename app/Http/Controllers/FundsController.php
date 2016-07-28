<?php

namespace App\Http\Controllers;

use App\ActivityPoint;
use App\AreaOfInterest;
use App\City;
use App\Country;
use App\CreditCards;
use App\Fund;
use App\JobSkill;
use App\Objective;
use App\Paypal;
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
                    if($exists){
                        $obj= Unit::getObj($id);
                        $donateTo =" unit ";
                        $controller="units";
                        $addFunds=['unit_id'=>$obj->id];
                        $hashID= new Hashids('unit id hash',10,\Config::get('app.encode_chars'));
                        $availableFunds =Fund::getUnitDonatedFund($obj->id);
                        $awardedFunds =Fund::getUnitAwardedFund($obj->id);
                    }
                    break;
                case 'objective':
                    $exists = Objective::checkObjectiveExist($id,true);
                    if($exists){
                        $obj= Objective::getObj($id);
                        $donateTo =" objective ";
                        $controller="objectives";
                        $addFunds=['objective_id'=>$obj->id];
                        $hashID= new Hashids('objective id hash',10,\Config::get('app.encode_chars'));
                        $availableFunds =Fund::getObjectiveDonatedFund($obj->id);
                        $awardedFunds =Fund::getObjectiveAwardedFund($obj->id);
                    }
                    break;
                case 'task':
                    $exists = Task::checkUnitExist($id,true);
                    if($exists){
                        $obj= Task::getObj($id);
                        $donateTo =" task ";
                        $controller="tasks";
                        $addFunds=['task_id'=>$obj->id];
                        $hashID= new Hashids('task id hash',10,\Config::get('app.encode_chars'));
                        $availableFunds =Fund::getTaskDonatedFund($obj->id);
                        $awardedFunds =Fund::getTaskAwardedFund($obj->id);
                    }
                    break;
                case 'user':
                    $exists = User::checkUserExist($id,true);
                    if($exists){
                        $obj= User::getObj($id);
                        $obj->name=$obj->first_name.' '.$obj->last_name;
                        $obj->slug=strtolower($obj->first_name.'_'.$obj->last_name);
                        $donateTo =" user ";
                        $controller="userprofiles";
                        $addFunds=['task_id'=>$obj->id];
                        $hashID= new Hashids('user id hash',10,\Config::get('app.encode_chars'));
                        $availableFunds =Fund::getUserDonatedFund($obj->id);
                        $awardedFunds =Fund::getUserAwardedFund($obj->id);

                        $skills = [];
                        if(!empty($obj->job_skills))
                            $skills = JobSkill::whereIn('id',explode(",",$obj->job_skills))->get();

                        $interestObj = [];
                        if(!empty($obj->job_skills))
                            $interestObj = AreaOfInterest::whereIn('id',explode(",",$obj->area_of_interest))->get();

                        view()->share('interestObj',$interestObj);
                        view()->share('skills',$skills);
                    }
                    break;
                default:
                    $exists=false;
                    break;
            }

            if($exists){
                if($request->isMethod('post')){
                    $user_credit_card_id = Auth::user()->credit_card_id;
                    $field = 'cc-amount';
                    $inputData = $request->all();
                    if(!empty($user_credit_card_id)){
                        $field="amount_reused_card";
                        $validator = \Validator::make($inputData, [
                            'amount_reused_card'=> 'required|numeric'
                        ]);
                    }else{
                        $inputData['cc-number'] = str_replace(" ","",$inputData['cc-number']);
                        $validator = \Validator::make($inputData, [
                            'cc-amount'=> 'required|numeric',
                            'cc-card-type'=>'required',
                            'exp_month'=>'required',
                            'exp_year'=>'required',
                            'cc-number'=>'required|numeric'
                        ]);
                    }

                    if ($validator->fails())
                        return redirect()->back()->withErrors($validator)->withInput();

                    if(empty($obj) || count($obj) == 0)
                        return redirect()->back()->withErrors(['error'=>'Something goes wrong. Please try again.'])->withInput();

                    $amount = $request->input($field);
                    $paypalFees = (($amount * 2.9)/100) + 0.3;
                    $amount = $amount - $paypalFees ;
                    $message = Auth::user()->first_name.' '.Auth::user()->last_name. " donate $".$amount.' to'.$donateTo.$obj->name;

                    $inputData['message']=$message;

                    // Donate amount to Unit/Objective/Task/User
                    $response = User::donateAmount($inputData);
                    if($response['success'])
                    {
                        //insert into site activity table for log.
                        $userIDHashID= new Hashids('user id hash',10,\Config::get('app.encode_chars'));
                        $user_id = $userIDHashID->encode(Auth::user()->id);

                        SiteActivity::create([
                            'user_id'=>Auth::user()->id,
                            'comment'=>'<a href="'.url('userprofiles/'.$user_id.'/'.strtolower(Auth::user()->first_name.'_'.Auth::user()->last_name)).'">'
                                .Auth::user()->first_name.' '.Auth::user()->last_name.'</a>
                                donate $'.$amount.' to'.$donateTo.' <a href="'.url($controller.'/'
                                .$hashID->encode($obj->id).'/'.$obj->slug).'">'.$obj->name.'</a>'
                        ]);
                        if($type == "user"){
                            Transaction::create([
                                'created_by'=>Auth::user()->id,
                                'user_id'=>$obj->id,
                                'amount'=>$amount,
                                'trans_type'=>'credit',
                                'comments'=>'$'.$amount.' donation received from '.Auth::user()->first_name.' '.Auth::user()->last_name
                            ]);
                        }
                        else{
                            $addFunds['user_id']=Auth::user()->id;
                            $addFunds['amount']=$amount;
                            $addFunds['transaction_type']='donated';
                            $addFunds['fund_type']=$donateTo;
                            // insert record into funds table to maintain fund availability for unit/objective/task
                            Fund::create($addFunds);
                        }

                        $request->session()->flash('msg_val', "Amount donate successfully");
                        $request->session()->flash('msg_type', "success");
                        return redirect($request->url());
                    }
                    else{
                        $request->session()->flash('msg_val', $response['error_msg']);
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

                $users_cards=[];
                if(!empty(Auth::user()->credit_card_id))
                    $users_cards= Paypal::getCreditCard(Auth::user()->credit_card_id);
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
