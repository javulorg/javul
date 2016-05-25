<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['country_id','name'];

    /**
     * Get Country of State..
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country(){
        return $this->belongsTo('App\Country');
    }

    /**
     * Get Cities of State..
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cities(){
        return $this->hasMany('App\City');
    }

    /**
     * Get users of Country
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users(){
        return $this->hasMany('App\User');
    }
}
