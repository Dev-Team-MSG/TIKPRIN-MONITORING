<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ticket;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    //
    public function storeComment($no_ticket, Request $request) {
        $comment = new Comment();
        $comment->user_id = $request->user_id;
        $comment->no_ticket = $no_ticket;
        $comment->body = $request->body;
        $comment->save();
        $ticket = Ticket::with(["category", "severity", "assign_to", "owner", "comments"])->where("no_ticket", "=", $no_ticket)->firstOrFail();
        $comment = Comment::with(['user'])->where("no_ticket", "=", $ticket->no_ticket)->get();
        $data = [
            "message" => "Comment berhasil dibuat",
            "ticket" => $ticket,
            "comments" => $comment];

        // $user = User::with(["comments"])->get();
        // dd($comments);
        foreach($ticket->comments as $comment) {
            var_dump( $comment->user_id);
        }
        return response()->json(
            $data
        );
    }
}
