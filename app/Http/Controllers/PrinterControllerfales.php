<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    //tampilkan data
    public function index(Request $request)
    {
        $users = \App\Models\User::paginate(5);
        $filterKeyword = $request->get('keyword');
        if ($filterKeyword) {
            $users = \App\Models\User::where('email', 'LIKE', "%$filterKeyword%")->paginate(5);
        }
        // $users = DB::table('users')->paginate(5);
        return view('users', ['users' => $users]);
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
            return redirect()->route('users')->with(['success' => 'Data Berhasil Diimport!']);
        } else {
            //redirect
            return redirect()->route('users')->with(['error' => 'Data Gagal Diimport!']);
        }
    }
    //Method Validation

    private function _validation(Request $request)
    {
        $validation = $request->validate(
            [
                'name' => 'required|max:35|min:3',
                'email' => 'required|email|max:255|unique:users',
                'phone' => 'required|numeric',
                'password' => 'required',
                'roles' => 'required'
            ],
            [
                //message kode barang
                // 'kode_barang.required' => 'Tidak boleh kosong',
                // 'kode_barang.max' => 'Maximal 10 Digit',
                // 'kode_barang.min' => 'Minimal 3 Digit',

                // //message nama barang
                // 'nama_barang.required' => 'Tidak boleh kosong',
                // 'nama_barang.max' => 'Maximal 100 Digit',
                // 'nama_barang.min' => 'Minimal 3 Digit'
            ]
        );
    }

    //action untuk menampilkan form tambah data 
    public function tambah()
    {
        $kanims = \App\Models\Kanim::get();
        return view('users-tambah', ['kanims' => $kanims]);
    }

    //method untuk simpan data 

    public function simpan(Request $request)
    {
        $new_user = new \App\Models\User;
        $new_user->name = $request->get('name');
        $new_user->username = $request->get('username');
        $new_user->email = $request->get('email');
        $new_user->phone = $request->get('phone');
        $new_user->password = \Hash::make($request->get('password'));
        $new_user->roles = $request->get('roles');
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
        return view('users-edit', ['user' => $user], ['kanims' => $kanims]);
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
        //$this->_validation($request);

        $user = \App\Models\User::findOrFail($id);
        $user->name = $request->get('name');
        $user->roles = $request->get('roles');
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
        return view('users-detail', ['user' => $user]);
    }
}
