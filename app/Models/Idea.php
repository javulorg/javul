<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Idea extends Model
{
    use HasFactory;
    protected $fillable = [
      'title',
      'user_id',
      'unit_id',
      'task_id',
      'issue_id',
      'type_id',
      'description',
      'comment',
      'status',
      'file',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
}
