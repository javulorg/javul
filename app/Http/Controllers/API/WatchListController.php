<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\IssueDocuments;
use App\Models\Unit;
use App\Models\UnitCategory;
use App\Models\Watchlist;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class WatchListController extends Controller
{
    public function units(Request $request)
    {
        $lists = Watchlist::join('units','my_watchlist.unit_id','=','units.id')
            ->where('my_watchlist.user_id',Auth::user()->id ?? null)
            ->whereNotNull('unit_id')->select(['units.*'])->get();

        return datatables($lists)
            ->editColumn('title', function($row)
            {
                $hash = new Hashids('unit id hash',10,Config::get('app.encode_chars'));
                return '<a href="'.url('units/'.$hash->encode($row->id). '/'. $row->slug).'">'.$row->name.'</a>';
            })
            ->editColumn('unit_category', function($row) {
                $category_ids = $row->category_id;
                $category_names = UnitCategory::getName($category_ids);
                $category_ids = explode(",", $category_ids);
                $category_names = explode(",", $category_names);
                $hash = new Hashids('unit category id hash',10,Config::get('app.encode_chars'));
                if(count($category_ids) > 0)
                {
                    foreach($category_ids as $index => $category)
                    {
                        return '<a href="'.url('units/category/'.$hash->encode($category)).'">'.UnitCategory::getName($category).'</a>';
                    }
                }
            })
            ->editColumn('description', function($row)
            {
                return trim($row->description);
            })
            ->rawColumns(['title','unit_category','description'])
            ->toJson();
    }

    public function objectives(Request $request)
    {
        $lists = Watchlist::join('objectives','my_watchlist.objective_id','=','objectives.id')
            ->where('my_watchlist.user_id',Auth::user()->id ?? null)
            ->whereNotNull('objective_id')->select(['objectives.*'])->get();

        return datatables($lists)
            ->editColumn('title', function($row)
            {
                $hash = new Hashids('objective id hash',10,Config::get('app.encode_chars'));
                return '<a href="'.url('objectives/'.$hash->encode($row->id). '/'. $row->slug).'">'.$row->name.'</a>';
            })
            ->editColumn('description', function($row)
            {
                return trim($row->description);
            })
            ->rawColumns(['title','description'])
            ->toJson();
    }

    public function tasks(Request $request)
    {
        $lists = Watchlist::join('tasks','my_watchlist.task_id','=','tasks.id')
            ->where('my_watchlist.user_id',Auth::user()->id ?? null)
            ->whereNotNull('task_id')->select(['tasks.*'])->get();

        return datatables($lists)
            ->editColumn('title', function($row)
            {
                $hash = new Hashids('task id hash',10,Config::get('app.encode_chars'));
                return '<a href="'.url('tasks/'.$hash->encode($row->id). '/'. $row->slug).'">'.$row->name.'</a>';
            })
            ->editColumn('description', function($row)
            {
                return trim($row->description);
            })
            ->rawColumns(['title','description'])
            ->toJson();
    }

    public function issues(Request $request)
    {
        $lists = Watchlist::join( 'issues','my_watchlist.issue_id','=','issues.id')
            ->where('my_watchlist.user_id',Auth::user()->id ?? null)
            ->whereNotNull('issue_id')->select(['issues.*'])->get();

        return datatables($lists)
            ->editColumn('title', function($row)
            {
                $hash = new Hashids('issue id hash',10,Config::get('app.encode_chars'));
                return '<a href="'.url('issues/'.$hash->encode($row->id). '/'. $row->slug. 'view').'">'.$row->title.'</a>';
            })
//            ->editColumn('description', function($row)
//            {
//                $category_ids = $row->category_id;
//                $category_names = $row->category_name;
//                $category_ids = explode(",",$category_ids);
//                $category_names  = explode(",",$category_names );
//                if(count($category_ids) > 0)
//                {
//                    $hash = new Hashids('issue document id hash',10,Config::get('app.encode_chars'));
//                    foreach($category_ids as $index=>$category)
//                    {
//                        return '<a href="'.url('issue/category/'.$hash->encode($category)).'">'.IssueDocuments::getName($category).'</a>';
//                    }
//                }
//            })
            ->editColumn('description', function($row)
            {
                return trim($row->description);
            })
            ->rawColumns(['title','description'])
            ->toJson();
    }



}
