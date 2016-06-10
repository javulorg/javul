<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskDocuments extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'task_documents';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['task_id','file_path'];

}
