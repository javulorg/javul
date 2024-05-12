<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Models\CommentLike;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    public function like(Request $request)
    {
        $userComment = CommentLike::query()
            ->where('user_id', auth()->user()->id)
            ->where('comment_id', $request->comment_id)
            ->where('like', 1)
            ->first();


        $userDislike = CommentLike::query()
            ->where('user_id', auth()->user()->id)
            ->where('comment_id', $request->comment_id)
            ->where('dislike', 1)
            ->first();

        if($userDislike){
            $userDislike->delete();

            DB::table('forum_post')
                ->where('id', $request->comment_id)
                ->update([
                    'dislikes'        => DB::raw('dislikes-1')
                ]);
        }


        if($userComment){
            return response()->json(['message' => 'already liked this comment'], 400);
        }
        CommentLike::create([
            'user_id'      => auth()->user()->id,
            'comment_id'   => $request->comment_id,
            'like'         => 1,
        ]);
         DB::table('forum_post')
            ->where('id', $request->comment_id)
            ->update([
               'likes'        => DB::raw('likes+1')
            ]);

        $likeCount = CommentLike::query()
            ->where('id', $request->comment_id)
            ->where('like', 1)
            ->count();

        return response()->json(['message' => 'liked', 'like_count' => $likeCount], 200);
    }

    public function dislike(Request $request)
    {
        $userComment = CommentLike::query()
            ->where('user_id', auth()->user()->id)
            ->where('comment_id', $request->comment_id)
            ->where('dislike', 1)
            ->first();

        $userLike = CommentLike::query()
            ->where('user_id', auth()->user()->id)
            ->where('comment_id', $request->comment_id)
            ->where('like', 1)
            ->first();

        if($userLike){
            $userLike->delete();
            DB::table('forum_post')
                ->where('id', $request->comment_id)
                ->update([
                    'likes'        => DB::raw('likes-1')
                ]);
        }

        if($userComment){
            return response()->json(['message' => 'already disliked this comment'], 400);
        }
        CommentLike::create([
            'user_id'      => auth()->user()->id,
            'comment_id'   => $request->comment_id,
            'dislike'         => 1,
        ]);
        DB::table('forum_post')
            ->where('id', $request->comment_id)
            ->update([
                'dislikes'        => DB::raw('dislikes+1')
            ]);
        $dislikeCount = CommentLike::query()
            ->where('id', $request->comment_id)
            ->where('dislike', 1)
            ->count();
        return response()->json(['message' => 'disliked', 'dislike_count' => $dislikeCount], 200);
    }
}
