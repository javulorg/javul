<?php

namespace App\Services\Ideas;

use App\Models\Idea;
use Illuminate\Support\Facades\DB;

class IdeaService
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
        }
        return $comments;
    }
    public function listAll()
    {
        return Idea::query(); // ya koi bhi query jo tumhe chahiye
    }
}
