<?php

namespace App\Http\Controllers;

use App\City;
use App\Fund;
use App\Http\Requests;
use App\Library\Helpers;
use App\Objective;
use App\Paypal;
use App\PaypalTransaction;
use App\SiteActivity;
use App\SiteConfigs;
use App\State;
use App\Task;
use App\Transaction;
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
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
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

        // current logged in user available balance
        $creditedBalance = Fund::getUserDonatedFund(Auth::user()->id);
        $debitedBalance = Fund::getUserAwardedFund(Auth::user()->id);
        $availableBalance = $creditedBalance - $debitedBalance;
        view()->share('availableBalance',$availableBalance);

        $users_card=[];
        /*if(!empty(Auth::user()->credit_card_id))
            $users_card= Paypal::getCreditCard(Auth::user()->credit_card_id);*/
        view()->share('users_cards',$users_card);

        //expiry years of card
        $expiry_years = SiteConfigs::getCardExpiryYear();

        view()->share('expiry_years',$expiry_years);
        return view('users.my_account');
    }

    /**
     * Function will transfer money from seller account to user accout (paypal only).
     * @param Request $request
     * @return $this
     */
    public function withdraw(Request $request){


        if(empty(Auth::user()->paypal_email)){
            $validator = \Validator::make($request->all(), [
                'paypal_email'=> 'required|email'
            ]);
            if ($validator->fails()){
                $errors = $validator->messages()->toArray();
                foreach($errors as $index=>$err)
                    $errors[$index]=$err[0];

                $errors['active'] = 'withdraw';
                return \Response::json(['success'=>false,'errors'=>$errors]);
            }
            $paypal_email = $request->input('paypal_email');
        }
        else
            $paypal_email=Auth::user()->paypal_email;


        /*$requestedAmount = $request->input('cc-amount');
        $isCurrency = Helpers::isCurrency($requestedAmount);
        if(!$isCurrency)
            return \Response::json(['success'=>false,'errors'=>['error'=>'Please enter amount correctly.']]);*/

        $checkEmailExist = Paypal::checkEmailExistINPaypal($paypal_email);

        if(!$checkEmailExist['success'] && $checkEmailExist['timeout_error'])
            return \Response::json(['success'=>false,'errors'=>['error'=>'Could not connect to Paypal. Please try again later']]);
        else if(!$checkEmailExist['success'])
            return \Response::json(['success'=>false,'errors'=>['error'=>'Email does not exist in Paypal']]);
        else if($checkEmailExist['success']){
            Auth::user()->paypal_email = $paypal_email;
            Auth::user()->save();

            $creditedBalance = Fund::getUserDonatedFund(Auth::user()->id);
            $debitedBalance = Fund::getUserAwardedFund(Auth::user()->id);
            $availableBalance = $creditedBalance - $debitedBalance;

            $orderIDHashID= new Hashids('order id hash',10,\Config::get('app.encode_chars'));

            $transactionData['created_by'] =Auth::user()->id;
            $transactionData['user_id'] =Auth::user()->id;
            $transactionData['amount'] =$availableBalance;
            $transactionData['comments']='$'.$availableBalance.' withdrawn by '.Auth::user()->first_name.' '.Auth::user()->last_name;
            $transactionData['trans_type'] ='debit';
            $transactionID = Transaction::create($transactionData)->id;


            //transfer requested amount to user on given email id. (paypal)
            $data['paypal_email'] =Auth::user()->paypal_email;
            $data['cc-amount'] =$availableBalance;
            $data['returnURL'] = url('funds/success?type=user&orderID='.$orderIDHashID->encode($transactionID));
            $data['cancelURL'] = url('funds/cancel?type=user&orderID='.$orderIDHashID->encode($transactionID));
            $data['ajax'] = true;

            $payment = Paypal::transferAmountToUser($data);
            $transactionObj = Transaction::find($transactionID);

            if(!$payment['success']){
                $transactionObj->update(['status'=>'cancelled']);
                return \Response::json(['success'=>false,'errors'=>['error'=>'Could not connect to Paypal. Please try again later.']]);
            }

            if($payment['success'] && !empty($payment['paymentResponse'])){
                if(count($transactionObj) > 0 && !empty($transactionObj)){
                    if($payment['status'] == "completed")
                        $payment['status']="approved";
                    $transactionObj->update(['pay_key'=>$payment['paykey'],'status'=>strtolower($payment['status'])]);
                }

                // insert actual paypal response in database
                PaypalTransaction::create([
                    'transaction_id'=>$transactionID,
                    'fund_id'=>null,
                    'donate_paypal_id'=>null,
                    'pay_key'=>$payment['paykey']
                ]);


                $creditedBalance = Transaction::where('user_id',Auth::user()->id)->where('trans_type','credit')->sum('amount');
                $debitedBalance = Transaction::where('user_id',Auth::user()->id)->where('trans_type','debit')->sum('amount');
                $availableBalance = $creditedBalance - $debitedBalance;

                return \Response::json(['success'=>true,'availableBalance'=>number_format($availableBalance,2)]);
            }
            else
                $transactionObj->update(['status'=>'cancelled']);
            $transactionObj->update(['status'=>'cancelled']);
            return \Response::json(['success'=>false,'errors'=>['error'=>'Something goes wrong. Please try again later.']]);
        }
    }

    /**
     * Function will check. email exist in paypal or not.
     * @param Request $request
     * @return mixed
     */
    public function paypal_email_check(Request $request){
        $email = $request->input('paypal_email');
        $validator = \Validator::make($request->all(), [
            'paypal_email'=> 'required|email'
        ]);
        if ($validator->fails())
            return \Response::json(['success'=>false,'message'=>'Email is invalid.']);

        $checkEmailExist = Paypal::checkEmailExistINPaypal($email);

        if(!$checkEmailExist['success'] && $checkEmailExist['timeout_error'])
            return \Response::json(['success'=>false,'message'=>'Could not connect to Paypal. Please try again later.' ]);
        else if(!$checkEmailExist['success'] && !$checkEmailExist['timeout_error'])
            return \Response::json(['success'=>false,'message'=>'Email address does not exist in Paypal.' ]);

        if($checkEmailExist['success'])
            return \Response::json(['success'=>true]);
    }

    public function update_creditcard(Request $request){
        $inputData = $request->all();
        $inputData['cc-number'] = str_replace(" ","",$inputData['cc-number']);
        $validator = \Validator::make($inputData, [
            'cc-card-type'=>'required',
            'exp_month'=>'required',
            'exp_year'=>'required',
            'cc-number'=>'required|numeric'
        ],[
            'cc-card-type.required'=>'Please select card type',
            'exp_month.required'=>'Please select expire month',
            'exp_year.required'=>'Please select expire year',
            'cc-number.required'=>'Please enter card number',
            'cc-number.numeric'=>'Card number must be numeric'
        ]);

        if ($validator->fails())
            return \Response::json(['success'=>false,'errors'=>$validator->errors()]);

        $saveCardResponse = Paypal::saveCard($inputData);
        if($saveCardResponse['success'])
            return \Response::json(['success'=>true]);
        else if($saveCardResponse['timeout_error'])
            return \Response::json(['success'=>false,'errors'=>['error'=>'Could not connect to Paypal. Please try again later.']]);
    }
    public function logout(){
        return redirect('logout');
    }


}
