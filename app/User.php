<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
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
        'area_of_interest','loggedin'
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
     * @param $user_id
     * @return array
     */
    public static function getAllCreditCards($user_id){
        if(!empty($user_id)){
            $creditCards = CreditCards::where('user_id',$user_id)->get();
            return $creditCards;
        }
        return [];
    }
}
