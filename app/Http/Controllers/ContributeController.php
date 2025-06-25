<?php

namespace App\Http\Controllers;

use App\Models\ActivityPoint;
use App\Models\Fund;
use App\Models\Unit;
use App\Services\SiteActivity\SiteActivityService;
use App\Traits\UnitTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContributeController extends Controller
{
    use UnitTrait;
    protected $service;
    public function __construct(SiteActivityService $service)
    {
        $this->service = $service;
    }

    public function view(Request $request)
    {
        $unitId = $request->query('unit');
        $mostActiveUnits = ActivityPoint::select(
            'units.id as unit_id',
            'units.name as unit_name',
            'users.id as user_id',
            'users.first_name as user_name',
            DB::raw('SUM(activity_points.points) as total_points')
        )
            ->join('units', 'activity_points.unit_id', '=', 'units.id')
            ->join('users', 'activity_points.user_id', '=', 'users.id')
            ->when($unitId, function ($query) use ($unitId) {
                return $query->where('units.id', $unitId);
            })
            ->groupBy('units.id', 'units.name', 'users.id', 'users.first_name')
            ->orderByDesc('total_points')
            ->limit(5)
            ->get();

        $activities = $this->service->listAll()->paginate(10);
        $total = $this->service->listAll()->count();

        if (isset($request->unit)) {
            $unitData = Unit::where('id', $request->unit)->first();
            $availableFunds = Fund::getUnitDonatedFund($request->unit);
            $awardedFunds = Fund::getUnitAwardedFund($request->unit);

            view()->share('availableFunds', $availableFunds);
            view()->share('awardedFunds', $awardedFunds);
            view()->share('unitData', $unitData);
            $issueResolutions = $this->calculateIssueResolution($request->unit);
            view()->share('totalIssueResolutions', $issueResolutions);
            view()->share('unitObj', $unitData);
        }
        $homeCheck = isset($request->home) ??  false;
        return view('V2.site-activities.top_contribute', compact('mostActiveUnits', 'total', 'homeCheck'));


        return view('V2.site-activities.top_contribute', ['mostActiveUnits' => $mostActiveUnits, 'unitData' => $unitData]);
    }
}
