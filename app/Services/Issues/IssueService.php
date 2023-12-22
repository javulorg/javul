<?php


namespace App\Services\Issues;


use Illuminate\Support\Facades\DB;

class IssueService
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
}
