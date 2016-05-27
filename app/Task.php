<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id','unit_id','objective_id','name','description','skills','estimated_completion_time','reward',
                            'file_attachments','assign_to','status'];

    /**
     * Get Parent Objective of Tasks..
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function objective(){
        return  $this->belongsTo('App\Objective');
    }

    /**
     * Get Issues of Task..
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function issues(){
        return $this->hasMany('App\Issue');
    }
}
