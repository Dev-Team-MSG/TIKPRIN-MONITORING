<?php

namespace App\Http\Controllers;

use App\Http\Resources\TicketResource;
use App\Models\CategoryTicket;
use App\Models\Comment;
use App\Models\Severity;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    //
    public function index(Request $request) {
        $status = $request->query("status");
        if($request->query("status")) {
            $ticket = Ticket::with(["category", "severity", "assign_to", "owner"])->where("status", $status)->get();
            return response()->json(
                $ticket
            );
        }
        $ticket = Ticket::with(["category", "severity", "assign_to", "owner"])->get();
        return response()->json(
            $ticket
        );
    }
    public function getOne($id) {
        $ticket = Ticket::with(["category", "severity", "assign_to", "owner", "comments"])->find($id);
        return response()->json(
            $ticket
        );
    }

    public function store(Request $request) {
        $ticket = new Ticket();
        $ticket->owner = $request->user_id;
        $ticket->no_ticket = "tiket". $ticket->id;
        $ticket->assign_to = $request->assign_to;
        $ticket->category_ticket_id = $request->category_ticket_id;
        $ticket->severity_id = $request->severity_id;
        $ticket->title = $request->title;
        $ticket->description = $request->description;
        $ticket->status = "open";
        $result = date('d.m.Y', strtotime('+7 day', time()));
        $ticket->due_datetime = $result;
        // $ticket->close_datetime = $result;
        $ticket->save();
        return request()->json("data berhasil ditambahkan");
    }

    public function take($id, Request $request) {
        $ticket = Ticket::with(["category", "comments"])->find($id);
        $ticket->status = "progress";
        $ticket->save();
        $comment = new Comment();
        $comment->user_id = $request->user_id;
        $comment->no_ticket = $ticket->no_ticket;
        $comment->body = "Tiket sedang di proses";
        $comment->save();
        $ticket = Ticket::with(["category", "comments"])->find($id);
        return response()->json(
            $ticket
        );
    }

    public function close($id, Request $request) {
        $ticket = Ticket::find($id);
        $ticket->status = "close";
        $ticket->close_datetime = Carbon::now();
        $ticket->save();
        $comment = new Comment();
        $comment->user_id = $request->user_id;
        $comment->no_ticket = $ticket->no_ticket;
        $comment->body = "Tiket sedang sudah di close / sudah selesai";
        $comment->save();
        $ticket = Ticket::with(["category", "comments"])->find($id);
        return response()->json(
            $ticket
        );
    }
}
