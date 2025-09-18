<?php

namespace App\Http\Controllers;

use App\Models\AreaOfInterest;
use App\Models\Fund;
use App\Models\Issue;
use App\Models\JobSkill;
use App\Library\Helpers;
use App\Models\Objective;
use App\Models\Paypal;
use App\Models\PaypalTransaction;
use App\Models\SiteConfigs;
use App\Models\Task;
use App\Models\Idea;
use Illuminate\Support\Facades\DB;
use App\Services\SiteActivity\SiteActivityService;

use App\Models\TaskRatings;
use App\Models\Transaction;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Hashids\Hashids;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use App\Models\Zcash;
use Illuminate\Support\Facades\Validator;
use Hashids\Hashids;

// use Vinkla\Hashids\Facades\Hashids;

class FundsController extends Controller
{
    protected $service;

    public function __construct(SiteActivityService $service)
    {
        $this->service = $service;

        $this->middleware('auth', ['except' => ['donate_to_unit_objective_task', 'donate_amount', 'transfer_from_unit', 'success', 'cancel']]);
    }



    public function index(Request $request)
    {
        $msg_flag = false;
        $msg_val = '';
        $msg_type = '';
        if ($request->session()->has('msg_val')) {
            $msg_val =  $request->session()->get('msg_val');
            $request->session()->forget('msg_val');
            $msg_flag = true;
            $msg_type = "success";
        }
        view()->share('msg_flag', $msg_flag);
        view()->share('msg_val', $msg_val);
        view()->share('msg_type', $msg_type);

        // get all units for listing


        $units = Unit::getUnitWithCategories();
        view()->share('units', $units);
        $rating_points = '';
        $obj = [];

        return view('funds.donation', ['rating_points' => $rating_points, 'obj' => $obj]);
    }


    public function donate_to_unit_objective_task(Request $request, $id)
    {
        if (!empty($id)) {
            $type = $request->segment(3);
            //sharing current payment method flag
            $current_payment_method = env("PAYMENT_METHOD");
            view()->share("current_payment_method", $current_payment_method);
            //$exists = false;
            $obj = [];
            $donateTo = '';
            //$hashID='';
            //$controller = '';
            //$addFunds = [];
            $availableFunds = 0;
            $awardedFunds = 0;
            $rating_points = '';
            switch ($type) {
                case 'unit':
                    $exists = Unit::checkUnitExist($id, true);
                    if ($exists) {
                        $obj = Unit::getObj($id);
                        $donateTo = " unit ";
                        //$controller="units";
                        //$addFunds=['unit_id'=>$obj->id];
                        //$hashID= new Hashids('unit id hash',10,\Config::get('app.encode_chars'));
                        $availableFunds = Fund::getUnitDonatedFund($obj->id);
                        $awardedFunds = Fund::getUnitAwardedFund($obj->id);
                    }
                    break;
                case 'objective':
                    $exists = Objective::checkObjectiveExist($id, true);
                    if ($exists) {
                        $obj = Objective::getObj($id);
                        $donateTo = " objective ";
                        //$controller="objectives";
                        //$addFunds=['objective_id'=>$obj->id];
                        //$hashID= new Hashids('objective id hash',10,\Config::get('app.encode_chars'));
                        $availableFunds = Fund::getObjectiveDonatedFund($obj->id);
                        $awardedFunds = Fund::getObjectiveAwardedFund($obj->id);
                    }
                    break;
                case 'task':
                    $exists = Task::checkUnitExist($id, true);
                    if ($exists) {
                        $obj = Task::getObj($id);
                        $donateTo = " task ";
                        //$controller="tasks";
                        //$addFunds=['task_id'=>$obj->id];
                        //$hashID= new Hashids('task id hash',10,\Config::get('app.encode_chars'));
                        $availableFunds = Fund::getTaskDonatedFund($obj->id);
                        $awardedFunds = Fund::getTaskAwardedFund($obj->id);
                    }
                    break;
                case 'issue':
                    $exists = Issue::checkIssueExist($id, true);
                    if ($exists) {
                        $obj = Issue::getObj($id);
                        // dd($obj);
                        $obj->name = $obj->title;
                        $donateTo = " issue ";

                        //$controller="tasks";
                        //$addFunds=['task_id'=>$obj->id];
                        //$hashID= new Hashids('task id hash',10,\Config::get('app.encode_chars'));
                        $availableFunds = Fund::getIssueDonatedFund($obj->id);
                        $awardedFunds = Fund::getIssueAwardedFund($obj->id);
                    }
                    break;
                case 'idea':

                    $hashID = new Hashids('unit id hash', 10, Config::get('app.encode_chars'));
                    $decoded = $hashID->decode($id);

                    if (!empty($decoded)) {
                        $realId = $decoded[0];
                        $exists = Idea::where('id', $realId)->exists();



                        if ($exists) {
                            $obj = Idea::where('id', $realId)->get();
                            $title = $obj->first()->title;
                            $obj->id = $obj->first()->id;
                            $obj->name = $title;
                            $donateTo = " Idea ";

                            //$controller="tasks";
                            //$addFunds=['task_id'=>$obj->id];
                            //$hashID= new Hashids('task id hash',10,\Config::get('app.encode_chars'));
                            $availableFunds = Fund::getIssueDonatedFund($obj->id);
                            $awardedFunds = Fund::getIssueAwardedFund($obj->id);
                        }
                    }
                    break;
                case 'user':
                    $exists = User::checkUserExist($id, true);
                    if ($exists) {
                        $obj = User::getObj($id);
                        if (!$obj->paypal_email) {
                            return redirect()->back();
                        }
                        $obj->name = $obj->first_name . ' ' . $obj->last_name;
                        $obj->slug = strtolower($obj->first_name . '_' . $obj->last_name);
                        $donateTo = " user ";
                        //$controller="userprofiles";
                        //$addFunds=['task_id'=>$obj->id];
                        //$hashID= new Hashids('user id hash',10,\Config::get('app.encode_chars'));
                        $availableFunds = Fund::getUserDonatedFund($obj->id);
                        $awardedFunds = Fund::getUserAwardedFund($obj->id);

                        $rating_points = TaskRatings::where('user_id', $obj->id)->sum('quality_of_work');
                        $total_rating_points = TaskRatings::where('user_id', $obj->id)->count();
                        if (is_null($rating_points))
                            $rating_points = 0;
                        else if ($rating_points > 0) {
                            $rating_points = $rating_points / $total_rating_points;
                            if (is_float($rating_points))
                                $rating_points = round($rating_points, 1);
                        }



                        $skills = [];
                        if (!empty($obj->job_skills))
                            $skills = JobSkill::whereIn('id', explode(",", $obj->job_skills))->get();

                        $interestObj = [];
                        if (!empty($obj->job_skills))
                            $interestObj = AreaOfInterest::whereIn('id', explode(",", $obj->area_of_interest))->get();

                        view()->share('interestObj', $interestObj);
                        view()->share('skills', $skills);
                    }
                    break;
                default:
                    $exists = false;
                    break;
            }

            if (!$exists) {
                //$creditedBalance = 50;//Transaction::where('user_id',Auth::user()->id)->where('trans_type','credit')->sum('amount');
                //$debitedBalance = 10;//Transaction::where('user_id',Auth::user()->id)->where('trans_type','debit')->sum('amount');
                //$availableBalance = $creditedBalance - $debitedBalance;
                $availableBalance = 0;
                view()->share('availableBalance', $availableBalance);

                $expiry_years = SiteConfigs::getCardExpiryYear();
                view()->share('expiry_years', $expiry_years);

                $users_cards = [];
                /*if(!empty(Auth::user()->credit_card_id))
                    $users_cards= Paypal::getCreditCard(Auth::user()->credit_card_id);*/

                $formType = Helpers::encrypt_decrypt('encrypt', 'new');
                if (!empty($users_cards))
                    $formType = Helpers::encrypt_decrypt('encrypt', 'old');
                view()->share('formType', $formType);
                view()->share('credit_cards', $users_cards);

                $msg_flag = false;
                $msg_val = '';
                $msg_type = '';
                if ($request->session()->has('msg_val')) {
                    $msg_val =  $request->session()->get('msg_val');
                    $request->session()->forget('msg_val');
                    $msg_type = $request->session()->get('msg_type');
                    $request->session()->forget('msg_type');
                    $msg_flag = true;
                }
                view()->share('msg_flag', $msg_flag);
                view()->share('msg_val', $msg_val);
                view()->share('msg_type', $msg_type);

                view()->share('availableFunds', $availableFunds);
                view()->share('awardedFunds', $awardedFunds);
                view()->share('obj', $obj);

                view()->share('donateTo', $donateTo);
                view()->share('rating_points', $rating_points);
                return view('funds.donation', ['rating_points' => $rating_points]);
            }
        }
        $username = Auth::user()->username;
        $data = User::where('username', $username)->first();

        return view('funds.donation', ['rating_points' => $rating_points, 'obj' => $obj, 'data' => $data]);
    }




