<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Hashids\Hashids;

class Unit extends Model
{

    use SoftDeletes;
    protected $dates = ['deleted_at'];
    public $timestamps = true;

    protected $table = 'units';


    protected $fillable = [
        'unit_type',
        'product_name',
        'service_name',
        'business_model',
        'operational_grade',
        'company',
        'scope',

        'user_id',
        'category_id',
        'name',
        'description',
        'credibility',
        'country_id',
        'state_id',
        'city_id',
        'status',
        'parent_id',
        'modified_by',
        'slug',
        'featured_unit',
        'state_id_for_city_not_exits'
    ];


    public function category()
    {
        return $this->belongsTo(UnitCategory::class, 'category_id');
    }

    public function watchlist()
    {
        return $this->belongsTo(Watchlist::class);
    }


    public function objectives()
    {
        return $this->hasMany(Objective::class);
    }


    public function tasks()
    {
        return $this->hasManyThrough(Task::class,Objective::class);
    }

    public static function getUnitWithCategories($unit_id = '')
    {
        $query = DB::table('units')
            ->select(
                'units.*',
                'cr.total_member',
                DB::raw('GROUP_CONCAT(unit_category.name SEPARATOR ", ") as category_name'),
                DB::raw('(SELECT COUNT(*) FROM forum_topic WHERE unit_id = units.id) as totaltopic')
            )
            ->leftJoin('chat_room as cr', 'cr.unit_id', '=', 'units.id')
            ->leftJoin('unit_category', function ($join) {
                $join->on('units.category_id', 'IS', DB::raw('NOT NULL'))
                    ->whereRaw('FIND_IN_SET(unit_category.id, units.category_id) > 0');
            })
            ->whereNull('units.deleted_at');

        if (!empty($unit_id)) {
            $query->where('units.id', $unit_id);
        }

        $query->groupBy('units.id');

        $unitsObj = $query->get();

        if (count($unitsObj) == 1) {
            $unitsObjTmp = $unitsObj[0];
            if (!empty($unit_id)) {
                $extraWhere = [
                    ['wiki_pages.unit_id', '=', $unit_id],
                    ['wiki_pages.is_wikihome', '=', 3]
                ];

                $wiki = DB::table('wiki_pages')
                    ->select('page_content')
                    ->where($extraWhere)
                    ->first();

                if (!empty($wiki)) {
                    $unitsObjTmp->other_menulink = Wiki::parse($wiki->page_content);
                } else {
                    $unitsObjTmp->other_menulink = "Other Link";
                }

                return $unitsObjTmp;
            }

            $unitsObj = array_filter((array) $unitsObj[0]);
            if (!empty($unitsObj)) {
                $temp[] = (object) $unitsObjTmp;
                return $temp;
            }
        }

        if (count($unitsObj) > 0) {
            return $unitsObj[0];
        }

        return $unitsObj;
    }


    public static function checkUnitExist($unit_id,$needToDecode=false)
    {
        if($needToDecode)
        {
            $unitIDHashID = new Hashids('unit id hash',10,Config::get('app.encode_chars'));
            $unit_id = $unitIDHashID->decode($unit_id );

            if(empty($unit_id))
                return false;
            $unit_id = $unit_id[0];

            if(Unit::find($unit_id)->count() == 0)
                return false;
            return true;
        }

    }

    public static function getAllCountryWithFrequent()
    {
        $top10MostCountries = self::join('countries','units.country_id','=','countries.id')
            ->groupBy('country_id')
            ->orderBy('units_id', 'desc')
            ->selectRaw('max(countries.id) as countriesid , max(countries.name) as countriesname, max(units.id) as units_id')
            ->limit(10)
            ->pluck('countriesname','countriesid')
            ->all();


        $top10MostCountries['dash_line']='dash_line';
        $countries_id = array_keys($top10MostCountries);
        $otherCountries = Country::whereNotIn('id',$countries_id)->where('id','!=','247')->pluck('name','id')->all();

        $all=['247'=>'Global','dash_line1'=>'dash_line1']+($top10MostCountries + $otherCountries );

        return $all;
    }

    public static function getUnitName($unit_id)
    {
        $obj = self::withTrashed()->find($unit_id);
        if(!empty($obj))
            return $obj->name;
        else
            return false;
    }
    public static function getSlug($unit_id)
    {
        $obj = self::withTrashed()->find($unit_id);
        if(!empty($obj))
            return $obj->slug;
        else
            return false;

    }
    public static function getCategoryNames($category_id)
    {
        $categoryObj = UnitCategory::whereIn('id',explode(",",$category_id))->pluck('name')->all();
        if(!empty($categoryObj))
            return implode(", ",$categoryObj);
        return "-";
    }

    public static function getObj($unit_id)
    {
        $unitIDHashID = new Hashids('unit id hash',10,Config::get('app.encode_chars'));
        $unit_id = $unitIDHashID->decode($unit_id );

        if(empty($unit_id))
            return [];
        $unit_id = $unit_id[0];

        if(Unit::find($unit_id)->count() > 0)
            return Unit::find($unit_id);
        return [];
    }
}
