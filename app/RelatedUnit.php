<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RelatedUnit extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'related_units';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = ['unit_id','related_to'];
}