    public function donate_amount(Request $request)
    {
        if ($request->isMethod('post')) {

            //check payment from new credit card or old?
            /* $fromType = $request->input('frmTyp');
            $fromType = Helpers::encrypt_decrypt('decrypt',$fromType);
            if($fromType != "new" && $fromType != "old")
                return \Response::json(['success'=>false,'errors'=>['error'=>'Something goes wrong. Please try again.']]);*/

            $url = URL::previous();
            $url = explode("/", $url);
            $type = $url[5]; // for local 6. for live 5
            $id = $url[count($url) - 1]; // for localhost 7. for live 6
            $exists = false;
            $obj = [];
            $donateTo = '';
            $hashID = '';
            $controller = '';
            $addFunds = [];
            $current_payment_method = env("PAYMENT_METHOD");

            $donateToLink = '';
            switch ($type) {
                case 'unit':
                    $exists = Unit::checkUnitExist($id, true);
                    if ($exists) {
                        $obj = Unit::getObj($id);
                        $donateTo = " unit ";
                        $controller = "units";
                        $addFunds = ['unit_id' => $obj->id];
                        $hashID = new Hashids('unit id hash', 10, Config::get('app.encode_chars'));
                        $donateToLink = '<a href="' . url('units/' . $hashID->encode($obj->id) . '/' . $obj->slug) . '">' . $obj->name . '</a>';
                    }
                    break;
                case 'objective':
                    $exists = Objective::checkObjectiveExist($id, true);
                    if ($exists) {
                        $obj = Objective::getObj($id);
                        $donateTo = " objective ";
                        $controller = "objectives";
                        $addFunds = ['objective_id' => $obj->id];
                        $hashID = new Hashids('objective id hash', 10, Config::get('app.encode_chars'));
                        $donateToLink = '<a href="' . url('objectives/' . $hashID->encode($obj->id) . '/' . $obj->slug) . '">' . $obj->name . '</a>';
                    }
                    break;
                case 'task':
                    $exists = Task::checkUnitExist($id, true);
                    if ($exists) {
                        $obj = Task::getObj($id);
                        $donateTo = " task ";
                        $controller = "tasks";
                        $addFunds = ['task_id' => $obj->id];
                        $hashID = new Hashids('task id hash', 10, Config::get('app.encode_chars'));
                        $donateToLink = '<a href="' . url('tasks/' . $hashID->encode($obj->id) . '/' . $obj->slug) . '">' . $obj->name . '</a>';
                    }
                    break;
                case 'issue':
                    $exists = Issue::checkIssueExist($id, true);
                    if ($exists) {
                        $obj = Issue::getObj($id);
                        $donateTo = " issue ";
                        $controller = "issues";
                        $addFunds = ['issue_id' => $obj->id];
                        $hashID = new Hashids('issue id hash', 10, Config::get('app.encode_chars'));
                        $donateToLink = '<a href="' . url('issues/' . $hashID->encode($obj->id) . '/' . strtolower(substr($obj->title, 0, 4))) . '">' . $obj->title . '</a>';
                    }
                    break;

                case 'idea':
                    $exists = Idea::checkIdeaExist($id, true);

                    if ($exists) {
                        $obj = Idea::getObj($id);
                        $donateTo = " idea ";
                        $controller = "ideas";
                        $addFunds = ['idea_id' => $obj->id];
                        $hashID = new Hashids('idea id hash', 10, Config::get('app.encode_chars'));
                        $donateToLink = '<a href="' . url('ideas/' . $hashID->encode($obj->id) . '/' . strtolower(substr($obj->title, 0, 4))) . '">' . $obj->title . '</a>';
                    }
                    break;
                case 'user':
                    $exists = User::checkUserExist($id, true);
                    if ($exists) {
                        $obj = User::getObj($id);
                        $obj->name = $obj->first_name . ' ' . $obj->last_name;
                        $obj->slug = strtolower($obj->first_name . '_' . $obj->last_name);
                        $donateTo = " user ";
                        $controller = "userprofiles";
                        $addFunds = ['task_id' => $obj->id];
                        $hashID = new Hashids('user id hash', 10, Config::get('app.encode_chars'));
                        $donateToLink = '<a href="' . url('userprofiles/' . $hashID->encode($obj->id) . '/' . strtolower($obj->name)) . '">' . $obj->name . '</a>';
                    }
                    break;
                default:
                    $exists = false;
                    break;
            }
            if ($exists) {
                $response = null;
                $inputData = $request->all();
                if ($current_payment_method == "PAYPAL") {
                    $validator = Validator::make($inputData, [
                        'donate_amount' => 'required|numeric'
                    ], [
                        'donate_amount.required' => 'Please enter amount to donate',
                        'donate_amount.numeric' => 'Amount must be numeric'
                    ]);


                    if ($validator->fails()) {
                        return redirect()->back()->withErrors($validator)->withInput();
                    }
                }

                if (empty($obj) || count($obj) == 0)
                    return redirect()->back()->withErrors(['error' => 'Something goes wrong. Please try again.'])->withInput();

                $amount = $request->input('donate_amount');
                //$message = Auth::user()->first_name.' '.Auth::user()->last_name. " donate $".$amount.' to'.$donateTo.$obj->name;
                $message = "  $" . $amount . ' donate to' . $donateTo . $obj->name;

                $inputData['message'] = $message;

                $transactionID = null;
                $fundID = null;
                $orderIDHashID = new Hashids('order id hash', 10, Config::get('app.encode_chars'));
                if ($type == "user") {
                    $transactionData['created_by'] = 1; //Auth::user()->id;
                    $transactionData['user_id'] = $obj->id;
                    if (Auth::check())
                        // Donation changes start
                        $transactionData['user_id'] = Auth::user()->id;
                    // Donation changes end
                    if ($current_payment_method == "Zcash") {
                        $transactionData['trans_type'] = 'credit_zcash';
                    } else {
                        $transactionData['amount'] = $amount;
                        //$transactionData['comments']='$'.$amount.' donation received from '.Auth::user()->first_name.' '.Auth::user()->last_name;
                        $transactionData['comments'] = '$' . $amount . ' donation received';

                        if (!empty($obj->paypal_email))
                            $transactionData['trans_type'] = 'paypal';
                        else
                            $transactionData['trans_type'] = 'credit';
                    }

                    $transactionID = Transaction::create($transactionData)->id;
                    if ($current_payment_method == "Zcash") {
                        $inputData['transaction_id'] = $transactionID;
                        $response =  Zcash::received_donation($inputData);
                        return $response;
                    }

                    $inputData['returnURL'] = url('funds/success?type=' . $type . '&orderID=' . $orderIDHashID->encode($transactionID));
                    $inputData['cancelURL'] = url('funds/cancel?type=' . $type . '&orderID=' . $orderIDHashID->encode($transactionID));
                } else {
                    $addFunds['user_id'] = 1; //Auth::user()->id;
                    $addFunds['amount'] = $amount;
                    $addFunds['transaction_type'] = 'donated';
                    $addFunds['payment_method'] = $current_payment_method;
                    $addFunds['fund_type'] = $donateTo;
                    if (Auth::check())
                        // Donation changes start
                        $addFunds['user_id'] = Auth::user()->id;
                    // Donation changes end
                    $fundID = Fund::create($addFunds)->id;



                    $inputData['returnURL'] = url('funds/success?type=' . $type . '&orderID=' . $orderIDHashID->encode($fundID));
                    $inputData['cancelURL'] = url('funds/cancel?type=' . $type . '&orderID=' . $orderIDHashID->encode($fundID));
                }

                if ($current_payment_method == "PAYPAL") {
                    $inputData['donate_amount'] += 0.30;
                    $inputData['donate_amount'] = round($inputData['donate_amount'] / (1 - 0.029), 2);
                }
                //                if($type == "user" && !empty($obj->paypal_email)){
                //                    $inputData['cc-amount'] = $request->input('donate_amount');
                //                    $inputData['paypal_email'] = $obj->paypal_email;
                //                    $response = Paypal::transferAmountToUser($inputData);
                //                    if($response['success'])
                //                        $response['url'] =env('ADAPTIVE_PAYMENT_URL').$response['paykey'];
                //                }
                //                else
                //                if($type == "user" && !empty($obj->paypal_email)) {
                //                    $response = User::donateAmount($inputData);
                //                }

                if ($type == "user" && !empty($obj->paypal_email)) {
                    $inputData['cc-amount'] = $inputData['donate_amount'];
                    $inputData['paypal_email'] = $obj->paypal_email;
                    $response = Paypal::transferAmountToUser($inputData);
                    if ($response['success'])
                        $response['url'] = env('ADAPTIVE_PAYMENT_URL') . $response['paykey'];
                } else {
                    if ($current_payment_method == "Zcash") {
                        $inputData['fundID'] = $fundID;
                        $response =  Zcash::received_donation($inputData);
                        return $response;
                    } else {
                        $response = User::donateAmount($inputData);
                    }
                }

                // Donate amount to Unit/Objective/Task/User
                //dd($response);
                if ($response && $response['success']) {
                    // update payment id field to respective tables.
                    if ($type == "user") {
                        // send email and notification
                        $content = 'You have donated $' . $amount . ' to ' . $donateTo . ' ' . $donateToLink;
                        $email_subject = 'You have donated $' . $amount . ' to ' . $donateTo . ' ' . $obj->name;
                        User::SendEmailAndOnSiteAlert($content, $email_subject, [Auth::user()], $onlyemail = false, 'fund_received');

                        $donateToLink = '<a href="' . url('userprofiles/' . $hashID->encode($obj->id) . '/' . strtolower($obj
                            ->first_name . '_' . $obj->last_name)) . '">' . strtolower($obj->first_name . '_' . $obj->last_name) . '</a>';

                        $content = 'You have received a payment of $' . $amount . ' to ' . $donateTo . ' ' . $donateToLink;
                        $email_subject  = 'You have received a payment of $' . $amount . ' to ' . $donateTo . ' ' . $obj->name;
                        User::SendEmailAndOnSiteAlert($content, $email_subject, [$obj], $onlyemail = false, 'fund_received');

                        $transactionObj = Transaction::find($transactionID);
                        if (count($transactionObj) > 0 && !empty($transactionObj)) {
                            //                            if(!empty($obj->paypal_email))
                            $transactionObj->update(['pay_key' => $response['paykey'], 'status' => strtolower($response['status'])]);
                            //                            else
                            //                                $transactionObj->update(['pay_key'=>$response['payment_id'],'status'=>strtolower($response['status'])]);
                        }
                    } else {

                        // send email and notification
                        $content = 'You have donated $' . $amount . ' to ' . $donateTo . ' ' . $donateToLink;

                        $email_subject  = 'You have donated $' . $amount . ' to ' . $donateTo . ' ' . $obj->name;
                        User::SendEmailAndOnSiteAlert($content, $email_subject, [Auth::user()], $onlyemail = false, 'fund_received');

                        $fundObj = Fund::find($fundID);
                        if (count($fundObj) > 0 && !empty($fundObj)) {
                            $fundObj->update(['payment_id' => $response['payment_id'], 'status' => strtolower($response['status'])]);
                        }
                    }
                    return redirect()->away($response['url']);
                } else
                    return redirect()->back()->withErrors(['error' => 'Something goes wrong. Please try again later.'])->withInput();
            }
        }
    }

