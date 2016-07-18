<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fund extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id','unit_id','objective_id','task_id','amount','transaction_type','fund_type'];


    /**
     * Function will return total donated fund to unit
     * @param $unit_id
     * @return int
     */
    public static function getUnitDonatedFund($unit_id=''){
        if(!empty($unit_id)){
            return self::where('unit_id','=',$unit_id)->where('transaction_type','=','donated')->sum('amount');
        }
        return 0;
    }

    /**
     * Function will return total donated fund to objective
     * @param $objective_id
     * @return int
     */
    public static function getObjectiveDonatedFund($objective_id=''){
        if(!empty($objective_id)){
            return self::where('objective_id','=',$objective_id)->where('transaction_type','=','donated')->sum('amount');
        }
        return 0;
    }

    /**
     * Function will return total donated funds to task.
     * @param $task_id
     * @return int
     */

    public static function getTaskDonatedFund($task_id=''){
        if(!empty($task_id)){
            return self::where('task_id','=',$task_id)->where('transaction_type','=','donated')->sum('amount');
        }
        return 0;
    }

    /**
     * Function will return total awarded fund to unit
     * @param $unit_id
     * @return int
     */
    public static function getUnitAwardedFund($unit_id=''){
        if(!empty($unit_id)){
            return self::where('unit_id','=',$unit_id)->where('transaction_type','=','awarded')->sum('amount');
        }
        return 0;
    }

    /**
     * Function will return total awarded fund to objective
     * @param $objective_id
     * @return int
     */
    public static function getObjectiveAwardedFund($objective_id=''){
        if(!empty($objective_id)){
            return self::where('objective_id','=',$objective_id)->where('transaction_type','=','awarded')->sum('amount');
        }
        return 0;
    }

    /**
     * Function will return total awarded funds to task.
     * @param $task_id
     * @return int
     */

    public static function getTaskAwardedFund($task_id=''){
        if(!empty($task_id)){
            return self::where('task_id','=',$task_id)->where('transaction_type','=','awarded')->sum('amount');
        }
        return 0;
    }

}
