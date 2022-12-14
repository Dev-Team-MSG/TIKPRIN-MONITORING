<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Comment;
use App\Notifications\TicketUpdateNotification;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    //
    public function storeComment($no_ticket, Request $request)
    {
        // dd($request);
        try {
            $comment = new Comment();
            $comment->user_id = $request->user_id;
            $comment->no_ticket = $no_ticket;
            $comment->body = isset($request->body) ? $request->body : "";
            if ($request->hasFile("fileName")) {
                // return response()->json(['upload_file_not_found'], 400);
                $allowedfileExtension = ['pdf', 'jpg', 'png'];
                $files = $request->file('fileName');
                // dd($files);
                $errors = [];
                foreach ($files as $file) {

                    $extension = $file->getClientOriginalExtension();

                    $check = in_array($extension, $allowedfileExtension);
                    if ($check) {
                        $comment->save();
                        foreach ($request->fileName as $mediaFiles) {

                            $path = $mediaFiles->store('public/images');
                            $filepath = str_replace("public", "storage", $path);
                            $name = $mediaFiles->getClientOriginalName();

                            //store image file into directory and db
                            $save = new File();
                            $save->filename = $name;
                            $save->path = $filepath;
                            $comment->files()->save($save);
                        }
                    } else {
                        return redirect()->back()->with("error", "Tipe file yang diupload tidak sesuai, anda hanya bisa mengirimkan file bertipe [pdf, jpg, png]");
                    }
                }
            } else {
                $comment->save();
            }
            $ticket = Ticket::where("no_ticket", "=", $no_ticket)->first();
            if ($ticket->owner_id != $comment->user_id) {
                $user = User::where("id", $ticket->owner_id)->first();
                $user->notify(new TicketUpdateNotification($ticket));
            }
            return redirect()->back();
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with("error",);
        }
    }

    public function attachfile()
    {
        $comment = Comment::with(["files"])->get();
        return response()->json($comment);
    }
    public function storeFile(Request $request, $id)
    {
        $comment = Comment::find($id);
        // dd($request->file());
        if (!$request->hasFile("fileName")) {
            dd("error");
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

                    $path = $mediaFiles->store('storage/images');
                    $name = $mediaFiles->getClientOriginalName();

                    //store image file into directory and db
                    $save = new File();
                    $save->filename = $name;
                    $save->path = $path;
                    $comment->files()->save($save);
                }
            } else {
                dd("invalid format");
                return response()->json(['invalid_file_format'], 422);
            }
        }
        // return response()->json(['file_uploaded'], 200);
    }
}
