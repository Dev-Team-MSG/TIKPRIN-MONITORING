<?php

namespace App\Http\Controllers;

use App\Http\Resources\TicketResource;
use App\Models\CategoryTicket;
use App\Models\Comment;
use App\Models\File;
use App\Models\Severity;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TicketController extends Controller
{

    public function __construct() 
    {
        $this->middleware("can:create tiket")->only("buatTiket", "simpanTiket");
    }

    public function detailTicket($no_ticket) {
        $data = Ticket::with(["category", "severity", "assign_to", "owner", "comments"])->where("no_ticket", $no_ticket)->first();
        
        // dd($data);
        return view("tiket.detail", compact("data", "count_open", "count_progress", "count_close"));
    }


    public function showCloseTicket(Request $request)
    {
        $data = Ticket::with(["category", "owner"])->select("created_at", "no_ticket", "owner_id", "title", "status", "description", "category_ticket_id")->where("status", "close")->get();
        // dd($data);
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn("Jenis Pengaduan", function (Ticket $ticket) {
                    $cat = $ticket->category->category;
                    $span = '';
                    if ($cat == "Request ink/print-head") {
                        $span = '<span class="badge badge-primary">' . strtoupper($cat) . '</span>';
                    } else {
                        $span = '<span class="badge badge-secondary">' . strtoupper($cat) . '</span>';
                    }
                    return $span;
                })
                ->addColumn("pelapor", function (Ticket $ticket) {
                    return $ticket->owner;
                })
                ->addColumn("permasalahan", function (Ticket $ticket) {
                    if (strlen($ticket->description) > 50) {
                        $str = substr($ticket->description, 0, 7) . '...';
                        return $str;
                    }
                    return $ticket->description;
                })
                ->addColumn("luarbiasa", function (Ticket $ticket) {
                    $status = $ticket->status;
                    $span = '';
                    if ($status == "open") {
                        $span = '<span class="badge badge-success">' .strtoupper($status)  . '</span>';
                    } else if ($status == "progress") {
                        $span = '<span class="badge badge-warning">' . strtoupper($status) . '</span>';
                        
                    }else {
                        $span = '<span class="badge badge-danger">' . strtoupper($status) . '</span>';
                        
                    }
                    return $span;
                })->escapeColumns([])
                ->addColumn("Tanggal Pengaduan", function (Ticket $ticket) {
                    return $ticket->created_at->format('d/m/y h:m:s');
                })
                ->addColumn('action', function ($row) {
                    // $btn = '<a href="javascript:void(0)" class="edit btn btn-light"><i class="fa-regular fa-comments"></i></a>';
                    return '<a href="'. route("detail-ticket", [$row->no_ticket]). '" class="edit btn btn-light"><i class="fa-regular fa-comments"></i></a>';
                    // return $btn;
                })
                ->rawColumns(['action', "Jenis Pengaduan", "created_at"])
                ->make(true);
        }
        
        return view("tiket.close");
    }

    public function showProgressTicket(Request $request)
    {
        $data = Ticket::with(["category", "owner"])->select("created_at", "no_ticket", "owner_id", "title", "status", "description", "category_ticket_id")->where("status", "progress")->get();
        // dd($data);
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn("Jenis Pengaduan", function (Ticket $ticket) {
                    $cat = $ticket->category->category;
                    $span = '';
                    if ($cat == "Request ink/print-head") {
                        $span = '<span class="badge badge-primary">' . strtoupper($cat) . '</span>';
                    } else {
                        $span = '<span class="badge badge-secondary">' . strtoupper($cat) . '</span>';
                    }
                    return $span;
                })
                ->addColumn("pelapor", function (Ticket $ticket) {
                    return $ticket->owner;
                })
                ->addColumn("permasalahan", function (Ticket $ticket) {
                    if (strlen($ticket->description) > 50) {
                        $str = substr($ticket->description, 0, 7) . '...';
                        return $str;
                    }
                    return $ticket->description;
                })
                ->addColumn("luarbiasa", function (Ticket $ticket) {
                    $status = $ticket->status;
                    $span = '';
                    if ($status == "open") {
                        $span = '<span class="badge badge-success">' .strtoupper($status)  . '</span>';
                    } else if ($status == "progress") {
                        $span = '<span class="badge badge-warning">' . strtoupper($status) . '</span>';
                        
                    }else {
                        $span = '<span class="badge badge-danger">' . strtoupper($status) . '</span>';
                        
                    }
                    return $span;
                })->escapeColumns([])
                ->addColumn("Tanggal Pengaduan", function (Ticket $ticket) {
                    return $ticket->created_at->format('d/m/y h:m:s');
                })
                ->addColumn('action', function ($row) {
                    // $btn = '<a href="javascript:void(0)" class="edit btn btn-light"><i class="fa-regular fa-comments"></i></a>';
                    return '<a href="'. route("detail-ticket", [$row->no_ticket]). '" class="edit btn btn-light"><i class="fa-regular fa-comments"></i></a>';
                    // return $btn;
                })
                ->rawColumns(['action', "Jenis Pengaduan", "created_at"])
                ->make(true);
        }
        
        return view("tiket.progress");
    }

    public function showOpenTicket(Request $request)
    {
        $data = Ticket::with(["category", "owner"])->select("created_at", "no_ticket", "owner_id", "title", "status", "description", "category_ticket_id")->where("status", "open")->get();
        // dd($data);
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn("Jenis Pengaduan", function (Ticket $ticket) {
                    $cat = $ticket->category->category;
                    $span = '';
                    if ($cat == "Request ink/print-head") {
                        $span = '<span class="badge badge-primary">' . strtoupper($cat) . '</span>';
                    } else {
                        $span = '<span class="badge badge-secondary">' . strtoupper($cat) . '</span>';
                    }
                    return $span;
                })
                ->addColumn("pelapor", function (Ticket $ticket) {
                    return $ticket->owner;
                })
                ->addColumn("permasalahan", function (Ticket $ticket) {
                    if (strlen($ticket->description) > 50) {
                        $str = substr($ticket->description, 0, 7) . '...';
                        return $str;
                    }
                    return $ticket->description;
                })
                ->addColumn("luarbiasa", function (Ticket $ticket) {
                    $status = $ticket->status;
                    $span = '';
                    if ($status == "open") {
                        $span = '<span class="badge badge-success">' .strtoupper($status)  . '</span>';
                    } else if ($status == "progress") {
                        $span = '<span class="badge badge-warning">' . strtoupper($status) . '</span>';
                        
                    }else {
                        $span = '<span class="badge badge-danger">' . strtoupper($status) . '</span>';
                        
                    }
                    return $span;
                })->escapeColumns([])
                ->addColumn("Tanggal Pengaduan", function (Ticket $ticket) {
                    return $ticket->created_at->format('d/m/y h:m:s');
                })
                ->addColumn('action', function ($row) {
                    // $btn = '<a href="javascript:void(0)" class="edit btn btn-light"><i class="fa-regular fa-comments"></i></a>';
                    return '<a href="'. route("detail-ticket", [$row->no_ticket]). '" class="edit btn btn-light"><i class="fa-regular fa-comments"></i></a>';
                    // return $btn;
                })
                ->rawColumns(['action', "Jenis Pengaduan", "created_at"])
                ->make(true);
        }
        
        return view("tiket.open");
    }


    public function showAllTicket(Request $request)
    {
        $data = Ticket::with(["category", "owner"])->select("created_at", "no_ticket", "owner_id", "title", "status", "description", "category_ticket_id")->get();
        // dd($data);
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn("Jenis Pengaduan", function (Ticket $ticket) {
                    $cat = $ticket->category->category;
                    $span = '';
                    if ($cat == "Request ink/print-head") {
                        $span = '<span class="badge badge-primary">' . strtoupper($cat) . '</span>';
                    } else {
                        $span = '<span class="badge badge-secondary">' . strtoupper($cat) . '</span>';
                    }
                    return $span;
                })
                ->addColumn("pelapor", function (Ticket $ticket) {
                    return $ticket->owner;
                })
                ->addColumn("permasalahan", function (Ticket $ticket) {
                    if (strlen($ticket->description) > 50) {
                        $str = substr($ticket->description, 0, 7) . '...';
                        return $str;
                    }
                    return $ticket->description;
                })
                ->addColumn("luarbiasa", function (Ticket $ticket) {
                    $status = $ticket->status;
                    $span = '';
                    if ($status == "open") {
                        $span = '<span class="badge badge-success">' .strtoupper($status)  . '</span>';
                    } else if ($status == "progress") {
                        $span = '<span class="badge badge-warning">' . strtoupper($status) . '</span>';
                        
                    }else {
                        $span = '<span class="badge badge-danger">' . strtoupper($status) . '</span>';
                        
                    }
                    return $span;
                })->escapeColumns([])
                ->addColumn("Tanggal Pengaduan", function (Ticket $ticket) {
                    return $ticket->created_at->format('d/m/y h:m:s');
                })
                ->addColumn('action', function ($row) {
                    // $btn = '<a href="javascript:void(0)" class="edit btn btn-light"><i class="fa-regular fa-comments"></i></a>';
                    return '<a href="'. route("detail-ticket", [$row->no_ticket]). '" class="edit btn btn-light"><i class="fa-regular fa-comments"></i></a>';
                    // return $btn;
                })
                ->rawColumns(['action', "Jenis Pengaduan", "created_at"])
                ->make(true);
        }
        return view("tiket.show");
    }
    //
    public function index(Request $request)
    {
        $status = $request->query("status");
        if ($request->query("status")) {
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
    public function getOne($id)
    {
        $ticket = Ticket::with(["category", "severity", "assign_to", "owner", "comments"])->find($id);
        return response()->json(
            $ticket
        );
    }

    public function buatTiket() {
        
        $category = CategoryTicket::all();
        $severity = Severity::all();
        return view("tiket.create", compact("category", "severity"));
    }

    public function simpanTiket(Request $request) {
        $ticket = new Ticket();
        $ticket->owner_id = $request->user_id;
        $ticket->no_ticket = "tiket" . $ticket->id;
        // $ticket->assign_to = $request->assign_to;
        $ticket->category_ticket_id = $request->category_ticket_id;
        $ticket->severity_id = $request->severity_id;
        $ticket->title = $request->title;
        $ticket->description = $request->description;
        $ticket->status = "open";
        $result = date('d.m.Y', strtotime('+7 day', time()));
        $ticket->due_datetime = $result;
        // $ticket->close_datetime = $result;
        $ticket->save();
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

                    $name = $mediaFiles->getClientOriginalName();
                    $path = $mediaFiles->store('public/images');
                    $filepath = str_replace("public","storage",$path);
                    // $filePath = $request->file('image')->storeAs('uploads', $name);


                    //store image file into directory and db
                    $save = new File();
                    $save->filename = $name;
                    $save->path = $filepath ;
                    $ticket->files()->save($save);
                }
            }
        }
        return redirect(route("list-open-ticket"));
    }

    public function store(Request $request)
    {
        $ticket = new Ticket();
        $ticket->owner = $request->user_id;
        $ticket->no_ticket = "tiket" . $ticket->id;
        // $ticket->assign_to = $request->assign_to;
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

    public function take($no_ticket, Request $request)
    {
        $ticket = Ticket::with(["category", "comments"])->where("no_ticket", $no_ticket)->first();
        $ticket->status = "progress";
        $ticket->save();
        $comment = new Comment();
        $comment->user_id = $request->user_id;
        $comment->no_ticket = $ticket->no_ticket;
        $comment->body = "Tiket sedang di proses";
        $comment->save();
        return redirect()->back();
        // $ticket = Ticket::with(["category", "comments"])->where("no_ticket", $no_ticket)->first();
        // return response()->json(
        //     $ticket
        // );
    }

    public function close($id, Request $request)
    {
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

    public function attachfile()
    {
        $ticket = Ticket::find(1);
        dd($ticket->files);
    }

    public function storeFile(Request $request)
    {
        $ticket = Ticket::find(1);
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

                    $name = $mediaFiles->getClientOriginalName();
                    $path = $mediaFiles->store('public/images');
                    $filepath = str_replace("public","storage",$path);
                    // $filePath = $request->file('image')->storeAs('uploads', $name);


                    //store image file into directory and db
                    $save = new File();
                    $save->filename = $name;
                    $save->path = $filepath ;
                    $ticket->files()->save($save);
                }
            } else {
                return response()->json(['invalid_file_format'], 422);
            }
        }
        return response()->json($ticket->files, 200);
    }

    public function updateTicket( Request $request) {
        $ticket = Ticket::where("no_ticket",$request->id)->first();
        // dd($ticket);
        if ($request->ajax()) {
            $user_id = rand(1,2);
            $comment = new Comment();
            $comment->user_id = $user_id;
            $comment->no_ticket = $ticket->no_ticket;
            $comment->body = $request->message;
            $comment->save();
            $ticket->status = $request->status;
            $ticket->save();
            
            if($request->status == "close") {
                $ticket->close_datetime = Carbon::now();
                $ticket->save();
                $comment = new Comment();
                $comment->no_ticket = $ticket->no_ticket;
                $comment->user_id = $user_id;
                $comment->body = "Tiket sedang sudah di close / sudah selesai";
                $comment->save();
            }
            return response()->json($request["update_data"], 200);
        }
    }
}
