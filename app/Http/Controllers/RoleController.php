<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function __construct() 
    {
        $this->middleware("can:access role")->only("index");
        $this->middleware("can:create role")->only("store");
        $this->middleware("can:edit role")->only("edit");
        $this->middleware("can:delete role")->only("destroy");
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
        $role = Role::latest()->get();
        $permissions = Permission::with("roles")->get();
        return view("role.index", compact("role", "permissions", "count_open", "count_progress", "count_close"));

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
        $request->validate(['name'=>'required']);

        $role = Role::create(['name'=>$request->name]);
// dd($request->permissions);
        $role->syncPermissions($request->permissions);
        
        return response()->json($role);
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
        $roleDetail = Role::With("permissions")->find($id);
        return response()->json($roleDetail);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permissions = Permission::get();
        $role = Role::find($id);
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
       return view('role.edit',compact("role", "permissions", "count_open", "count_progress", "count_close"));
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
        $role = Role::find($id);
        $role->syncPermissions($request->permissions);
        return redirect(route("roles.index"))->withSuccess('Role updated !!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        //
        $role->delete();
        return redirect()->back()->withSuccess('Role deleted !!!');
    }
}
