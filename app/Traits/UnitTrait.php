<?php

namespace App\Traits;

use App\Models\Issue;
use App\Models\Priority;

trait UnitTrait
{
    public function calculateIssueResolution($unitId)
    {
        $verifiedIssues = Issue::query()
            ->where('unit_id', $unitId)
            ->where('verified', 1)
            ->count();

        $resolvedIssues = Issue::query()
            ->where('unit_id', $unitId)
            ->where('status', 1)
            ->count();


        if($verifiedIssues > 0 && $resolvedIssues > 0){
            return $resolvedIssues / ($verifiedIssues * 100);
        }else{
            return 0;
        }
    }

    public function calculateRate($type, $typeId, $unitId)
    {
        $sum = Priority::query()
            ->where('type', $type)
            ->where('type_id', $typeId)
            ->where('unit_id', $unitId)
            ->sum('value');

        $totalNumber = Priority::query()
            ->where('type', $type)
            ->where('type_id', $typeId)
            ->where('unit_id', $unitId)
            ->count();
        if($sum != 0 && $totalNumber != 0)
        {
            return $sum / $totalNumber;
        }
        return 0;
    }
}
