<?php


namespace App\Services\Issues;


use Hashids\Hashids;
use Illuminate\Support\Facades\Config;
use App\Models\Issue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IssueService
{
    public function comments($unitId, $sectionId, $objectId)
    {
        $comments = [];
        $forumTopic =  DB::table("forum_topic")
            ->select("topic_id")
            ->where("unit_id", $unitId)
            ->where("section_id", $sectionId)
            ->where("object_id", $objectId)
            ->first();
        if ($forumTopic) {
            $comments = DB::table('forum_post')
                ->where('topic_id', $forumTopic->topic_id)
                ->get();
            //            dd($comments->toArray());
        }

        return $comments;
    }

    public function store($request) {}

    public function update($request, $issueId) {}

public function listAll(Request $request)
{
    $query = Issue::query();

    if ($request->filled('search')) {
        $query->where('title', 'like', '%' . $request->search . '%');
    }

    return $query;
}

}
