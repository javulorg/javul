<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CreditCards extends Model
{
	 /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'credit_cards';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id','card_number'];


    public static function getCardName($customer_id){

    }
}
