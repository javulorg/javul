<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RelatedUnit extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['unit_id','related_to'];
}
