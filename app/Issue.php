<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id','unit_id','objective_id','task_id','title','description','file_attachments','status','resolution'];

    /**
     * Get Parent Task of Issue..
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function task(){
        return $this->belongsTo('App\Task');
    }
}
