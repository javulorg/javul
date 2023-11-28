<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteActivity extends Model
{
    use HasFactory;
    protected $table = 'site_activities';

    protected $fillable = ['user_id','unit_id','objective_id','task_id','issue_id','comment'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
