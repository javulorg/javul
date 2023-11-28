<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Objective;
use App\Models\Task;
use App\Models\Unit;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class ObjectiveController extends Controller
{
    public function index(Request $request)
    {
        $objectives = Objective::query()
            ->with('unit')
            ->orderBy('id', 'DESC');

        $result = [];
        if(isset($request->unit))
        {
            $result = $objectives->where('unit_id', $request->unit);
        }
        $result = $objectives->get();
        return datatables($result)
            ->editColumn('title', function($row)
            {
                $hash = new Hashids('objective id hash',10,Config::get('app.encode_chars'));
                return '<a href="'.url('objectives/'.$hash->encode($row->id). '/' . $row->slug).'">'.$row->name.'</a>';
            })
            ->editColumn('unit', function($row)
            {
                if($row->unit != null)
                {
                    return $row->unit->name;
                }
            })
            ->rawColumns(['title', 'unit'])
            ->toJson();
    }


    public function unitView(Request $request)
    {
        $objectives = Objective::query()
            ->with('unit')
            ->where('unit_id', $request->unit)
            ->orderBy('id', 'DESC')
            ->get();

        return datatables($objectives)
            ->editColumn('title', function($row)
            {
                $hash = new Hashids('objective id hash',10,Config::get('app.encode_chars'));
                return '<a href="'.url('objectives/'.$hash->encode($row->id). '/' . $row->slug).'">'.$row->name.'</a>';
            })
            ->editColumn('support', function($row)
            {
                return Task::getTaskCount('available',$row->id);
            })
            ->editColumn('in_progress', function($row)
            {
               return Task::getTaskCount('in-progress',$row->id);
            })
            ->editColumn('available', function($row)
            {
                return Task::getTaskCount('completed',$row->id);
            })
            ->rawColumns(['title', 'support','in_progress','available'])
            ->toJson();
    }
}
