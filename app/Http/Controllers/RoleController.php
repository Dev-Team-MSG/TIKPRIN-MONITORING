<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

use function App\Helpers\cek_akses_user;

class RoleController extends Controller
{
    protected $cek;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::check()) {
                $this->cek = cek_akses_user();
            }
            //     // $this->sub_menu = sub_menu();
            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        
        // $role = Role::latest()->get();
        // $permissions = Permission::with("roles")->get();
        // return view("role.index", compact("role", "permissions"));
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
        try {
            if($this->cek->tambah != 1) {
                abort(403);
            }
            //code...
            $request->validate(['role' => 'required']);

            $role = Role::create(['name' => $request->role]);
            return redirect(route("konfigurasi.index"))->with("message", "Data berhasil disimpan");
        } catch (\Throwable $th) {
            //throw $th;
            dd($th);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        // $roleDetail = Role::With("permissions")->find($id);
        // return response()->json($roleDetail);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $permissions = Permission::get();
        // $role = Role::find($id);
        // return view('role.edit', compact("role", "permissions"));
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
        // $role = Role::find($id);
        // $role->syncPermissions($request->permissions);
        // return redirect(route("roles.index"))->withSuccess('Role updated !!!');
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
        // $role->delete();
        // return redirect()->back()->withSuccess('Role deleted !!!');
    }
}
