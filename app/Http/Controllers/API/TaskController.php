<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SiteConfigs;
use App\Models\Task;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $tasks = Task::query()
            ->with('unit')
            ->orderByDesc('id');


        if(isset($request->unit))
        {
            $result = $tasks->where('unit_id', $request->unit);
        }
        $result = $tasks->get();

        return datatables($result)
            ->editColumn('title', function($row)
            {
                $hash = new Hashids('task id hash',10,Config::get('app.encode_chars'));
                return '<a href="'.url('tasks/'.$hash->encode($row->id). '/' . $row->slug).'">'.$row->name.'</a>';
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
        $tasks = Task::query()
            ->with('unit')
            ->where('unit_id', $request->unit)
            ->orderByDesc('id')
            ->get();

        return datatables($tasks)
            ->editColumn('title', function($row)
            {
                $hash = new Hashids('task id hash',10,Config::get('app.encode_chars'));
                return '<a href="'.url('tasks/'.$hash->encode($row->id). '/' . $row->slug).'">'.$row->name.'</a>';
            })
            ->editColumn('status', function($row)
            {
                if($row->status == "editable")
                {
                    return '<span class="text-success">'. SiteConfigs::task_status($row->status). '</span>';
                }else{
                    return '<span class="text-success">'. SiteConfigs::task_status($row->status). '</span>';
                }
            })
            ->editColumn('in_progress', function($row)
            {
                return Task::getTaskCount('in-progress',$row->id);
            })
            ->editColumn('completed', function($row)
            {
                return Task::getTaskCount('completed',$row->id);
            })
            ->rawColumns(['title', 'status','in_progress','completed'])
            ->toJson();
    }


}
