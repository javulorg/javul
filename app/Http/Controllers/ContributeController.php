<?php

namespace App\Http\Controllers;

use App\Models\ActivityPoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContributeController extends Controller
{
    public function view(){
        //  $mostActiveUnits = ActivityPoint::select('unit_id', DB::raw('SUM(points) as total_points'))
        //                 ->groupBy('unit_id')
        //                 ->orderByDesc('total_points')
        //                 ->limit(5)
        //                 ->get();



    $mostActiveUnits = ActivityPoint::select(
        'units.id as unit_id',
        'units.name as unit_name',
        'users.id as user_id',
        'users.first_name as user_name',
        DB::raw('SUM(activity_points.points) as total_points')
    )
    ->join('units', 'activity_points.unit_id', '=', 'units.id')
    ->join('users', 'activity_points.user_id', '=', 'users.id')
    ->groupBy('units.id', 'units.name', 'users.id', 'users.first_name')
    ->orderByDesc('total_points')
    ->limit(5)
    ->get();


                    //     $mostActiveUnits = \App\Models\Unit::leftJoin('activity_points', function ($join) use ($userId) {
                    //     $join->on('units.id', '=', 'activity_points.unit_id')
                    //         ->where('activity_points.user_id', '=', $userId)
                    //         ->where('activity_points.created_at', '>=', now()->subMonths(6));
                    // });

        return view('top_contribute',['mostActiveUnits' => $mostActiveUnits]);
    }
}
