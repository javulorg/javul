<?php


namespace App\Services\Objectives;



use Illuminate\Support\Facades\DB;
use App\Models\Objective;
use Illuminate\Http\Request;

class ObjectiveService
{
    public function comments($unitId, $sectionId, $objectId)
    {
        $comments = [];
        $forumTopic =  DB::table("forum_topic")
            ->select("topic_id")
            ->where("unit_id",$unitId)
            ->where("section_id",$sectionId)
            ->where("object_id",$objectId)
            ->first();
        if($forumTopic){
            $comments = DB::table('forum_post')
                ->where('topic_id', $forumTopic->topic_id)
                ->get();
        }
        return $comments;
    }

public function listAll(Request $request)
{
    $query = Objective::query();

    if ($request->filled('search')) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }

    return $query;
}


}


