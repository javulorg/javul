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
            'in_progress'=>'In Progress','completion_evaluation'=>'Completion Evaluation','completed'=>'Completed',
            'cancelled'=>'Cancelled'];
        if(!empty($status) && isset($task_status[$status]))
            return $task_status[$status];
        return $task_status;

    }

    public static function getCardExpiryYear(){
        $currentYear = (int)date('Y');
        $years = [];
        for($i=$currentYear;$i<($currentYear+35);$i++ ){
            $years[$i]=$i;
        }
        return $years;
    }


    public static function getCreditCardType($number)
    {
        $number=preg_replace('/[^\d]/','',$number);
        if (preg_match('/^3[47][0-9]{13}$/',$number))
        {
            return 'American Express';
        }
        elseif (preg_match('/^3(?:0[0-5]|[68][0-9])[0-9]{11}$/',$number))
        {
            return 'Diners Club';
        }
        elseif (preg_match('/^6(?:011|5[0-9][0-9])[0-9]{12}$/',$number))
        {
            return 'Discover';
        }
        elseif (preg_match('/^(?:2131|1800|35\d{3})\d{11}$/',$number))
        {
            return 'JCB';
        }
        elseif (preg_match('/^5[1-5][0-9]{14}$/',$number))
        {
            return 'MasterCard';
        }
        elseif (preg_match('/^4[0-9]{12}(?:[0-9]{3})?$/',$number))
        {
            return 'Visa';
        }
        else
        {
            return 'Unknown';
        }
    }
}
