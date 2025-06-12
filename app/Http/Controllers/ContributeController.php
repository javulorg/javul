<?php

namespace App\Http\Controllers;

use App\Models\ActivityPoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContributeController extends Controller
{
    public function view(Request $request)
    {
        $unitId = $request->query('unit'); // 👈 get 'unit' from query string

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

        return view('top_contribute', compact('mostActiveUnits'));
    }
}
