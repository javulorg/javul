<?php

namespace App;

use ___PHPSTORM_HELPERS\object;
use Illuminate\Database\Eloquent\Model;
use DB;

class Unit extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'units';

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


    /**
     * function will return unit with it's category name. if unit having multiple category then it will return all category name with unit.
     * @param string $unit_id
     * @return mixed
     */
    public static function getUnitWithCategories($unit_id=''){
        $where= '';
        if(!empty($unit_id))
            $where = " WHERE units.id='".$unit_id."' ";

        $unitsObj = \DB::select( DB::raw("SELECT units.*,GROUP_CONCAT(unit_category.name) as category_name FROM units INNER JOIN unit_category ON " .
            "(units.category_id IS NOT NULL and FIND_IN_SET(unit_category.id,units.category_id) > 0  ) $where ") );


        if(count($unitsObj) == 1){
            $unitsObjTmp = $unitsObj[0];
            $unitsObj= array_filter((array)$unitsObj[0]);
            if(!empty($unitsObj)){
                $temp[] =(object)$unitsObjTmp ;
                return $temp;
            }
        }
        return $unitsObj;
    }
}
