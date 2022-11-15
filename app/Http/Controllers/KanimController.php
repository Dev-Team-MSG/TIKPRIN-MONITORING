<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\kanimsImport;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;
use Illuminate\Support\Facades\Validator;
use App\DataTables\KanimDataTable;
use Spatie\Permission\Models\Kanim;
// use Yajra\Datatables\Datatables;

class KanimController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(KanimDataTable $dataTable)
    {
        // dd($data);    
        return $dataTable->render('kanims.index');

        // $kanims = \App\Models\Kanim::paginate(10);
        // $filterKeyword = $request->get('keyword');
        // if($filterKeyword){
        //     $kanims = \App\Models\Kanim::where('name', 'LIKE', "%$filterKeyword%")->paginate(10);
        // }
        // return view('kanims.index', ['kanims' => $kanims]);



    }

    public function import(Request $request)
    {
        Validator::make($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        $file = $request->file('file');

        // membuat nama file unik
        $nama_file = $file->hashName();

        //temporary file
        $path = $file->storeAs('public/excel/', $nama_file);

        // import data

        $import = Excel::import(new kanimsImport(), storage_path('app/public/excel/' . $nama_file));

        //remove from server
        Storage::delete($path);

        if ($import) {
            //redirect
            return redirect()->route('kanims.index')->with(['message' => 'Data Berhasil Diimport!']);
        } else {
            //redirect
            return redirect()->route('kanims.index')->with(['message' => 'Data Gagal Diimport!']);

        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('kanims.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $validation = \Validator::make($request->all(),[
            "name" => "required|min:5|max:35",
            "network" => "required|min:5|max:15|unique:kanims|ip"
            
        ],
        [
            //message nama
            'name.required' => 'Nama Kanim harus diisi',
            'name.max' => 'Maximal 35 Digit',
            'name.min' => 'Minimal 5 Digit',
            //message network
            'network.required' => 'Network Address harus diisi',
            'network.max' => 'Maksimal 15 Digit',
            'network.min' => 'Minimal 5 Digit',
            'network.unique' => 'Network Address sudah terdaftar, ganti dengan yang lain',
            'network.ip' => 'Masukkan Network Address yang Valid'
             
        ]
        )->validate();

        $new_kanim = new \App\Models\Kanim;
        $new_kanim->name = $request->get('name');
        $new_kanim->network = $request->get('network');
        // $new_kanim->created_by = \Auth::user()->id;
        $new_kanim->save();
        return redirect()->route('kanims.index')->with('message', 'kanim Berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $kanim = \App\Models\kanim::findOrFail($id);
        
        return view('kanims.show', ['kanim' => $kanim]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kanim_to_edit = \App\Models\Kanim::findOrFail($id);
        return view('kanims.edit', ['kanim' => $kanim_to_edit]);
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
        $validation = \Validator::make($request->all(),[
            "name" => "required|min:5|max:35",
            "network" => "required|min:7|max:15|ip"
            
        ],
        [
            //message nama
            'name.required' => 'Nama Kanim harus diisi',
            'name.max' => 'Maximal 35 Digit',
            'name.min' => 'Minimal 5 Digit',
            
            //message username
            'network.required' => 'Network Address harus diisi',
            'network.max' => 'Maksimal 15 Digit',
            'network.min' => 'Minimal 5 Digit',
            'network.ip' => 'Masukkan IP Address yang Valid'
            
             
        ]
        )->validate();

        $name = $request->get('name');
        $network = $request->get('network');
        $kanim = \App\Models\Kanim::findOrFail($id);

        $kanim->name = $name;
        $kanim->network = $network;
        $kanim->save();

        return redirect()->route('kanims.index', [$id])->with('message', 'Data Kanim Berhasil diUpdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kanim = \App\Models\Kanim::findOrFail($id);
        $kanim->delete();
        return redirect()->route('kanims.index')->with('message', 'Kanim Berhasil diHapus');
    }
}