    // public function transfer_from_unit(Request $request)
    // {
    //     if ($request->isMethod('post')) {

    //         //check payment from new credit card or old?
    //         /* $fromType = $request->input('frmTyp');
    //          $fromType = Helpers::encrypt_decrypt('decrypt',$fromType);
    //          if($fromType != "new" && $fromType != "old")
    //              return \Response::json(['success'=>false,'errors'=>['error'=>'Something goes wrong. Please try again.']]);*/

    //         $url = URL::previous();
    //         $url = explode("/", $url);
    //         $type = $url[5]; // for local 6. for live 5
    //         $id = $url[count($url) - 1]; // for localhost 7. for live 6
    //         $exists = false;
    //         $obj = [];
    //         $donateTo = '';
    //         $hashID = '';
    //         $controller = '';
    //         $addFunds = [];

    //         $donateToLink = '';

    //         if ($type == 'objective') {
    //             $exists = Objective::checkObjectiveExist($id, true);
    //             if ($exists) {
    //                 $obj = Objective::getObj($id);
    //                 $donateTo = " objective ";
    //                 $controller = "objectives";
    //                 $addFunds = ['objective_id' => $obj->id];
    //                 $hashID = new Hashids('objective id hash', 10, Config::get('app.encode_chars'));
    //                 $donateToLink = '<a href="' . url('objectives/' . $hashID->encode($obj->id) . '/' . $obj->slug) . '">' . $obj->name . '</a>';

