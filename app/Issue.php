<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Hashids\Hashids;
use Illuminate\Http\Request;
class Issue extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id','comment','unit_id','objective_id','task_id','title','description','file_attachments','status','resolution','verified_by','resolved_by'];

    /**
     * Get Parent Task of Issue..
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function issue_documents(){
        return $this->hasMany('App\IssueDocuments');
    }

    public static function getSelectedObjective($request){
        $selected_objective_id = $request->input('objective_id');
        $objectiveIDHashID= new Hashids('objective id hash',10,\Config::get('app.encode_chars'));
        $selected_objective_id = $objectiveIDHashID->decode($selected_objective_id);

        if(!empty($selected_objective_id) && count($selected_objective_id) > 0)
            $selected_objective_id = $selected_objective_id[0];
        else
            $selected_objective_id= null;

        return $selected_objective_id;
    }

    public static function getSelectedTask($request){
        $selected_task_id_arr = null;
        $selected_task_ids= $request->input('task_id');
        $selected_objective_id = $request->input('objective_id');
        if(!empty($selected_task_ids) && count($selected_task_ids) > 0 && !empty($selected_objective_id)) {
            $taskIDHashID= new Hashids('task id hash',10,\Config::get('app.encode_chars'));
            foreach($selected_task_ids as $selected_task_id){
                $selected_task_id = $taskIDHashID->decode($selected_task_id);
                if(!empty($selected_task_id) && count($selected_task_id) > 0)
                    $selected_task_id_arr[]=$selected_task_id[0];
            }
            $selected_task_id_arr = implode(",",$selected_task_id_arr);
        }
        if(!empty($selected_task_id_arr))
            return $selected_task_id_arr;
        else
            return null;
    }
}
