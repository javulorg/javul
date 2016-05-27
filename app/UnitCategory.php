<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnitCategory extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'unit_category';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','status','parent_id'];

    /**
     * Get Unit of Category...
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function units(){
        return $this->hasMany('App\Unit','category_id');
    }

}
