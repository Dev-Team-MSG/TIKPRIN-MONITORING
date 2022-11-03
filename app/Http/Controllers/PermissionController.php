<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;

class PermissionController extends Controller
{
    public function __construct()
    {
        // $this->middleware("can:access permission")->only("index");
        // $this->middleware("can:create permission")->only(["create", "store"]);
        // $this->middleware("can:edit permission")->only(["take", "update"]);
        // $this->middleware("can:delete permission")->only("destroy");
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if(Auth::user()->roles[0]->name == "engineer"){
            $count_open = Ticket::where("status", "open")->where("assign_id", null)->count();
            $count_progress = Ticket::where("status", "progress")->where("assign_id", Auth::user()->id)->count();
            $count_close = Ticket::where("status", "close")->where("assign_id", Auth::user()->id)->count();

        }else if(Auth::user()->roles[0]->name == "kanim"){
            $count_open = Ticket::where("status", "open")->where("assign_id", Auth::user()->id)->count();
            $count_progress = Ticket::where("status", "progress")->where("assign_id", Auth::user()->id)->count();
            $count_close = Ticket::where("status", "close")->where("assign_id", Auth::user()->id)->count();


        }else {
            $count_open = Ticket::where("status", "open")->count();
            $count_progress = Ticket::where("status", "progress")->count();
            $count_close = Ticket::where("status", "close")->count();
        }
        $permission = Permission::latest()->get();
        return view("permission.index", compact("permission", "count_open", "count_progress", "count_close"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name'=>'required',
        ]);
        $permission = Permission::create(['name'=>$request->name]);
        return response()->json($permission);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $permission = Permission::find($id);
        return response()->json($permission);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            "name" => "required"
        ]);
        
        $permission = Permission::find($id);
        $permission->name = $request->name;
        $permission->save();
        return response()->json($permission);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $permission = Permission::find($id);
        $permission->delete();
        return response()->json("Berhasil dihapus");
    }
}
