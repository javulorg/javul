<?php

namespace App;

use App\Http\Requests\Request;
use Faker\Provider\File;
use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;

class SiteConfigs extends Model
{
    /**
     * function return unit credibility types for unit creation and updation
     * @param string $type
     * @return array
     */
    public static function getUnitCredibilityTypes($type=''){
       $credibility_types = ['platinum'=>'Platinum','gold'=>'Gold','silver'=>'Silver','bronze'=>'Bronze'];
       if(!empty($type))
           return $credibility_types[$type];
       else
           return $credibility_types;
   }

    public static function task_status($status=''){
        $task_status = ['editable'=>'Editable','awaiting_approval'=>'Awaiting Approval','approval'=>'Approval',
            'open_for_bidding'=>'Open for Bidding','assigned'=>'Assigned','awaiting_assignment'=>'Awaiting Assignment',
            'in_progress'=>'In Progress'];
        if(!empty($status) && isset($task_status[$status]))
            return $task_status[$status];
        return $task_status;

    }
}
