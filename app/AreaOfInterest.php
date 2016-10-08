<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AreaOfInterest extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'area_of_interest';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title','parent_id'];

    public static function getName($id){
        $obj = self::find($id);
        if(count($obj) && !empty($obj))
            return $obj->title;
    }

}
