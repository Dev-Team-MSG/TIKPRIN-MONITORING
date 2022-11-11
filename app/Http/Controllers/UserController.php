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



class UserController extends Controller
{
    //tampilkan data
    public function index(UserDataTable $dataTable)
    {
        // $sort = $request->input('sort', 'asc');
        // if(Auth::user()->roles[0]->name == "engineer"){
        //     $count_open = Ticket::where("status", "open")->where("assign_id", null)->count();
        //     $count_progress = Ticket::where("status", "progress")->where("assign_id", Auth::user()->id)->count();
        //     $count_close = Ticket::where("status", "close")->where("assign_id", Auth::user()->id)->count();

        // }else if(Auth::user()->roles[0]->name == "kanim"){
        //     $count_open = Ticket::where("status", "open")->where("assign_id", Auth::user()->id)->count();
        //     $count_progress = Ticket::where("status", "progress")->where("assign_id", Auth::user()->id)->count();
        //     $count_close = Ticket::where("status", "close")->where("assign_id", Auth::user()->id)->count();


        // }else {
        //     $count_open = Ticket::where("status", "open")->count();
        //     $count_progress = Ticket::where("status", "progress")->count();
        //     $count_close = Ticket::where("status", "close")->count();
        // }

        return $dataTable->render('users');
        // $users = \App\Models\User::paginate(5);
        // $filterKeyword = $request->get('keyword');
           
        
        // $roles = $request->get('roles');
        // if($roles){
        //     $users = \App\Models\User::role($roles)->paginate(10);
        //     //$users = \App\Models\User::where('role', $roles)->paginate(10);
        //    } else {
        //     $users = \App\Models\User::orderBy('created_at', 'desc')->paginate(10);
        //    }
        //    if($filterKeyword){
        //     if($roles){
        //     $users = \App\Models\User::where('email', 'LIKE', "%$filterKeyword%")
        //         ->where('roles', $roles)
        //         ->paginate(5);
        //     } else {
        //     $users = \App\Models\User::where('email', 'LIKE', "%$filterKeyword%")
        //         ->paginate(5);
        //     }
        //    }
           
        // return view('users', compact("users", "count_open", "count_progress", "count_close"));
    }

    //Method Validation

    private function _validation(Request $request)
    {
        $validation = \Validator::make($request->all(),[
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
        $kanims = \App\Models\Kanim::get();
        $roles = Role::get();
        return view('users-tambah', compact("kanims", "roles", "count_open", "count_progress", "count_close"));
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
        $user = \App\Models\User::findOrFail($id);
        $kanims = \App\Models\Kanim::get();
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
        $roles = Role::get();
        return view('users-edit', compact("user", "kanims", "count_open", "count_progress", "count_close"));
    }

    //method untuk hapus data

    public function hapus($id)
    {
        // DB::table('users')->where('id',$id)->delete();
        $user = \App\Models\User::findOrFail($id);
        $user->delete();
        return redirect()->back()->with('message', 'Data Berhasil dihapus');
    }

    //method untuk update data

    public function update(Request $request, $id)
    {
        $validation = \Validator::make($request->all(),[
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
        return view('users-detail',compact("user", "count_open", "count_progress", "count_close"));
    }
}
