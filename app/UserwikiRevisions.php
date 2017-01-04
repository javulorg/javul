<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class UserwikiRevisions extends Model
{
    protected $table = 'userwiki_revisions';
    protected $fillable = ['page_content','page_title','user_id'];
}