    //                 $response = null;
    //                 $inputData = $request->all();
    //                 $validator = Validator::make($inputData, [
    //                     'donate_amount' => 'required|numeric'
    //                 ], [
    //                     'donate_amount.required' => 'Please enter amount to donate',
    //                     'donate_amount.numeric' => 'Amount must be numeric'
    //                 ]);


    //                 if ($validator->fails()) {
    //                     return redirect()->back()->withErrors($validator)->withInput();
    //                 }

    //                 if (empty($obj) || count($obj) == 0)
    //                     return redirect()->back()->withErrors(['error' => 'Something goes wrong. Please try again.'])->withInput();

    //                 $amount = $request->input('donate_amount');

    //                 $transfer = Fund::transferFromUnit($obj, $amount);

    //                 if (isset($transfer['success'])) {
    //                     return view('funds.success', ['messageType' => true, 'payment_id' => 'Inner Transaction', 'amount' => $amount]);
    //                 } else {
    //                     return view('funds.success', ['messageType' => false, 'payment_id' => 'Inner Transaction', 'amount' => $amount, 'err_message' => $transfer['error']]);
    //                 }
    //             }
    //         }

    //         $amount = $request->input('donate_amount');
    //         return view('funds.success', ['messageType' => true, 'payment_id' => 'Inner Transaction', 'amount' => $amount]);
    //     }
    // }

