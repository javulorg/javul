<?php

namespace App\Http\Controllers;

use App\Alerts;
use App\Http\Requests;
use App\Objective;
use App\SiteActivity;
use App\Task;
use App\Unit;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Hashids\Hashids;
use Illuminate\Support\Facades\Config;
use PayPal\Service\AdaptivePaymentsService;
use PayPal\Types\AP\PaymentDetailsRequest;
use PayPal\Types\AP\PayRequest;
use PayPal\Types\AP\Receiver;
use PayPal\Types\AP\ReceiverList;
use PayPal\Types\Common\RequestEnvelope;

class AlertsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth',['except'=>['index']]);
    }

    public function set_alert(Request $request){
        $flag = $request->input('flag');
        $field_name = $request->input('field_name');
        if(!empty($field_name)){
            $alertObj = Alerts::where('alert_name','=',$field_name)->first();
            if(!empty($alertObj) && count($alertObj) > 0){
                $val = 1;
                if($flag == "false")
                    $val=0;
                $alertObj->update(['alert_status'=>$val]);
                return \Response::json(['success'=>true]);
            }
        }
        return \Response::json(['success'=>false]);
    }
}
