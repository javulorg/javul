<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskCancel extends Model
{

    use SoftDeletes;
    protected $table = 'task_cancel';
    protected $dates = ['deleted_at'];


    protected $fillable = ['user_id','task_id','comments'];

    public function tasks(){
        return  $this->belongsTo('App\Task');
    }

    public function users(){
        return  $this->hasMany('App\User','id','user_id');
    }
}
