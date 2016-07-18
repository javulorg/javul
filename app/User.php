<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\Billable;

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
        'area_of_interest','loggedin','stripe_customer_id'
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

    /**
     * Function will returns all credit cards of user.
     * @return array
     */
    public static function getAllCreditCards(){
        if(!empty(Auth::user()->stripe_customer_id))
            return \Stripe\Customer::retrieve(Auth::user()->stripe_customer_id)->sources->all(["object" => "card"]);
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
            $debitFrom = User::where('role','superadmin')->first()->id;
            if(!empty($rewards)){
                /**************************** reward given to task completer *******************************/
                Transaction::create([
                    'user_id'=>$taskCompleter,
                    'amount'=>$rewards,
                    'trans_type'=>'credit',
                    'comments'=>$rewards.' rewards given to '.$taskCompleterObj->first_name.' '.$taskCompleterObj->last_name
                ]);

                // debit from superadmin account

                Transaction::create([
                    'user_id'=>$debitFrom ,
                    'amount'=>$rewards,
                    'trans_type'=>'debit',
                    'comments'=>$rewards.' rewards given to '.$taskCompleterObj->first_name.' '.$taskCompleterObj->last_name
                ]);

                /**************************** reward given to task completer end *******************************/

                /**************************** reward given to task creator and editor *******************************/
                $taskEditors = RewardAssignment::where('task_id')->get();
                if(!empty($taskEditors) && count($taskEditors) > 0){
                    foreach($taskEditors as $editor){
                        $taskEditorObj = User::find($editor->user_id);
                        $percentageReward = ($rewards * $editor->reward_percentage) / 100;
                        Transaction::create([
                            'user_id'=>$editor->user_id,
                            'amount'=>$percentageReward,
                            'trans_type'=>'credit',
                            'comments'=>$percentageReward.' rewards given to '.$taskEditorObj->first_name.' '.$taskEditorObj->last_name
                        ]);

                        // debit from superadmin account

                        Transaction::create([
                            'user_id'=>$debitFrom ,
                            'amount'=>$percentageReward,
                            'trans_type'=>'debit',
                            'comments'=>$percentageReward.' rewards given to '.$taskEditorObj->first_name.' '.$taskEditorObj->last_name
                        ]);
                    }
                }
                else{
                    $taskCreatorID = $taskObj->user_id;
                    $taskCreatorObj = User::find($taskCreatorID);
                    $percentageReward= ($rewards * 10)/100;
                    Transaction::create([
                        'user_id'=>$taskCreatorID,
                        'amount'=>$percentageReward,
                        'trans_type'=>'credit',
                        'comments'=>$percentageReward.' rewards given to '.$taskCreatorObj->first_name.' '.$taskCreatorObj->last_name
                    ]);

                    // debit from superadmin account

                    Transaction::create([
                        'user_id'=>$debitFrom ,
                        'amount'=>$percentageReward,
                        'trans_type'=>'debit',
                        'comments'=>$percentageReward.' rewards given to '.$taskCreatorObj->first_name.' '.$taskCreatorObj->last_name
                    ]);
                }
                /**************************** reward given to task creator and editor end *******************************/
            }
        }
    }

    public static function createCustomer($stripeToken){
        $customer=[];
        $stripe_error='';
        try{
            $customer = \Stripe\Customer::create(array(
                    "source" => $stripeToken,
                    "description" => "customer created with ".Auth::user()->first_name.' '.Auth::user()->last_name)
            );

        }catch (\Stripe\Error\Card $e) {
            $stripe_error = $e->getMessage();
        } catch (\Stripe\Error\InvalidRequest $e) {
            $stripe_error = $e->getMessage();
        } catch (\Stripe\Error\Authentication $e) {
            $stripe_error = $e->getMessage();
        } catch (\Stripe\Error\ApiConnection  $e) {
            $network_error = true;
            $stripe_error = $e->getMessage();
        } catch(\Stripe\Error\Base $e){
            $stripe_error=$e->getMessage();
        } catch(Exception $e){
            $stripe_error="Something is wrong. please try again later.";
        }
        if(!empty($customer)){
            $userObj = User::find(Auth::user()->id);
            if(!empty($userObj) && count($userObj) > 0){
                $userObj->stripe_customer_id =$customer->id;
                $userObj->save();
            }
        }
        return ['customer'=>$customer,'error_msg'=>$stripe_error];
    }

    public static function donateUsingCreditCard($data=[]){

        if(empty(Auth::user()->stripe_customer_id)){
            $customer = self::createCustomer($data['stripeToken']);
            if(empty($customer['customer']))
                return ['success'=>false,'error_msg'=>$customer['error_msg']];
            $customer = $customer['customer'];
            $customer_id = $customer->id;
        }
        else{
            $customer_id = Auth::user()->stripe_customer_id;
        }

        if($data['opt_typ'] == "used"){
            $amount = $data['amount_reused_card'] * 100;
            $allCards = self::getAllCreditCards();
            $last4= $data['credit_cards'];
            if(isset($allCards->data) && count($allCards->data) > 0){
                foreach($allCards->data as $card)
                {
                    if($card->last4 == $last4)
                        $data['cardId'] = $card->id;
                }
            }
        }
        else{
            // create card if user uses new card to pay
            $allCards = self::getAllCreditCards();
            $last4= substr(str_replace(" ","",$data['cc-number']),-4);
            $flag = false;
            if(isset($allCards->data) && count($allCards->data) > 0){
                foreach($allCards->data as $card)
                {
                    if($card->last4 == $last4)
                        $flag= true;
                }
            }
            if(!$flag){
                if(isset($allCards->data) && count($allCards->data) > 0){
                    $customer = \Stripe\Customer::retrieve($customer_id);
                    $customer->sources->create(["source" => $data['stripeToken']]);
                }
            }
            $amount = $data['cc-amount'] * 100;
        }
        // set default card this last id
        self::setDefaultCreditCard($customer_id,$data['cardId']);
        $charge = [];
        $stripe_error='';
        try{
            $charge = \Stripe\Charge::create(array(
                    "amount" => $amount, // amount in cents, again
                    "currency" => "usd",
                    "customer" => $customer_id,
                    "description"=>$data['message'])
            );
        }catch (\Stripe\Error\Card $e) {
            $stripe_error = $e->getMessage();
        } catch (\Stripe\Error\InvalidRequest $e) {
            $stripe_error = $e->getMessage();
        } catch (\Stripe\Error\Authentication $e) {
            $stripe_error = $e->getMessage();
        } catch (\Stripe\Error\ApiConnection  $e) {
            $network_error = true;
        } catch(\Stripe\Error\Base $e){
            $stripe_error=$e->getMessage();
        } catch(Exception $e){
            $stripe_error="Something is wrong. please try again later.";
        }

        if(empty($charge))
            return ['success'=>false,'error_msg'=>$stripe_error];
        else
            return ['success'=>true];
    }

    public static function setDefaultCreditCard($customer_id,$card_id){
        try{
            $customer = \Stripe\Customer::retrieve($customer_id);
            $customer->default_source = $card_id;
            $customer->save();
        }catch (\Stripe\Error\Card $e) {
            $stripe_error = $e->getMessage();
        } catch (\Stripe\Error\InvalidRequest $e) {
            $stripe_error = $e->getMessage();
        } catch (\Stripe\Error\Authentication $e) {
            $stripe_error = $e->getMessage();
        } catch (\Stripe\Error\ApiConnection  $e) {
            $network_error = true;
        } catch(\Stripe\Error\Base $e){
            $stripe_error=$e->getMessage();
        } catch(Exception $e){
            $stripe_error="Something is wrong. please try again later.";
        }
    }
}
