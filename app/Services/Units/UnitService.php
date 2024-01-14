<?php

namespace App\Services\Units;

use App\Models\ActivityPoint;
use App\Models\RelatedUnit;
use App\Models\SiteActivity;
use App\Models\Unit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UnitService
{
    public function store($request)
    {
        DB::transaction(function () use($request) {
            $unit = $this->saveUnit($request);
            $this->saveRelatedUnit($request, $unit);
            $this->saveActivityPoint($unit);
        });
    }

    private function saveUnit($request)
    {
        return Unit::create([
            'user_id'                     => Auth::user()->id,
            'name'                        => $request->unit_name,
            'slug'                        => substr(str_replace(" ","_",strtolower($request->unit_name)),0,20),
            'category_id'                 => implode(",",$request->unit_category),
            'description'                 => trim($request->description),
            'credibility'                 => $request->credibility,
            'country_id'                  => $request->country,
            'state_id'                    => $request->state,
            'city_id'                     => !empty($request->empty_city_state_name) ? null : $request->city,
            'status'                      => 'active',
            'parent_id'                   => $request->parent_unit,
            'state_id_for_city_not_exits' => $request->empty_city_state_name
        ]);
    }

    private function saveRelatedUnit($request, $unit)
    {
        if(!empty($request->related_to))
        {
            RelatedUnit::create([
                'unit_id'     => $unit->id,
                'related_to'  =>implode(",",$request->related_to)
            ]);
        }
    }

    private function saveActivityPoint($unit)
    {
        ActivityPoint::create([
            'user_id'      => Auth::user()->id,
            'unit_id'      => $unit->id,
            'points'       => 2,
            'comments'     => 'Unit Created',
            'type'         => 'unit'
        ]);
    }

    private function saveSiteActivity()
    {
        SiteActivity::create([
            'user_id'        => Auth::user()->id,
            'unit_id'        => $unit->id,
            'comment'        => '<a href="'.url('userprofiles/'.$userId.'/'.strtolower(Auth::user()->first_name.'_'.Auth::user()->last_name)).'">'
                .$userName.'</a>
                created
                 unit <a href="'.url('units/'.$unitId.'/'.$slug).'">'.$request->input('unit_name').'</a>'
        ]);
    }
}
