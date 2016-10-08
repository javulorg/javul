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

    public static function getHierarchy($value,$page=0){
        if($page == 0)
            $obj = self::where('skill_name','like',$value.'%')->get();
        else {
            $offset = ($page - 1) * 10;
            $obj = self::where('skill_name', 'like', $value . '%')->skip($offset)->take(10)->get();
        }

        $names = [];
        if(!empty($obj) && count($obj) > 0){
            foreach($obj as $skill){
               if(!empty($skill->parent_id)){

                    $str = self::getParent($skill->parent_id,$skill->skill_name);
               }
               else{
                    $str = $skill->skill_name;
               }
                $names[]=['id'=>$skill->id,'name'=>$str];
            }

        }
        return $names;
    }

public static  $titles=[];
    public static function getParent($parent_id,$name){
        $obj = self::find($parent_id);
        global $titles;
        $titles[]=$name;
        if(!empty($obj) && !empty($obj->parent_id)) {
            //$titles[] =$obj->skill_name;
            return self::getParent($obj->parent_id,$obj->skill_name);
        }
        else {
            $titles[] = $obj->skill_name;
        }
        $tempTitles = $titles;
        $titles = [];
        return $tempTitles ;
    }

}
