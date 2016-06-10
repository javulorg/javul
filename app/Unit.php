<?php

namespace App;

use ___PHPSTORM_HELPERS\object;
use Illuminate\Database\Eloquent\Model;
use DB;
use Hashids\Hashids;

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
    protected $fillable = ['user_id','category_id','name','description','credibility','country_id','state_id','city_id','status',
        'parent_id','modified_by'];

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
            "(units.category_id IS NOT NULL and FIND_IN_SET(unit_category.id,units.category_id) > 0  ) $where GROUP BY units.id") );

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

    /**
     * function will check whether unit_id is exist in unit table or not
     * @param $unit_id
     * @param bool $needToDecode
     * @return bool
     */
    public static function checkUnitExist($unit_id,$needToDecode=false)
    {
        if($needToDecode){
            $unitIDHashID = new Hashids('unit id hash',10,\Config::get('app.encode_chars'));
            $unit_id = $unitIDHashID->decode($unit_id );

            if(empty($unit_id))
                return false;
            $unit_id = $unit_id[0];

            if(Unit::find($unit_id)->count() == 0)
                return false;
            return true;
        }

    }

    public static function getAllCountryWithFrequent(){
        $top10MostCountries = self::join('countries','units.country_id','=','countries.id')->groupBy('country_id')->orderBy('units.id',
            'desc')->select(['countries.id','countries.name'])->limit(10)->lists('countries.name','countries.id')->all();

        /*$top10MostCountries['dash_line']='dash_line';*/
        $countries_id = array_keys($top10MostCountries);
        $otherCountries = Country::whereNotIn('id',$countries_id)->lists('name','id')->all();

        $all=['global'=>'Global'/*,'dash_line1'=>'dash_line1'*/]+($top10MostCountries + $otherCountries );

        return $all;
    }

    public static function getUnitName($unit_id){
        return self::find($unit_id)->name;
    }
}
