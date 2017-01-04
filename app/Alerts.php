<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alerts extends Model
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'alerts';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id','alert_name','alert_status'];
}
