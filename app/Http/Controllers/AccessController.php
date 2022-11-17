<?php

namespace App\Http\Controllers;

use App\Models\Access;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Symfony\Component\CssSelector\Node\FunctionNode;

use function App\Helpers\cek_akses_user;
use function App\Helpers\list_menu;
use function App\Helpers\main_menu;
use function App\Helpers\sub_menu;

class AccessController extends Controller
{
    // protected $main_menu;
    // protected $sub_menu;
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

        $role = Role::get();
        return view("akses.index", compact("role"));
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    public function list_akses($role_id)
    {
        return DB::table("accesses")->where("role_id", "=", $role_id)->get();
    }

    public function list_menu($id)
    {
        $insertData = array();
        //
        // $access = DB::table("accesses")->find($id);
        $menu = DB::table("menus")->where("aktif", 1)->get();
        $ada = false;
        foreach ($menu as $mn) {
            foreach ($this->list_akses($id) as $la) {
                if ($mn->kode_menu == $la->kode_menu) {
                    $ada = true;
                }
            }
            if (!$ada) {
                $insertData[] = [
                    "kode_menu" => $mn->kode_menu,
                    "role_id" => $id,
                    "akses" => 0,
                    "tambah" => 0,
                    "edit" => 0,
                    "hapus" => 0,
                    "created_by" => Auth::user()->name,
                    "updated_by" => Auth::user()->name,
                    "created_at" => date("Y-m-d H:i:s"),
                    "updated_at" => date("Y-m-d H:i:s"),
                ];
            }
        }
        if (isset($insertData)) {
             DB::table("accesses")->insert($insertData);
        }


        $access = DB::table("menus")
            ->join("accesses", "accesses.kode_menu", "=", "menus.kode_menu", "left")
            ->where("accesses.role_id", $id)
            ->get();
        //    dd($access);
        return $access;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($role_id)
    {
        //
        // if($this->cek->edit != 1) {
        //     abort(403);
        // }
        $list_menu = $this->list_menu($role_id);
        $role = Role::findById($role_id);
        return view("akses.edit", compact("list_menu", "role"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $role_id)
    {
        //
        // if($this->cek->edit != 1) {
        //     abort(403);
        // }
        $access = Access::where("role_id", "=", $role_id)->get();
        $list = $this->list_akses($role_id);
        $no = 1;
        // dd($request->input("akses".$no));
        // dd($list); 
        foreach ($list as $a) {
            # code...
            $data = [
                "akses" => $request->input("akses" . $no) == null ? 0 : 1,
                "tambah" => $request->input("tambah" . $no) == null ? 0 : 1,
                "edit" => $request->input("edit" . $no) == null ? 0 : 1,
                "hapus" => $request->input("hapus" . $no) == null ? 0 : 1
            ];
            $no++;
            // $access[$no-1]->kode_menu = $data["kode_menu"];
            // dd($access);
            DB::table("accesses")
                ->where("kode_menu", "=", $a->kode_menu)
                ->where("role_id", "=", $role_id)
                ->update($data);
        }

        return redirect(route("permission.index"))->with("message", "Data Berhasil Diubah");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($this->cek->hapus != 1) {
            abort(403);
        }
        try {
            //code...
            DB::beginTransaction();
            DB::table("roles")->where("id", $id)->delete();
            DB::commit();
            return redirect()->back()->with("message", "Berhasil menghapus data");
        } catch (\Throwable $th) {
            DB::rollBack();
            //throw $th;
            return redirect()->back()->with("error", "Role tidak bisa dihapus karena sedang telah di assign ke user atau sudah memiliki permission");
        }
        //

    }

    function destroyAccess(Request $request , $id) {
        try {
            DB::beginTransaction();
            DB::table("accesses")->where("role_id", $id)->delete();
            DB::commit();
            return redirect(route("permission.index"))->with("message", "Access berhasil dihapus");
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return redirect()->back()->with("error", $th);
        }
    }
}
