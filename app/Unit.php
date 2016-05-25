<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id','category_id','name','description','credibility','location','status','parent_id'];

    /**
     * Get UnitCategory of Unit
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(){
        return $this->belongsTo('App\UnitCategory');
    }

    /**
     * Get Objectives of Unit..
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function objectives(){
        return $this->hasMany('App\Objective');
    }

    /**
     * Get Tasks of Unit..
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function tasks(){
        return $this->hasManyThrough('App\Task','App\Objective');
    }

}
