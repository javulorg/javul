<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Issue;
use App\Models\Unit;
use App\Models\User;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class IssueController extends Controller
{
    public function index(Request $request)
    {
        $issues = Issue::query()
                ->with('unit')
                ->orderBy('id', 'DESC');
        $result = [];
        if(isset($request->unit))
        {
            $result = $issues->where('unit_id', $request->unit);
        }
        $result = $issues->get();
        return datatables($result)
            ->editColumn('title', function($row) {
                    $hash = new Hashids('issue id hash',10,Config::get('app.encode_chars'));
                    return
                        '<a href="'.url('issues/'.$hash->encode($row->id). '/view').'">'.$row->title.'</a>';

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
        $issues = Issue::query()
                ->with('unit')
                ->where('unit_id', $request->unit)
                ->orderBy('id', 'DESC')
                ->get();

        return datatables($issues)
            ->editColumn('title', function($row)
            {
                $hash = new Hashids('issue id hash',10,Config::get('app.encode_chars'));
                return
                    '<a href="'.url('issues/'.$hash->encode($row->id). '/view').'">'.$row->title.'</a>';
            })
            ->editColumn('status', function($row)
            {
                $statusClass = '';
                $verifiedBy  = '';
                $resolvedBy  = '';
                if ($row->status == "unverified")
                {
                    $statusClass = "text-danger";
                }
                elseif ($row->status == "verified")
                {
                    $statusClass = "text-info";
                    $verified_by = " (by " . User::getUserName($row->verified_by) . ')';
                }
                elseif ($row->status == "resolved")
                {
                    $statusClass = "text-success";
                    $resolved_by = " (by " . User::getUserName($row->resolved_by) . ')';
                }
                return '<span class="'.$statusClass.'">'.ucfirst($row->status).$verifiedBy.$resolvedBy.'</span>';
            })
            ->editColumn('created_by', function($row)
            {
                $userHash = new Hashids('user id hash',10,Config::get('app.encode_chars'));
                return
                    '<a href="'.url('userprofiles/'.$userHash->encode($row->user_id). '/' . strtolower(str_replace(" ","_",User::getUserName($row->user_id)))).'">'.User::getUserName($row->user_id).'</a>';
            })
            ->editColumn('created_date', function($row)
            {
                return $row->created_at;
            })
            ->rawColumns(['title','status','created_by','created_date'])
            ->toJson();
    }
}
