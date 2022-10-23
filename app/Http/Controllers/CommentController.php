<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    //
    public function storeComment($no_ticket, Request $request) {
        dd($request);
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

    public function attachfile()
    {
        $comment = Comment::with(["files"])->get();
        return response()->json($comment);
    }
    public function storeFile(Request $request) {
        $comment = Comment::find(1);
        if (!$request->hasFile("fileName")) {
            return response()->json(['upload_file_not_found'], 400);
        }
        // dd($request->filename);
        $allowedfileExtension = ['pdf', 'jpg', 'png'];
        $files = $request->file('fileName');
        // dd($files);
        $errors = [];
        foreach ($files as $file) {

            $extension = $file->getClientOriginalExtension();

            $check = in_array($extension, $allowedfileExtension);

            if ($check) {
                foreach ($request->fileName as $mediaFiles) {

                    $path = $mediaFiles->store('public/images');
                    $name = $mediaFiles->getClientOriginalName();

                    //store image file into directory and db
                    $save = new File();
                    $save->filename = $name;
                    $save->path = $path;
                    $comment->files()->save($save);
                }
            } else {
                return response()->json(['invalid_file_format'], 422);
            }
        }
        return response()->json(['file_uploaded'], 200);
    }
}
