<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Course;
use App\Tag;
use App\Lecture;
use App\Question;
use App\Reply;
use PhpParser\Comment;

class CommentReplyController extends Controller
{
    //
    public function addComment(Request $request)
    {
        $cmt = new Question();
        $cmt->target_id = $request->target_id;
        $cmt->comment = $request->comment;
        $cmt->commenter = $request->user_id;
        $cmt->save();
        $user = User::find($request->user_id);

        $comment = $cmt;
        $commenter = $user;
        return view('singleComment' , compact('comment' , 'commenter'));
    }

    public function addReply(Request $request)
    {
        $reply = new Reply();
        $reply->target_id = $request->target_id;
        $reply->reply = $request->reply;
        $reply->replier = $request->user_id;
        $reply->save();
        $replier = User::find($request->user_id);

        $comment_id = $reply->target_id;

//        return "lalala";
        return view('singleReply' , compact('reply' , 'replier' , 'comment_id'));
    }
}
