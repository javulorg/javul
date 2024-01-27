<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObjectiveIdea extends Model
{
    use HasFactory;
    protected $fillable = [
      'objective_id',
      'idea_id',
    ];
}
