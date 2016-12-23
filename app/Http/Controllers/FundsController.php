<?php

namespace App\Http\Controllers;

use App\ActivityPoint;
use App\AreaOfInterest;
use App\City;
use App\Country;
use App\CreditCards;
use App\Fund;
use App\JobSkill;
use App\Library\Helpers;
use App\Objective;
use App\Paypal;
use App\PaypalTransaction;
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
use Illuminate\Support\Facades\URL;


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
                $creditedBalance = Transaction::where('user_id',Auth::user()->id)->where('trans_type','credit')->sum('amount');
                $debitedBalance = Transaction::where('user_id',Auth::user()->id)->where('trans_type','debit')->sum('amount');
                $availableBalance = $creditedBalance - $debitedBalance;
                view()->share('availableBalance',$availableBalance);

                $expiry_years = SiteConfigs::getCardExpiryYear();
                view()->share('expiry_years',$expiry_years);

                $users_cards=[];
                /*if(!empty(Auth::user()->credit_card_id))
                    $users_cards= Paypal::getCreditCard(Auth::user()->credit_card_id);*/

                $formType = Helpers::encrypt_decrypt('encrypt','new');
                if(!empty($users_cards))
                    $formType = Helpers::encrypt_decrypt('encrypt','old');
                view()->share('formType',$formType);
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

    public function donate_amount(Request $request){
        if($request->isMethod('post')){

            //check payment from new credit card or old?
           /* $fromType = $request->input('frmTyp');
            $fromType = Helpers::encrypt_decrypt('decrypt',$fromType);
            if($fromType != "new" && $fromType != "old")
                return \Response::json(['success'=>false,'errors'=>['error'=>'Something goes wrong. Please try again.']]);*/

            $url = URL::previous();
            $url =explode("/",$url );
            $type = $url[5]; // for local 6. for live 5
            $id = $url[6]; // for localhost 7. for live 6
            $exists = false;
            $obj = [];
            $donateTo = '';
            $hashID='';
            $controller = '';
            $addFunds = [];

            switch($type){
                case 'unit':
                    $exists = Unit::checkUnitExist($id,true);
                    if($exists){
                        $obj= Unit::getObj($id);
                        $donateTo =" unit ";
                        $controller="units";
                        $addFunds=['unit_id'=>$obj->id];
                        $hashID= new Hashids('unit id hash',10,\Config::get('app.encode_chars'));
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
                    }
                    break;
                default:
                    $exists=false;
                    break;
            }
            if($exists){
                $inputData = $request->all();
                $validator = \Validator::make($inputData, [
                    'donate_amount'=> 'required|numeric'
                ],[
                    'donate_amount.required'=>'Please enter amount to donate',
                    'donate_amount.numeric'=>'Amount must be numeric'
                ]);


                if ($validator->fails()){
                    return redirect()->back()->withErrors($validator)->withInput();
                }

                if(empty($obj) || count($obj) == 0)
                    return redirect()->back()->withErrors(['error'=>'Something goes wrong. Please try again.'])->withInput();

                $amount = $request->input('donate_amount');
                $paypalFees = (($amount * 2.9)/100) + 0.3;
                $amount = $amount - $paypalFees ;
                $message = Auth::user()->first_name.' '.Auth::user()->last_name. " donate $".$amount.' to'.$donateTo.$obj->name;

                $inputData['message']=$message;

                $transactionID = null;
                $fundID = null;
                $orderIDHashID= new Hashids('order id hash',10,\Config::get('app.encode_chars'));
                if($type == "user"){
                    $transactionData['created_by'] =Auth::user()->id;
                    $transactionData['user_id'] =$obj->id;
                    $transactionData['amount'] =$amount;
                    $transactionData['comments']='$'.$amount.' donation received from '.Auth::user()->first_name.' '.Auth::user()->last_name;

                    if(!empty($obj->paypal_email))
                        $transactionData['trans_type'] ='paypal';
                    else
                        $transactionData['trans_type'] ='credit';

                    $transactionID = Transaction::create($transactionData)->id;

                    $inputData['returnURL'] = url('funds/success?type='.$type.'&orderID='.$orderIDHashID->encode($transactionID));
                    $inputData['cancelURL'] = url('funds/cancel?type='.$type.'&orderID='.$orderIDHashID->encode($transactionID));
                }
                else{
                    $addFunds['user_id']=Auth::user()->id;
                    $addFunds['amount']=$amount;
                    $addFunds['transaction_type']='donated';
                    $addFunds['fund_type']=$donateTo;

                    $fundID = Fund::create($addFunds)->id;

                    $inputData['returnURL'] = url('funds/success?type='.$type.'&orderID='.$orderIDHashID->encode($fundID) );
                    $inputData['cancelURL'] = url('funds/cancel?type='.$type.'&orderID='.$orderIDHashID->encode($fundID));
                }

                if($type == "user" && !empty($obj->paypal_email)){
                    $inputData['cc-amount'] = $request->input('donate_amount');
                    $inputData['paypal_email'] = $obj->paypal_email;
                    $response = Paypal::transferAmountToUser($inputData);
                    if($response['success'])
                        $response['url'] =env('ADAPTIVE_PAYMENT_URL').$response['paykey'];

                    $alertObj = Alerts::where('user_id',$obj->id)->first();
                    if(!empty($alertObj) && $alertObj->fund_received == 1) {
                        $toEmail = $obj->email;
                        $toName= $obj->first_name.' '.$obj->last_name;
                        $subject = $amount.' fund received from '.Auth::user()->email;

                        \Mail::send('emails.fund_received', ['userObj' => Auth::user(), 'amount' => $amount], function($message) use($toEmail, $toName, $subject) {
                            $message->to($toEmail, $toName)->subject($subject);
                            $message->from(\Config::get("app.support_email"), \Config::get("app.site_name"));
                        });
                    }
                }
                else
                    $response = User::donateAmount($inputData);

                // Donate amount to Unit/Objective/Task/User
                //dd($response);
                if($response['success'])
                {
                    // update payment id field to respective tables.
                    if($type == "user"){
                        $transactionObj = Transaction::find($transactionID);
                        if(count($transactionObj) > 0 && !empty($transactionObj)){
                            if(!empty($obj->paypal_email))
                                $transactionObj->update(['pay_key'=>$response['paykey'],'status'=>strtolower($response['status'])]);
                            else
                                $transactionObj->update(['pay_key'=>$response['payment_id'],'status'=>strtolower($response['status'])]);
                        }
                    }
                    else{
                        $fundObj = Fund::find($fundID);
                        if(count($fundObj ) > 0 && !empty($fundObj)){
                            $fundObj->update(['payment_id'=>$response['payment_id'],'status'=>strtolower($response['status'])]);
                        }
                    }
                    return redirect()->away($response['url']);
                }
                else
                    return redirect()->back()->withErrors(['error'=>'Something goes wrong. Please try again later.'])->withInput();
            }
        }
    }

    public function success(Request $request)
    {
        $paymentID = $request->input('paymentId');
        $payerID =$request->input('PayerID');
        $type = $request->input('type');
        $orderID = $request->input('orderID');

        $orderIDHashID= new Hashids('order id hash',10,\Config::get('app.encode_chars'));
        $orderID = $orderIDHashID->decode($orderID);

        $message="Something goes wrong. Please try again later.";
        $messageType = false;
        $obj = [];
        $payment_id = '';
        if(!empty($orderID)){
            $orderID  = $orderID[0];
            if($type == "user")
                $obj = Transaction::find($orderID);
            else
                $obj = Fund::find($orderID);

            // if user refresh the page then redirect to unit home page.
            if($obj->status == "approved")
                return redirect('units');


            if(!empty($obj) && $obj->status != "approved"){
                $db_payment_id = $obj->payment_id;
                $flag = false;
                if($type == "user")
                {
                    $obj->update(['status'=>'approved']);

                    $donateToObj = User::find($obj->user_id);
                    if(!empty($donateToObj))
                    {
                        $db_payment_id = $obj->pay_key;
                        if(empty($donateToObj->paypal_email))
                            $payment = Paypal::executePayment($db_payment_id ,$payerID);
                        else
                            $payment['success']= true;
                        $flag = true;
                    }
                }
                else{
                    $payment = Paypal::executePayment($db_payment_id ,$payerID);
                    if(!empty($payment['payment']))
                        $flag = true;

                }

                if($payment['success'] && $flag ){
                    $controller = '';
                    $hashID='';
                    $donateTo ='';
                    $dataObj = '';
                    if($type == "user"){
                        $payment_id = $obj->pay_key;
                        $data['pay_key'] = $obj->pay_key;
                        $data['transaction_id'] = $orderID;
                        $donateTo = ' user ';
                        $controller = 'userprofiles';
                        $dataObj = User::find($obj->user_id);
                        $dataObj->name=$dataObj->first_name.' '.$dataObj->last_name;
                        $dataObj->slug=strtolower($dataObj->first_name.'_'.$dataObj->last_name);
                        $hashID= new Hashids('user id hash',10,\Config::get('app.encode_chars'));
                    }
                    else{
                        $payment_id = $obj->payment_id;
                        $data['donate_paypal_id'] = $paymentID;
                        $data['fund_id'] = $orderID;
                        $obj->update(['status'=>$payment['payment']->getState()]);

                        if(!empty($obj->unit_id)){
                            $controller = "units";
                            $donateTo = ' unit ';
                            $dataObj = Unit::find($obj->unit_id);
                            $hashID= new Hashids('unit id hash',10,\Config::get('app.encode_chars'));
                        }
                        if(!empty($obj->task_id)){
                            $controller = "tasks";
                            $donateTo = ' task ';
                            $dataObj = Task::find($obj->task_id);
                            $hashID= new Hashids('task id hash',10,\Config::get('app.encode_chars'));
                        }
                        if(!empty($obj->objective_id)){
                            $controller = "objectives";
                            $donateTo = ' objective ';
                            $dataObj = Objective::find($obj->objective_id);
                            $hashID= new Hashids('objective id hash',10,\Config::get('app.encode_chars'));
                        }
                    }

                    //insert into site activity table for log.
                    $userIDHashID= new Hashids('user id hash',10,\Config::get('app.encode_chars'));
                    $user_id = $userIDHashID->encode(Auth::user()->id);

                    SiteActivity::create([
                        'user_id'=>Auth::user()->id,
                        'comment'=>'<a href="'.url('userprofiles/'.$user_id.'/'.strtolower(Auth::user()->first_name.'_'.Auth::user()->last_name)).'">'
                            .Auth::user()->first_name.' '.Auth::user()->last_name.'</a>
                                        donate $'.$obj->amount.' to'.$donateTo.' <a href="'.url($controller.'/'
                                .$hashID->encode($dataObj->id).'/'.$dataObj->slug).'">'.$dataObj->name.'</a>'
                    ]);

                    // store actual paypal transaction details.
                    PaypalTransaction::create($data);
                    $message="Thank you for your payment.";
                    $messageType =true;
                }
                else
                    $obj->update(['status'=>'cancelled']);
            }
        }
        view()->share('payment_id',$payment_id);
        view()->share('obj',$obj);
        view()->share('messageType',$messageType);
        view()->share('message',$message);
        return view('funds.success');
    }

    public function cancel(Request $request){
        $paymentID = $request->input('paymentId');
        $payerID =$request->input('PayerID');
        $type = $request->input('type');
        $orderID = $request->input('orderID');

        $orderIDHashID= new Hashids('order id hash',10,\Config::get('app.encode_chars'));
        $orderID = $orderIDHashID->decode($orderID);

        $message="Payment cancelled successfully.";
        $messageType = false;
        $obj = [];
        $payment_id = '';
        if(!empty($orderID)){
            $orderID  = $orderID[0];

            if($type == "user")
                $obj = Transaction::find($orderID);
            else{
                $obj = Fund::find($orderID);
            }

            // if user refresh the page then redirect to unit home page.
            if($obj->status == "approved" || $obj->status == "cancelled" )
                return redirect('units');


            if(!empty($obj) && $obj->status != "approved"){
                $obj->update(['status'=>'cancelled']);
                if($type == "user")
                    $payment_id = $obj->pay_key;
                else
                    $payment_id = $obj->payment_id;
            }
        }
        view()->share('payment_id',$payment_id);
        view()->share('obj',$obj);
        view()->share('messageType',$messageType);
        view()->share('message',$message);
        return view('funds.cancel');
    }
    public function show()
    {

    }
}
