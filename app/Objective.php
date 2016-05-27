<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Objective extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id','unit_id','name','description','status','parent_id'];

    /**
     * Get Parent Unit of Objective.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unit(){
        return $this->belongsTo('App\Unit');
    }

    /**
     * Get Tasks of Objective..
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks(){
        return $this->hasMany('App\Task');
    }

    /**
     * Get Issues of Objective...
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function issues(){
        return $this->hasManyThrough('App\Issue','App\Task');
    }
}
