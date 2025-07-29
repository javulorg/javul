<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdeaTask extends Model
{
    protected $table = 'ideas';
    use HasFactory;
    protected $fillable = [
      'idea_id',
      'task_id',
    ];
}
