<?php

namespace App\Models;

use Hashids\Hashids;
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
      'category_id',
      'description',
      'comment',
      'status',
      'file',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function issue()
    {
        return $this->belongsTo(Issue::class, 'issue_id');
    }

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }


}
