<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiteActivity extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'site_activity';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id','comment'];
}
