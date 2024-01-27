<?php

namespace App\Traits;

use App\Models\ActivityPoint;
use App\Models\SiteActivity;
use Hashids\Hashids;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

trait WikiTrait
{
    public function saveUnitWikiPage($unit)
    {
        $wiki_pages = array(
            'unit_id'           => $unit->id,
            'wiki_page_title'   => "About",
            'page_content'      => $unit->description,
            'edit_comment'      => null,
            'user_id'           => Auth::user()->id,
            'is_unit_page'      => 1
        );
        $wiki_pages['time_stamp'] = date("Y-m-d H:i:s");
        $wiki_page_id =  DB::table('wiki_pages')->insertGetId($wiki_pages);
        DB::table('wiki_pages')
            ->where('id', $wiki_page_id)
            ->update([
                'wiki_page_id'  => $wiki_page_id
            ]);

        $userIDHashID             = new Hashids('user id hash',10, Config::get('app.encode_chars'));
        $user_id                  = $userIDHashID->encode(Auth::user()->id);
        $unitIDHashID             = new Hashids('unit id hash',10, Config::get('app.encode_chars'));
        $unit_id                  = $unitIDHashID->encode($unit->id);

        ActivityPoint::create([
            'user_id'      => Auth::user()->id,
            'unit_id'      => $unit->id,
            'points'       => 1,
            'comments'     => 'Wiki Create',
            'type'         => 'wiki'
        ]);

        $loggedinUsername     = strtolower(Auth::user()->first_name.'_'.Auth::user()->last_name);
        if(!empty(Auth::user()->username))
            $loggedinUsername = Auth::user()->username;

        SiteActivity::create([
            'user_id'       => Auth::user()->id,
            'unit_id'       => $unit->id,
            'comment'       => '<a href="'.url('userprofiles/'.$user_id.'/'.strtolower(Auth::user()->first_name.'_'.Auth::user()->last_name)).'">'
                .$loggedinUsername.'</a>
                    created wiki page <a href="'.url('wiki/'.$unit_id.'/'.$wiki_page_id.'/'. $unit->slug) .'">'. $unit->title .'</a>'
        ]);
    }
}
