<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
	 /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'transactions';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id','amount','trans_type','comments'];
}
