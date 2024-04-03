<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = [
      'title_type',
      'resource_type',
      'action_type',
      'title',
      'description',
      'user_id',
      'is_read',
    ];
}