    // public function transferFromUnit(Request $request)
    // {

    //     // @dd($request);
    //     $request->validate([
    //         'unit_id' => 'required|integer',
    //         'username' => 'required|string',
    //         'donate_amount' => 'required|numeric|min:1',
    //     ]);

    //     $user = auth()->user();

    //     $transaction = new Transaction();
    //     $transaction->transaction_id = 'TXN-' . strtoupper(Str::random(10));
    //     $transaction->unit_id = $request->unit_id;
    //     $transaction->user_id = auth()->id();
    //     $transaction->donated_by = auth()->id();
    //     $transaction->amount = $request->donate_amount;
    //     $transaction->save();

    //     return response()->json([
    //         'success' => true,
    //         'transaction_id' => $transaction->transaction_id
    //     ]);
    // }


    public function showDonateForm($type, $hashid)
    {
        $type = 'objective';
        $id = Hashids::decode($hashid);
        if (empty($id)) {
            abort(404);
        }

        $decodedId = $id[0];
        $model = null;

        switch ($type) {
            case 'unit':
                $model = Unit::findOrFail($decodedId);
                break;
            case 'objective':
                $model = Objective::findOrFail($decodedId);
                break;
            case 'task':
                $model = Task::findOrFail($decodedId);
                break;
            case 'issue':
                $model = Issue::findOrFail($decodedId);
                break;
            case 'idea':
                $model = Idea::findOrFail($decodedId);
                break;
            default:
                abort(404);
        }

        return view('funds.donation', [
            'data' => $model,
            'type' => $type, // ✅ This is the fix
            'current_payment_method' => 'Zcash',
        ]);
    }



    // return view('funds.donation', [
    //     'data' => $data,
    //     'type' => $type,
    //     'current_payment_method' => 'Zcash', // or fetch from config
    // ]);



    // public function transferFromUnit(Request $request)
    // {
    //     $request->validate([
    //         'unit_id' => 'required|integer',
    //         'username' => 'required|string',
    //         'donate_amount' => 'required|numeric|min:1',
    //         'donate_to_type' => 'required|string|in:unit,objective,task,issue,idea',
    //     ]);

    //     $user = auth()->user();

    //     $transaction = new Transaction();
    //     $transaction->transaction_id = 'TXN-' . strtoupper(Str::random(10));
    //     $transaction->user_id = $user->id;
    //     $transaction->target_id = $request->unit_id;
    //     $transaction->target_type = $request->donate_to_type;
    //     $transaction->amount = $request->donate_amount;
    //     $transaction->payment_method = $request->paymentMethod;
    //     $transaction->save();

    //     return redirect()->back()->with('success', 'Donation successful!');
    // }



