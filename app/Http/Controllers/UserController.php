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
                "email" => "required|email|max:255|regex:/(.*)@gmail\.com/i|unique:users",
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
                'email.email' => 'Gunakan Format Email yang benar dengan domain gmail.com',
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

    // public function import(Request $request)
    // {
    //     $this->validate($request, [
    //         'file' => 'required|mimes:csv,xls,xlsx'
    //     ]);

    //     $file = $request->file('file');

    //     $parsed_array = Excel::toArray([], $file);
    //     $imported_data = array_splice($parsed_array[0], 1);
    //     if (empty($imported_data)) {
    //         toastr()->error('File Excel tidak boleh kosong.');
    //         return redirect()->back();
    //     }

    //     $formated_data = [];
    //     $user_array = [];
    //     $is_valid = true;
    //     $error_msg = '';
    //     DB::beginTransaction();
        
    //     try {
        
    //     foreach ($imported_data as $key => $value) {

    //         $user_array['name']=$value[1];
    //         //Row email
    //         $user_email = trim($value[2]);
    //         if(!empty($user_email)){
    //             $cekemail = User::where('name', $user_email)->first();
    //             if (empty($cekemail)) {
    //                 $user_array['name'] = $user_email;
    //             }else{
    //                 $is_valid =  false;
    //                 $error_msg = "Nama User [".$user_email."] sudah ada. Mohon Gunakan Lain.";
    //                 break;
    //             }
    //         }else {
    //             $is_valid = false;
    //             $error_msg = "Nama Kosong, check Kembali Excel Nama tidak boleh kosong";
    //             break;
    //         }

    //         //Row username 
    //         $user_username = trim($value[2]);
    //         if(!empty($user_username)){
    //             $cekmac = Printer::where('mac_address', $printer_mac)->first();
    //             if (empty($cekmac)) {
    //                 $printer_array['mac_address'] = $printer_mac;
    //             }else{
    //                 $is_valid =  false;
    //                 $error_msg = "Printer Mac Address [".$printer_mac."] sudah ada. Mohon Import Mac Address Lain.";
    //                 break;
    //             }
    //         }else {
    //             $is_valid = false;
    //             $error_msg = "Mac Address Kosong, check Kembali Mac Address tidak boleh kosong";
    //             break;
    //         }
    //         $printer_array['tahun_pengadaan']=$value[3];
    //         $printer_array['created_by'] = auth()->user()->id;
    //         $printer_array['created_at'] = date('Y-m-d H:i:s');
    //         $printer_array['updated_at'] = date('Y-m-d H:i:s');
    //         //Assign to formated array
    //         $formated_data[]=$printer_array;
    //     }
    //     //dd($formated_data);
    //     if (!empty($formated_data)) {
    //         Printer::insert($formated_data);
    //     }
    //     DB::commit();
    //     if ($is_valid) {
    //         //redirect
    //         return redirect()->route('printers.index')->with(['message' => 'Data Berhasil Diimport!']);
    //     } else {
    //         //redirect
    //         return redirect()->route('printers.index')->with(['error' => $error_msg]);

    //     }
    // }catch (\Exception $e){
    //     DB::rollBack();
    //     return redirect()->route('printers.index')->with(['error' => $e->getMessage()]);
    // }
    // }


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
            $ada = Ticket::where("assign_id", "=", $id)->get();
            if($ada) {
                return redirect()->back()->with("error", "Terdapat tiket yang ditugaskan ke user ini");
            }
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
