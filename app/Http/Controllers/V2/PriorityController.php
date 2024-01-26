<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Models\Priority;
use Illuminate\Http\Request;

class PriorityController extends Controller
{
    public function store(Request $request)
    {
        Priority::updateOrCreate(
          [
              'user_id'       => auth()->user()->id,
              'type_id'       => $request->type_id,
              'unit_id'       => $request->unit_id,
              'type'          => $request->type_value,
          ],
          [
              'user_id'       => auth()->user()->id,
              'type_id'       => $request->type_id,
              'unit_id'       => $request->unit_id,
              'type'          => $request->type_value,
              'value'         => $request->rating,
          ]
        );


        return response()->json(['success' => "saved successfully", 'status' => 201], 201);
    }
}