    public function success(Request $request)
    {
        $paymentID = $request->input('paymentId');
        $payerID = $request->input('PayerID');
        $type = $request->input('type');
        $orderID = $request->input('orderID');
        $payment_method = $request->input('payment_method');

        $orderIDHashID = new Hashids('order id hash', 10, Config::get('app.encode_chars'));
        $orderID = $orderIDHashID->decode($orderID);


        $message = "Something goes wrong. Please try again later.";
        $messageType = false;
        $obj = [];
        $payment_id = '';
        if (!empty($orderID)) {
            $orderID  = $orderID[0];
            if ($type == "user")
                $obj = Transaction::find($orderID);
            else
                $obj = Fund::find($orderID);

            // if user refresh the page then redirect to unit home page.
            if ($obj->status == "approved" && $payment_method != "Zcash")
                return redirect('units');


            if (!empty($payment_method) && $payment_method == "Zcash") {
                $payment_id = $request->input('paymentId');
                $obj->update(['status' => 'approved']);
                $message = "Thank you for your payment.";
                $messageType = true;
                // $request->session()->set('has_seen',true);
                // $request->session()->save();
            } else {
                //this will use for payemnt method = PAYPAL
                if (!empty($obj) && $obj->status != "approved") {
                    $db_payment_id = $obj->payment_id;
                    $flag = false;
                    if ($type == "user") {
                        $obj->update(['status' => 'approved']);

                        $donateToObj = User::find($obj->user_id);
                        if (!empty($donateToObj)) {
                            $db_payment_id = $obj->pay_key;
                            if (empty($donateToObj->paypal_email))
                                $payment = Paypal::executePayment($db_payment_id, $payerID);
                            else
                                $payment['success'] = true;
                            $flag = true;
                        }
                    } else {
                        $payment = Paypal::executePayment($db_payment_id, $payerID);
                        if (!empty($payment['payment']))
                            $flag = true;
                    }

                    if ($payment['success'] && $flag) {
                        $controller = '';
                        $hashID = '';
                        $donateTo = '';
                        $dataObj = '';
                        if ($type == "user") {
                            $payment_id = $obj->pay_key;
                            $data['pay_key'] = $obj->pay_key;
                            $data['transaction_id'] = $orderID;
                            $donateTo = ' user ';
                            $controller = 'userprofiles';
                            $dataObj = User::find($obj->user_id);
                            $dataObj->name = $dataObj->first_name . ' ' . $dataObj->last_name;
                            $dataObj->slug = strtolower($dataObj->first_name . '_' . $dataObj->last_name);
                            $hashID = new Hashids('user id hash', 10, Config::get('app.encode_chars'));
                        } else {
                            $payment_id = $obj->payment_id;
                            $data['donate_paypal_id'] = $paymentID;
                            $data['fund_id'] = $orderID;
                            $obj->update(['status' => $payment['payment']->getState()]);

                            if (!empty($obj->unit_id)) {
                                $controller = "units";
                                $donateTo = ' unit ';
                                $dataObj = Unit::find($obj->unit_id);
                                $hashID = new Hashids('unit id hash', 10, Config::get('app.encode_chars'));
                            }
                            if (!empty($obj->task_id)) {
                                $controller = "tasks";
                                $donateTo = ' task ';
                                $dataObj = Task::find($obj->task_id);
                                $hashID = new Hashids('task id hash', 10, Config::get('app.encode_chars'));
                            }
                            if (!empty($obj->objective_id)) {
                                $controller = "objectives";
                                $donateTo = ' objective ';
                                $dataObj = Objective::find($obj->objective_id);
                                $hashID = new Hashids('objective id hash', 10, Config::get('app.encode_chars'));
                            }
                        }

                        //insert into site activity table for log.
                        /*$userIDHashID= new Hashids('user id hash',10,\Config::get('app.encode_chars'));
                        $user_id = $userIDHashID->encode(Auth::user()->id);

                        $user_name=Auth::user()->first_name.' '.Auth::user()->last_name;
                        if(!empty(Auth::user()->username))
                            $user_name =Auth::user()->username;

                        SiteActivity::create([
                            'user_id'=>Auth::user()->id,
                            'comment'=>'<a href="'.url('userprofiles/'.$user_id.'/'.strtolower(Auth::user()->first_name.'_'.Auth::user()->last_name)).'">'
                                .$user_name.'</a> donate $'.$obj->amount.' to'.$donateTo.' <a href="'.url($controller.'/'.$hashID->encode($dataObj->id).'/'.$dataObj->slug).'">'.$dataObj->name.'</a>'
                        ]);*/

                        // store actual paypal transaction details.
                        PaypalTransaction::create($data);
                        $message = "Thank you for your payment.";
                        $messageType = true;

                        //Send transaction details via email and send thank you message
                        if (!empty($obj->donated_by_user_id)) {
                            $userObj = User::where('id', $obj->donated_by_user_id)->first();
                            //view()->share('userObj',$userObj);
                            $paypalTransaction = PaypalTransaction::where('fund_id', $obj->id)->first();
                            //view()->share('paypalTransaction',$paypalTransaction);
                            $toEmail = $userObj->email;
                            $toName = $userObj->first_name . ' ' . $userObj->last_name;
                            $subject = "Thank You";

                            //return view('emails.thankyou_for_donation');
                            \Mail::send('emails.thankyou_for_donation', ['mailFrom' => 'PAYPAL', 'fundObj' => $obj, 'userObj' => $userObj, 'paypalTransaction' => $paypalTransaction, 'report_concern' => false], function ($message) use ($toEmail, $toName, $subject) {
                                $message->to($toEmail, $toName)->subject($subject);
                                $message->from(Config::get("app.notification_email"), Config::get("app.site_name"));
                            });
                        }
                    } else
                        $obj->update(['status' => 'cancelled']);
                }
            }
        }
        view()->share('payment_id', $payment_id);
        view()->share('obj', $obj);
        view()->share('messageType', $messageType);
        view()->share('message', $message);
        return view('funds.success');
    }

    public function cancel(Request $request)
    {
        $paymentID = $request->input('paymentId');
        $payerID = $request->input('PayerID');
        $type = $request->input('type');
        $orderID = $request->input('orderID');

        $orderIDHashID = new Hashids('order id hash', 10, Config::get('app.encode_chars'));
        $orderID = $orderIDHashID->decode($orderID);

        $message = "Payment cancelled successfully.";
        $messageType = false;
        $obj = [];
        $payment_id = '';
        if (!empty($orderID)) {
            $orderID  = $orderID[0];

            if ($type == "user")
                $obj = Transaction::find($orderID);
            else {
                $obj = Fund::find($orderID);
            }

            // if user refresh the page then redirect to unit home page.
            if ($obj->status == "approved" || $obj->status == "cancelled")
                return redirect('units');


            if (!empty($obj) && $obj->status != "approved") {
                $obj->update(['status' => 'cancelled']);
                if ($type == "user")
                    $payment_id = $obj->pay_key;
                else
                    $payment_id = $obj->payment_id;
            }
        }
        view()->share('payment_id', $payment_id);
        view()->share('obj', $obj);
        view()->share('messageType', $messageType);
        view()->share('message', $message);
        return view('funds.cancel');
    }
    public function show() {}

