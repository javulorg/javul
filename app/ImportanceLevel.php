<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImportanceLevel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'importance_level';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id','objective_id','issue_id','importance_upvote','importance_downvote','type'];

    public static function checkImportanceLevel($objid)
    {
        if(!empty($objid))
        {
            $obj = self::where('objective_id',$objid)->first();
            if(!empty($obj)){
                if($obj->importance_upvote == 1)
                    return true;
            }
        }
        return false;
    }
}
