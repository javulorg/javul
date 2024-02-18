<?php

namespace App\Http\Controllers\V2\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Fund;
use App\Models\Unit;
use App\Traits\UnitTrait;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class SettingController extends Controller
{
    use UnitTrait;
    public function index($unitHashId)
    {
        $unitIDHashID = new Hashids('unit id hash',10,Config::get('app.encode_chars'));
        $unitId = $unitIDHashID->decode($unitHashId);

        $unit = Unit::findOrFail($unitId[0]);
        $availableFunds =Fund::getUnitDonatedFund($unitId[0]);
        $awardedFunds =Fund::getUnitAwardedFund($unitId[0]);
        $categories = Category::query()
            ->where('unit_id', $unitId[0])
            ->get();

        $issueResolutions = $this->calculateIssueResolution($unitId[0]);

        view()->share('totalIssueResolutions',$issueResolutions);
        view()->share('availableFunds',$availableFunds );
        view()->share('awardedFunds',$awardedFunds );
        view()->share('unitObj',$unit);
        view()->share('categories',$categories);
        return view('admin.settings.index');
    }
}