    public function donateForm($hashid)
    {
        $unit = Unit::where('hashid', $hashid)->firstOrFail(); // yaha aapka hashid decode ya match ho raha

        $user = auth()->user(); // ya koi specific user bhi le sakte ho

        return view('funds.donate_form', [
            'unit_name' => $unit->name,
            'user_name' => $user->name ?? '',
            'current_payment_method' => 'Zcash', // or PayPal, etc.
        ]);
    }


    public function donateToUnit($hashid)
    {
        $id = Hashids::decode($hashid)[0] ?? null;
        $unit = Unit::findOrFail($id);
        return view('funds.donation_form', [
            'data' => $unit,
            'donate_type' => 'unit',
            'current_payment_method' => 'Zcash',
        ]);
    }

    // For Objective
    public function donateToObjective($hashid)
    {
        $id = Hashids::decode($hashid)[0] ?? null;
        $objective = Objective::findOrFail($id);
        return view('funds.donation_form', [
            'data' => $objective,
            'donate_type' => 'objective',
            'current_payment_method' => 'Zcash',
        ]);
    }

    // For Task
    public function donateToTask($hashid)
    {
        $id = Hashids::decode($hashid)[0] ?? null;
        $task = Task::findOrFail($id);
        return view('funds.donation_form', [
            'data' => $task,
            'donate_type' => 'task',
            'current_payment_method' => 'Zcash',
        ]);
    }

    // For Issue
    public function donateToIssue($hashid)
    {
        $id = Hashids::decode($hashid)[0] ?? null;
        $issue = Issue::findOrFail($id);
        return view('funds.donation_form', [
            'data' => $issue,
            'donate_type' => 'issue',
            'current_payment_method' => 'Zcash',
        ]);
    }

    // For Idea
    public function donateToIdea($hashid)
    {
        $id = Hashids::decode($hashid)[0] ?? null;
        $idea = Idea::findOrFail($id);
        return view('funds.donation_form', [
            'data' => $idea,
            'donate_type' => 'idea',
            'current_payment_method' => 'Zcash',
        ]);
    }


    public function transferFromUnit(Request $request)
    {
        $request->validate([
            'unit_id' => 'required|integer',
            'username' => 'required|string',
            'donate_amount' => 'required|numeric|min:1',
            'donate_to_type' => 'required|in:unit,objective,task,issue,idea',
        ]);

        $donateType = $request->donate_to_type;
        $targetId = $request->unit_id;

        $transaction = new Transaction();
        $transaction->transaction_id = 'TXN-' . strtoupper(Str::random(10));
        $transaction->user_id = auth()->id();
        // Donation changes start
        $transaction->created_by = auth()->id();
        // Donation changes end
        $transaction->amount = $request->donate_amount;
        // $transaction->payment_method = $request->paymentMethod ?? 'unknown';

        // Dynamically assign based on donate_to_type
        switch ($donateType) {
            case 'unit':
                $transaction->unit_id = $targetId;
                break;
            case 'objective':
                $transaction->objective_id = $targetId;
                break;
            case 'task':
                $transaction->task_id = $targetId;
                break;
            case 'issue':
                $transaction->issue_id = $targetId;
                break;
            case 'idea':
                $transaction->idea_id = $targetId;
                break;
        }

        $transaction->save();

        return response()->json(['success' => 'Donation successful!', 'transaction_id' => $transaction->transaction_id]);
    }

    public function initiateTransaction(Request $request){
     // Validate the request

        $donateType = $request->donate_to_type;
        $targetId   = $request->unit_id; // By default we will use unit_id name for input

        // Prepare base data
        $data = [
            'transaction_id'  => 'TXN-' . strtoupper(Str::random(10)),
            'user_id'         => auth()->id(),
            'created_by'      => auth()->id(),
            'amount'          => $request->donate_amount,

            // 'payment_method'  => $request->paymentMethod ?? 'unknown',
            'created_at'      => now(),
            // 'updated_at'      => now(),
        ];

        // Dynamically add target ID based on donation type
        switch ($donateType) {
            case 'unit':
                $data['unit_id'] = $targetId;
                break;
            case 'objective':
                $data['objective_id'] = $targetId;
                break;
            case 'task':
                $data['task_id'] = $targetId;
                break;
            case 'issue':
                $data['issue_id'] = $targetId;
                break;
            case 'idea':
                $data['idea_id'] = $targetId;
                break;
        }

        // Check if transaction already exists for this username (you can also match by donate_to_type + id if needed)
        // $existing = DB::table('transactions')
        //     ->where('created_by', auth()->id(),)
        //     ->where(function ($query) use ($donateType, $targetId) {
        //         switch ($donateType) {
        //             case 'unit':
        //                 $query->where('unit_id', $targetId);
        //                 break;
        //             case 'objective':
        //                 $query->where('objective_id', $targetId);
        //                 break;
        //             case 'task':
        //                 $query->where('task_id', $targetId);
        //                 break;
        //             case 'issue':
        //                 $query->where('issue_id', $targetId);
        //                 break;
        //             case 'idea':
        //                 $query->where('idea_id', $targetId);
        //                 break;
        //         }
        //     })
        //     ->first();

        // if ($existing) {
        //     // Remove created_at if updating
        //     unset($data['created_at']);

        //     DB::table('transactions')
        //         ->where('id', $existing->id)
        //         ->update($data);
        // } else {
            DB::table('transactions')->insert($data);
        // }

        // Redirect to Givebutter
        // return redirect()->away('https://givebutter.com/G8ntYk');
        return response()->json([
            'success' => true,
            'redirect_url' => 'https://givebutter.com/G8ntYk',
            'transaction' => $data,
            'type'=>$donateType,
            'target_id'=> $targetId
        ]);
    
    }

