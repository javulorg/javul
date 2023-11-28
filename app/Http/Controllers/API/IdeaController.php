<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Idea;
use App\Models\Unit;
use App\Models\User;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class IdeaController extends Controller
{
    public function index()
    {
        $ideas = Idea::query()
            ->with('unit')
            ->orderBy('id', 'DESC')
            ->get();

        return datatables($ideas)
            ->editColumn('title', function($row) {
                $hash = new Hashids('idea id hash',10,Config::get('app.encode_chars'));
                return
                    '<a href="'.url('ideas/'.$hash->encode($row->id)).'">'.$row->title.'</a>';

            })
            ->editColumn('unit', function($row) {
                if($row->unit != null)
                {
                    $hash = new Hashids('unit id hash',10,Config::get('app.encode_chars'));
                    return
                        '<a href="'.url('units/'.$hash->encode($row->unit_id). '/' . Unit::getSlug($row->unit_id)).'">'.Unit::getUnitName($row->unit_id).'</a>';
                }
            })
            ->rawColumns(['title','unit'])
            ->toJson();
    }

    public function unitView(Request $request)
    {
        $ideas = Idea::query()
            ->with('unit')
            ->where('unit_id', $request->unit)
            ->orderBy('id', 'DESC')
            ->get();

        return datatables($ideas)
            ->editColumn('title', function($row)
            {
                $hash = new Hashids('idea id hash',10,Config::get('app.encode_chars'));
                return
                    '<a href="'.url('ideas/'.$hash->encode($row->id)).'">'.$row->title.'</a>';
            })
            ->editColumn('status', function($row)
            {
                if($row->status == 1)
                {
                    return "Draft";
                }elseif ($row->status == 2)
                {
                    return "Assigned to Task";
                }else{
                    return "Implemented";
                }
            })

            ->rawColumns(['title', 'status'])
            ->toJson();
    }
}
