<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityPoint extends Model
{
    protected $fillable = [
        'user_id',
        'unit_id',
        'objective_id',
        'task_id',
        'issue_id',
        'idea_id',
        'points',
        'comments',
        'type'
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function objective()
    {
        return $this->belongsTo(Objective::class, 'objective_id');
    }

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }
    public function issue()
    {
        return $this->belongsTo(Issue::class, 'issue_id');
    }

    public function idea()
    {
        return $this->belongsTo(Idea::class, 'idea_id');
    }
}
