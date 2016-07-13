<?php namespace App\Listeners;


class UserEventListener {

    /**
     * Handle user login events.
     */
    public function onUserLogin($event) {
        $event->user->loggedin = 1;
        $event->user->save();
    }

    /**
     * Handle user logout events.
     */
    public function onUserLogout($event) {
        $event->user->loggedin = null;
        $event->user->save();
    }
}