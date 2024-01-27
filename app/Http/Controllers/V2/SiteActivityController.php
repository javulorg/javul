<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Models\Fund;
use App\Models\Unit;
use App\Services\SiteActivity\SiteActivityService;
use App\Traits\UnitTrait;
use Illuminate\Http\Request;

class SiteActivityController extends Controller
{
    use UnitTrait;
    protected $service;
    public function __construct(SiteActivityService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $activities = $this->service->listAll()->paginate(10);
        $total = $this->service->listAll()->count();
        if(isset($request->unit))
        {
            $unitData = Unit::where('id', $request->unit)->first();
            $availableFunds = Fund::getUnitDonatedFund($request->unit);
            $awardedFunds = Fund::getUnitAwardedFund($request->unit);

            view()->share('availableFunds',$availableFunds );
            view()->share('awardedFunds',$awardedFunds );
            view()->share('unitData',$unitData);
            $issueResolutions = $this->calculateIssueResolution($request->unit);
            view()->share('totalIssueResolutions',$issueResolutions);
            view()->share('unitObj',$unitData);
        }
        $homeCheck = isset($request->home) ??  false;
        return view('V2.site-activities.index', compact('activities', 'total','homeCheck'));
    }

}
