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
    protected $fillable = ['user_id','objective_id','issue_id','level','type'];
}
