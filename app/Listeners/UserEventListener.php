<?php namespace App\Listeners;


use App\SiteActivity;
use Hashids\Hashids;

class UserEventListener {

    /**
     * Handle user login events.
     */
    public function onUserLogin($event) {

        $userIDHashID = new Hashids('user id hash',10,\Config::get('app.encode_chars'));
        $user_id = $userIDHashID->encode($event->user->id);

        SiteActivity::create([
            'user_id'=>$event->user->id,
            'comment'=>'<a href="'.url('userprofiles/'.$user_id.'/'.strtolower($event->user->first_name.'_'.$event->user->last_name)).'">'
                .$event->user->first_name.' '.$event->user->last_name
                .'</a> logged in to system'
        ]);

        $event->user->loggedin = 1;
        $event->user->save();
    }

    /**
     * Handle user logout events.
     */
    public function onUserLogout($event) {
        $userIDHashID = new Hashids('user id hash',10,\Config::get('app.encode_chars'));
        $user_id = $userIDHashID->encode($event->user->id);

        SiteActivity::create([
            'user_id'=>$event->user->id,
            'comment'=>'<a href="'.url('userprofiles/'.$user_id.'/'.strtolower($event->user->first_name.'_'.$event->user->last_name)).'">'
                .$event->user->first_name.' '.$event->user->last_name.'</a> logout from system'
        ]);
        $event->user->loggedin = null;
        $event->user->save();
    }
}