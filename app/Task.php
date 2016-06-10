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

    /**
     * return tasks of specified conditions
     * @param string $task_type
     * @param string $objective_id
     * @return mixed
     */
    public static function getTasks($task_type='',$objective_id=''){
        $tasksObj = self::select(['tasks.*']);
        if(!empty($task_type))
            $tasksObj = $tasksObj->where('status',$task_type);

        if(!empty($objective_id))
            $tasksObj = $tasksObj->where('objective_id',$objective_id);

        $tasksObj = $tasksObj->get();

        return $tasksObj;
    }

    /**
     * return count of tasks of specified condition.
     * @param string $task_type
     * @param string $objective_id
     * @return int
     */
    public static function getTaskCount($task_type='',$objective_id=''){
        $tasksObj = self::select(['tasks.*']);
        if(!empty($task_type))
            $tasksObj = $tasksObj->where('status',$task_type);

        if(!empty($objective_id))
            $tasksObj = $tasksObj->where('objective_id',$objective_id);

        $tasksObj = $tasksObj->get();

        return count($tasksObj);
    }
}
