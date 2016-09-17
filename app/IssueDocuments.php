<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IssueDocuments extends Model
{

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'issue_documents';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['issue_id','file_name','file_path'];

    /**
     * Get Parent Objective of Tasks..
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function issue(){
        return  $this->belongsTo('App\Issue');
    }
}
