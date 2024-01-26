<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Priority extends Model
{
    use HasFactory;
    protected $fillable = [
      'type',
      'type_id',
      'unit_id',
      'user_id',
      'value',
    ];
}
