<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['state_id','name'];

    /**
     * Get State of City..
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function state(){
        return  $this->belongsTo('App\State');
    }

    /**
     * Get users of Country
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users(){
        return $this->hasMany('App\User');
    }

}
