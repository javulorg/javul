<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Hashids\Hashids;

class JobSkill extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'job_skills';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['skill_name','parent_id'];

    public static function getSkillNameLink($ids = ''){
        if(empty($ids))
            return '';

        $ids= explode(",",$ids);
        $html = '';
        if(count($ids) > 0){
            $jobSkillIDHashID = new Hashids('job skills id hash',10,\Config::get('app.encode_chars'));


            $i=0;
            foreach($ids as $id)
            {
                $skillObj =self::find($id);
                if(count($skillObj) > 0 )
                    $html.='<a href="'.url('job_skills/'.$jobSkillIDHashID->encode($skillObj->id )).'">'.$skillObj->skill_name.'</a>';

                if(count($ids) - 1 > $i)
                    $html.=", ";
                $i++;

            }
        }
        return $html;

    }

    public static function getName($id){
        $obj = self::find($id);
        if(count($obj) && !empty($obj))
            return $obj->skill_name;
    }

}
