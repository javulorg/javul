<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaypalTransaction extends Model
{
	 /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'paypal_transaction';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['transaction_id','response'];
}
