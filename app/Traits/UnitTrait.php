<?php

namespace App\Traits;

use App\Models\Issue;

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
}
