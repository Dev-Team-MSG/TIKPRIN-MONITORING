<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;
use App\Models\User;
use App\DataTables\UserDataTable;


use function App\Helpers\cek_akses_user;
use function App\Helpers\main_menu;
use function App\Helpers\sub_menu;

class UserController extends Controller
{
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

    //tampilkan data
    public function index(UserDataTable $dataTable)
    {

        return $dataTable->render('users');
    }

    //Method Validation

    private function _validation(Request $request)
    {
        $validation = \Validator::make(
            $request->all(),
            [
                "name" => "required|min:5|max:100",
                "username" => "required|min:5|max:20|unique:users",
                "email" => "required|email|unique:users",
                "phone" => "required|digits_between:10,12|unique:users",
                "password" => "required",
                "password_confirmation" => "required|same:password",
                "roles" => "required",
                "image" => "mimes:jpg,png,jpeg"

            ],
            [
                //message nama
                'name.required' => 'Nama harus diisi',
                'name.max' => 'Maximal 100 Digit',
                'name.min' => 'Minimal 5 Digit',
                // 'name.unique' => 'Minimal 5 Digit',
                //message username
                'username.required' => 'username harus diisi',
                'username.max' => 'Maksimal 20 Digit',
                'username.min' => 'Minimal 5 Digit',
                'username.unique' => 'Username sudah terdaftar, ganti dengan yang lain',
                //message email
                'email.required' => 'Email harus diisi',
                'email.email' => 'Gunakan Format Email yang benar',
                'email.unique' => 'Email sudah terdaftar, ganti dengan yang lain',
                //message password
                'phone.required' => 'Telephone Harus diisi',
                'phone.digits_between' => 'Nomer Telephone harus diantara 10 sampai 12 Digit',
                'phone.unique' => 'Nomer Telephone sudah terdaftar, gunakan nomer yang lain',
                //message password
                'password.required' => 'password harus diisi',
                'password_confirmation.required' => 'password harus diisi',
                'password_confirmation.same' => 'Konfirmasi Password tidak cocok',
                //message roles
                'roles.required' => 'Roles Wajib dipilih',
                //message image
                'image.mimes' => 'Jenis File harus JPG atau PNG'

            ]
        )->validate();
    }

    //Method Import Excel

    public function import(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        $file = $request->file('file');

        // membuat nama file unik
        $nama_file = $file->hashName();

        //temporary file
        $path = $file->storeAs('public/excel/', $nama_file);

        // import data
        $import = Excel::import(new UsersImport(), storage_path('app/public/excel/' . $nama_file));

        //remove from server
        Storage::delete($path);

        if ($import) {
            //redirect

            return redirect()->route('users')->with(['message' => 'Data User Berhasil Diimport!']);
        } else {
            //redirect
            return redirect()->route('users')->with(['message' => 'Data User Gagal Diimport!']);
        }
    }


    //action untuk menampilkan form tambah data 
    public function tambah()
    {
        if ($this->cek->tambah != 1) {
            abort(403);
        }

        $kanims = \App\Models\Kanim::get();
        $roles = Role::get();
        return view('users-tambah', compact("kanims", "roles"));
    }

    //method untuk simpan data 

    public function simpan(Request $request)
    {

        $this->_validation($request);
        
        $new_user = new \App\Models\User;
        $new_user->name = $request->get('name');
        $new_user->username = $request->get('username');
        $new_user->email = $request->get('email');
        $new_user->phone = $request->get('phone');
        $new_user->password = \Hash::make($request->get('password'));
        $new_user->syncRoles($request->get('roles'));
        // dd($request);
        // $new_user->roles = $request->get('roles');
        if ($request->file('image')) {
            $file = $request->file('image')->store('images', 'public');
            $new_user->image = $file;
        }
        $new_user->kanim_id = $request->get('kanim_id');
        $new_user->save();
        return redirect()->route('users')->with('message', 'User Berhasil Dibuat');
    }

    //method untuk edit data 
    public function edit($id)
    {
        if ($this->cek->edit != 1) {
            abort(403);
        }
        $roles = Role::get();
        $user = \App\Models\User::findOrFail($id);
        $kanims = \App\Models\Kanim::get();

        return view('users-edit', compact("user", "kanims", "roles"));
    }

    //method untuk hapus data

    public function hapus($id)
    {

        if ($this->cek->hapus != 1) {
            abort(403);
        }
        try {
            //code...
            DB::beginTransaction();
            $user = \App\Models\User::findOrFail($id);
            if (count($user->roles) > 0) {
                $user->removeRole($user->roles[0]->name);
            }
            $user->delete();
            DB::commit();
            return redirect()->back()->with('message', 'Data Berhasil dihapus');
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
            //throw $th;
            return redirect()->back()->with("error", "Data user tidak bisa dihapus, karena memiliki transaksi");
        }
        // DB::table('users')->where('id',$id)->delete();

    }

    //method untuk update data

    public function update(Request $request, $id)
    {
        if ($this->cek->edit != 1) {
            abort(403);
        }
        //$this->_validation($request);
        $validation = \Validator::make(
            $request->all(),
            [
                "name" => "required|min:5|max:100",
                // "username" => "required|min:5|max:20|",
                // "email" => "required|email|unique:users",
                "phone" => "required|digits_between:10,12",
                // "password" => "required",
                // "password_confirmation" => "required|same:password",
                "roles" => "required",
                "image" => "mimes:jpg,png,jpeg"

            ],
            [
                //message nama
                'name.required' => 'Nama harus diisi',
                'name.max' => 'Maximal 100 Digit',
                'name.min' => 'Minimal 5 Digit',

                //message password
                'phone.required' => 'Telephone Harus diisi',
                'phone.digits_between' => 'Nomer Telephone harus diantara 10 sampai 12 Digit',

                //message password
                'roles.required' => 'Roles Wajib dipilih',
                //message image
                'image.mimes' => 'Jenis File harus JPG atau PNG'

            ]
        )->validate();

        $user = \App\Models\User::findOrFail($id);
        $user->name = $request->get('name');
        $user->syncRoles($request->get('roles'));
        $user->phone = $request->get('phone');
        // $user->password = $request->get('password');
        if ($request->file('image')) {
            if ($user->image && file_exists(storage_path('app/public' . $user->image))) {
                \Storage::delete('public/' . $user->image);
            }
            $file = $request->file('image')->store('images', 'public');
            $user->image = $file;
        }
        $user->kanim_id = $request->get('kanim_id');
        $user->save();
        // return 
        return redirect()->route('users', [$id])->with('message', 'Data Berhasil diupdate');
    }

    public function detail($id)
    {
        $user = \App\Models\User::findOrFail($id);

        return view('users-detail', compact("user"));
    }
}
