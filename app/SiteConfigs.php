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
       $credibility_types = ['platinum'=>'Platinum','gold'=>'gold','silver'=>'Silver','bronze'=>'Bronze'];
       if(!empty($type))
           return $credibility_types[$type];
       else
           return $credibility_types;
   }
}
