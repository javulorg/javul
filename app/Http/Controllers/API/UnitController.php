<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use App\Models\UnitCategory;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class UnitController extends Controller
{
    public function index(Request $request)
    {

        $issues = Unit::query()
            ->orderBy('id', 'DESC')
            ->get();


        return datatables($issues)
            ->editColumn('title', function($row) {
                $hash = new Hashids('unit id hash',10,Config::get('app.encode_chars'));
                    return
                        '<a href="'.url('units/'.$hash->encode($row->id). '/'. $row->slug).'">'.$row->name.'</a>';
            })
            ->editColumn('unit_category', function($row) {
                $category_ids = $row->category_id;
                $category_names = UnitCategory::getName($category_ids);
                $category_ids = explode(",", $category_ids);
                $category_names = explode(",", $category_names);

                if(count($category_ids) > 0)
                {
                    foreach($category_ids as $index => $category)
                    {
                        return '<a href="'.url('units/category='.strtolower($category_names[$index])).'">'.$category_names[$index].'</a>';
                    }
                }
            })
            ->rawColumns(['title','unit_category'])
            ->toJson();
    }
}
