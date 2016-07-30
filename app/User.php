<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Laravel\Cashier\Billable;
use Hashids\Hashids;
use App\Paypal;

class User extends Authenticatable
{
    use Billable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name','last_name', 'email', 'password','phone','mobile','address','country_id','state_id','city_id','role','job_skills',
        'area_of_interest','loggedin','stripe_customer_id','credit_card_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get Units of User..
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function units(){
        return $this->hasMany('App\Unit');
    }

    /**
     * Get Objectives of user..
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function objectives(){
        return $this->hasMany('App\Objective');
    }

    /**
     * Get Tasks of User..
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks(){
        return $this->hasMany('App\Task');
    }

    /**
     * Get Issues of User...
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function issues(){
        return $this->hasMany('App\Issue');
    }

    public function task_complete(){
        return $this->belongsTo('App\TaskComplete');
    }

    /**
     * Define accessor for concate first name and last name
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->first_name . " " . $this->last_name;
    }

    public static function getUserName($user_id){
        $userObj = self::find($user_id);
        if(!empty($userObj)){
            return $userObj->first_name.' '.$userObj->last_name;
        }
        return '';
    }

    public static function checkUserExist($user_id,$needToDecode=false){
        if($needToDecode){
            $userIDHashID = new Hashids('user id hash',10,\Config::get('app.encode_chars'));
            $user_id = $userIDHashID->decode($user_id );

            if(empty($user_id))
                return false;
            $user_id = $user_id[0];

            if(self::find($user_id)->count() == 0)
                return false;
            return true;
        }
        else{
            if(self::find($user_id)->count() == 0)
                return false;
            return true;
        }
    }

    public static function getObj($user_id){
        $userIDHashID = new Hashids('user id hash',10,\Config::get('app.encode_chars'));
        $user_id = $userIDHashID->decode($user_id );

        if(empty($user_id))
            return [];
        $user_id = $user_id[0];

        if(self::find($user_id)->count() > 0)
            return self::find($user_id);
        return [];
    }

    /**
     * while task completer complete the task. assign rewards to completer and task creator,task editors
     * as mentioned in doc.
     * @param $task_id
     */
    public static function transferRewards($task_id){
        $taskObj = Task::find($task_id);
        if(!empty($taskObj) && count($taskObj) > 0){
            $taskCompleter = $taskObj->assign_to;
            $taskCompleterObj = User::find($taskCompleter);
            $rewards = $taskObj->compensation;

            // assign point or amount to task completer, points or amount added while he bidding
            $taskBidder = TaskBidder::where('task',$task_id)->where('user_id',$taskObj->assign_to)->first();
            $userIDHashID= new Hashids('user id hash',10,\Config::get('app.encode_chars'));
            $taskIDHashID= new Hashids('task id hash',10,\Config::get('app.encode_chars'));
            if(!empty($taskBidder) && count($taskBidder) > 0){
                if($taskBidder->charge_type == "amount"){
                    Transaction::create([
                        'created_by'=>Auth::user()->id,
                        'user_id'=>$taskObj->assign_to,
                        'amount'=>$taskBidder->amount,
                        'trans_type'=>'credit',
                        'comments'=>$taskBidder->amount.' rewards received to complete task '.$taskObj->name
                    ]);

                    SiteActivity::create([
                        'user_id'=>$taskCompleter,
                        'comment'=>'<a href="'.url('userprofiles/'.$userIDHashID->encode($taskCompleter).'/'.strtolower($taskCompleterObj->first_name.'_'.$taskCompleterObj->last_name)).'">'
                            .$taskCompleterObj->first_name.' '.$taskCompleterObj->last_name.'</a> received payment $'.$taskBidder->amount.'
                            to complete task <a href="'.url('tasks/'.$taskIDHashID->encode($task_id).'/'.$taskObj->slug).'">'
                            .$taskObj->name.'</a>'
                    ]);
                }
                else{
                    ActivityPoint::create([
                        'user_id'=>$taskCompleter,
                        'task_id'=>$taskObj->id,
                        'points'=>$taskBidder->amount,
                        'comments'=>'Task Completed Points',
                        'type'=>'task'
                    ]);

                    SiteActivity::create([
                        'user_id'=>$taskCompleter,
                        'comment'=>'<a href="'.url('userprofiles/'.$userIDHashID->encode($taskCompleter).'/'.strtolower($taskCompleterObj->first_name.'_'.$taskCompleterObj->last_name)).'">'
                            .$taskCompleterObj->first_name.' '.$taskCompleterObj->last_name.'</a> received point'.$taskBidder->amount.'
                            to complete task <a href="'.url('tasks/'.$taskIDHashID->encode($task_id).'/'.$taskObj->slug).'">'
                            .$taskObj->name.'</a>'
                    ]);
                }
            }


            $debitFrom = User::where('role','superadmin')->first()->id;



            if(!empty($rewards)){
                /**************************** reward given to task completer *******************************/

                Transaction::create([
                    'created_by'=>Auth::user()->id,
                    'user_id'=>$taskCompleter,
                    'amount'=>$rewards,
                    'trans_type'=>'credit',
                    'comments'=>$rewards.' rewards received to complete task '.$taskObj->name
                ]);

                SiteActivity::create([
                    'user_id'=>$taskCompleter,
                    'comment'=>'<a href="'.url('userprofiles/'.$userIDHashID->encode($taskCompleter).'/'.strtolower($taskCompleterObj->first_name.'_'.$taskCompleterObj->last_name)).'">'
                        .$taskCompleterObj->first_name.' '.$taskCompleterObj->last_name.'</a> received rewards $'.$rewards.' to complete
                        task <a href="'.url('tasks/'.$taskIDHashID->encode($task_id).'/'.$taskObj->slug).'">'.$taskObj->name.'</a>'
                ]);

                // debit from superadmin account

                Transaction::create([
                    'created_by'=>Auth::user()->id,
                    'user_id'=>$debitFrom ,
                    'amount'=>$rewards,
                    'trans_type'=>'debit',
                    'comments'=>$rewards.' rewards given to '.$taskCompleterObj->first_name.' '.$taskCompleterObj->last_name
                ]);

                SiteActivity::create([
                    'user_id'=>Auth::user()->id,
                    'comment'=>'<a href="'.url('userprofiles/'.$userIDHashID->encode(Auth::user()->id).'/'.strtolower
                            (Auth::user()->first_name.'_'.Auth::user()->last_name)).'">'
                        .Auth::user()->first_name.' '.Auth::user()->last_name.'</a> assigned rewards $'.$rewards.' to <a href="'.url
                        ('userprofiles/'.$userIDHashID->encode($taskCompleter).'/'.strtolower($taskCompleterObj->first_name.'_'.$taskCompleterObj->last_name)).'">'
                        .$taskCompleterObj->first_name.' '.$taskCompleterObj->last_name.'</a>'
                ]);

                /**************************** reward given to task completer end *******************************/

                /**************************** reward given to task creator and editor *******************************/

                $taskEditors = RewardAssignment::where('task_id',$task_id)->get();
                $rewards = ($rewards * 10) / 100;
                if(!empty($taskEditors) && count($taskEditors) > 0){

                    foreach($taskEditors as $editor){
                        $taskEditorObj = User::find($editor->user_id);
                        $percentageReward = ($rewards * $editor->reward_percentage) / 100;
                        Transaction::create([
                            'created_by'=>Auth::user()->id,
                            'user_id'=>$editor->user_id,
                            'amount'=>$percentageReward,
                            'trans_type'=>'credit',
                            'comments'=>$percentageReward.' rewards received for task '.$taskObj->name
                        ]);
                        SiteActivity::create([
                            'user_id'=>$editor->user_id,
                            'comment'=>'<a href="'.url('userprofiles/'.$userIDHashID->encode($editor->user_id).'/'.strtolower($taskEditorObj->first_name.'_'.$taskEditorObj->last_name)).'">'
                                .$taskEditorObj->first_name.' '.$taskEditorObj->last_name.'</a> received rewards $'.$percentageReward.' to
                                 complete
                                task <a href="'.url('tasks/'.$taskIDHashID->encode($task_id).'/'.$taskObj->slug).'">'.$taskObj->name.'</a>'
                        ]);

                        // debit from superadmin account

                        Transaction::create([
                            'created_by'=>Auth::user()->id,
                            'user_id'=>$debitFrom ,
                            'amount'=>$percentageReward,
                            'trans_type'=>'debit',
                            'comments'=>$percentageReward.' rewards given to '.$taskEditorObj->first_name.' '.$taskEditorObj->last_name
                        ]);

                        SiteActivity::create([
                            'user_id'=>Auth::user()->id,
                            'comment'=>'<a href="'.url('userprofiles/'.$userIDHashID->encode(Auth::user()->id).'/'.strtolower
                                    (Auth::user()->first_name.'_'.Auth::user()->last_name)).'">'
                                .Auth::user()->first_name.' '.Auth::user()->last_name.'</a> assigned rewards $'.$percentageReward.' to <a
                                href="'.url('userprofiles/'.$userIDHashID->encode($editor->user_id).'/'.strtolower($taskEditorObj->first_name.'_'.$taskEditorObj->last_name)).'">'
                                .$taskEditorObj->first_name.' '.$taskEditorObj->last_name.'</a>'
                        ]);
                    }
                }
                else{
                    $taskCreatorID = $taskObj->user_id;
                    $taskCreatorObj = User::find($taskCreatorID);
                    $percentageReward= ($rewards * 10)/100;
                    Transaction::create([
                        'created_by'=>Auth::user()->id,
                        'user_id'=>$taskCreatorID,
                        'amount'=>$percentageReward,
                        'trans_type'=>'credit',
                        'comments'=>$percentageReward.' rewards received for task '.$taskObj->name
                    ]);

                    SiteActivity::create([
                        'user_id'=>$taskCreatorID,
                        'comment'=>'<a href="'.url('userprofiles/'.$userIDHashID->encode($taskCreatorID).'/'.strtolower($taskCreatorObj->first_name.'_'.$taskCreatorObj->last_name)).'">'
                            .$taskCreatorObj->first_name.' '.$taskCreatorObj->last_name.'</a> received rewards $'.$percentageReward.' to
                            complete task <a href="'.url('tasks/'.$taskIDHashID->encode($task_id).'/'.$taskObj->slug).'">'.$taskObj->name
                            .'</a>'
                    ]);
                    // debit from superadmin account

                    Transaction::create([
                        'created_by'=>Auth::user()->id,
                        'user_id'=>$debitFrom ,
                        'amount'=>$percentageReward,
                        'trans_type'=>'debit',
                        'comments'=>$percentageReward.' rewards given to '.$taskCreatorObj->first_name.' '.$taskCreatorObj->last_name
                    ]);

                    SiteActivity::create([
                        'user_id'=>Auth::user()->id,
                        'comment'=>'<a href="'.url('userprofiles/'.$userIDHashID->encode(Auth::user()->id).'/'.strtolower
                                (Auth::user()->first_name.'_'.Auth::user()->last_name)).'">'
                            .Auth::user()->first_name.' '.Auth::user()->last_name.'</a> assigned rewards $'.$percentageReward.' to <a
                            href="'.url('userprofiles/'.$userIDHashID->encode($taskCreatorID).'/'.strtolower($taskCreatorObj->first_name.'_'.$taskCreatorObj->last_name)).'">'
                            .$taskCreatorObj->first_name.' '.$taskCreatorObj->last_name.'</a> '
                    ]);
                }
                /**************************** reward given to task creator and editor end *******************************/
            }
        }
    }

    public static function donateAmount($data=[]){

        $error='';
        $userCreditCardID = Auth::user()->credit_card_id;

        if($data['frmTyp'] == 'old')
            $amount = $data['amount_reused_card'];
        else{
            $amount = $data['cc-amount'];
        }

        if(!is_numeric($amount) || $amount == 0 || $amount < 0)
            return ['success'=>false,'error_msg'=>'Amount should be greater than zero.' ];

        if($data['frmTyp'] == 'old')
            $creditCardID = $userCreditCardID;
        else{
            $saveCardResponse = Paypal::saveCard($data);
            if($saveCardResponse['success'])
                $creditCardID=$saveCardResponse['card_id'];
            else
                return ['success'=>false,'error_msg'=>$saveCardResponse['error']];
        }

        if(empty($creditCardID))
            return ['success'=>false,'error_msg'=>$error ];
        else{
            $paymentResponse = Paypal::makePaymentUsingCC($creditCardID,$amount,'USD',$data['message']);

            if($paymentResponse['success'])
                return ['success'=>true,'payment'=>$paymentResponse['payment']];
            else
                return ['success'=>false,'error_msg'=>$paymentResponse['error']];
        }
    }
}