    public function submit(Request $request)
    {
        // Validate the request
        $donateType = $request->donate_to_type;
        $targetId   = $request->unit_id; // By default we will use unit_id name for input

        // Prepare base data
        $data = [
            'transaction_id'  => 'TXN-' . strtoupper(Str::random(10)),
            'user_id'         => auth()->id(),
            // 'created_by'      => $request->username,
            // Donation changes start
            'created_by'      => auth()->id(),
            'amount'          => $request->donate_amount ?? 100,
            // Donation changes end
            // 'payment_method'  => $request->paymentMethod ?? 'unknown',
            'created_at'      => date('Y-m-d H:i:s'),
            // 'updated_at'      => now(),
        ];
        // echo '<pre>';print_r($data);echo "<pre>";die();

        // Dynamically add target ID based on donation type
        switch ($donateType) {
            case 'unit':
                $data['unit_id'] = $targetId;
                break;
            case 'objective':
                $data['objective_id'] = $targetId;
                break;
            case 'task':
                $data['task_id'] = $targetId;
                break;
            case 'issue':
                $data['issues_id'] = $targetId;
                break;
            case 'idea':
                $data['idea_id'] = $targetId;
                break;
        }

        // Check if transaction already exists for this username (you can also match by donate_to_type + id if needed)
        // Donation changes start
        $existing = DB::table('transactions')
            ->where('created_by', $request->username)
            // Donation changes end
            ->where(function ($query) use ($donateType, $targetId) {
                switch ($donateType) {
                    case 'unit':
                        $query->where('unit_id', $targetId);
                        break;
                    case 'objective':
                        $query->where('objective_id', $targetId);
                        break;
                    case 'task':
                        $query->where('task_id', $targetId);
                        break;
                    case 'issue':
                        // Donation changes start
                        $query->where('issue_id', $targetId);
                        // Donation changes end
                        break;
                    case 'idea':
                        $query->where('idea_id', $targetId);
                        break;
                }
            })
            ->first();

        if ($existing) {
            // Remove created_at if updating
            unset($data['created_at']);

            // Donation changes start
            DB::table('transactions')
                // Donation changes end
                ->where('id', $existing->id)
                ->update($data);
        } else {
            // Donation changes start
            DB::table('transactions')->insert($data);
            // Donation changes end
        }

        // Redirect to Givebutter
        // Donation changes start
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'redirect_url' => 'https://givebutter.com/G8ntYk',
                'transaction' => $data
            ]);
        } else {
            return redirect()->away('https://givebutter.com/G8ntYk');
        }
        // Donation changes end
    }


    public function donationList(Request $request)
    {
        // Donation changes start
        $unitId = $request->query('unit');
        $unitData = Unit::where('id', $unitId)->first();
        $transaction = DB::table('transactions')
            ->leftJoin('units', 'transactions.unit_id', '=', 'units.id')
            ->leftJoin('tasks', 'transactions.task_id', '=', 'tasks.id')
            ->leftJoin('ideas', 'transactions.idea_id', '=', 'ideas.id')
            ->leftJoin('issues', 'transactions.issue_id', '=', 'issues.id')
            ->leftJoin('objectives', 'transactions.objective_id', '=', 'objectives.id')
            ->leftJoin('users', 'transactions.created_by', '=', 'users.id')
            ->select(
                'transactions.*',
                'units.name as unit_name',
                'tasks.name as task_name',
                'ideas.title as idea_title',
                'issues.title as issue_title',
                'objectives.name as objective_title',
                'users.username as created_by'
            )
            ->where(function ($query) {
                $query->where('transactions.unit_id', '>', 0)
                    ->orWhere('transactions.task_id', '>', 0)
                    ->orWhere('transactions.idea_id', '>', 0)
                    ->orWhere('transactions.issue_id', '>', 0)
                    ->orWhere('transactions.objective_id', '>', 0);
            })
            ->get();

        // $unitData = Unit::where('id', $request->unit)->first();
        // $issueResolutions = $this->calculateIssueResolution($request->unit);
        // view()->share('totalIssueResolutions', $issueResolutions);

        return view('funds.donation_list', ['transactions' => $transaction, 'unitData' => $unitData]);
    }

    // Issue fixed by tarun  - start

    public function donationDetails($id)
    {
        $unitTotalAmount = Transaction::sum('amount');
        return response()->json(['success' => 'Donation fetched successfully!', 'transaction_amount' => $unitTotalAmount]);
    }
    public function financeActivities(Request $request)
    {
        $unitId = $request->query('unit');
        $unitData = Unit::where('id', $unitId)->first();
        $activities = \App\Models\Transaction::where('unit_id', $unitId)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('funds.activities', compact('activities', 'unitData'));
    }
    // Issue fixed by tarun  - End
}
