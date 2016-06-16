<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
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

    /**
     * Define accessor for concate first name and last name
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->first_name . " " . $this->last_name;
    }
}
