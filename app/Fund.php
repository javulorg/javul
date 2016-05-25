<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fund extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id','unit_id','objective_id','amount','transaction_type','fund_type'];
}
