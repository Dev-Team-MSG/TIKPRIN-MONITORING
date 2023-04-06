<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Kanim;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;
use Illuminate\Support\Facades\Validator;
use App\DataTables\KanimDataTable;
//use Spatie\Permission\Models\Kanim;
use App\Exceptions\Handler;
use Illuminate\Database\QueryException;

use function App\Helpers\cek_akses_user;

// use Yajra\Datatables\Datatables;

class KanimController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(KanimDataTable $dataTable)
    {
        // dd($data);    
        return $dataTable->render('kanims.index');
    }

    public function import(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        $file = $request->file('file');

        $parsed_array = Excel::toArray([], $file);
        $imported_data = array_splice($parsed_array[0], 1);
        if (empty($imported_data)) {
            toastr()->error('File Excel tidak boleh kosong.');
            return redirect()->back();
        }

        $formated_data = [];
        $kanim_array = [];
        $is_valid = true;
        $error_msg = '';
        DB::beginTransaction();
        
        try {
        
        foreach ($imported_data as $key => $value) {
            //Row name
            $kanim_name = trim($value[1]);
            if(!empty($kanim_name)){
                $cekname = Kanim::where('name', $kanim_name)->first();
                if (empty($cekserial)) {
                    $kanim_array['name'] = $kanim_name;
                }else{
                    $is_valid =  false;
                    $error_msg = "Nama Kanim [".$kanim_name."] sudah ada. Mohon Import Dengan nama Lain.";
                    break;
                }
            }else {
                $is_valid = false;
                $error_msg = "Nama Kanim Kosong, check Kembali Nama kanim tidak boleh kosong";
                break;
            }

            //Row Alamat
            $kanim_array['alamat']=$value[2];
            //Row alamat
            $kanim_telp = trim($value[3]);
            if(!empty($kanim_telp)){
                $cektelp = Kanim::where('telp', $kanim_telp)->first();
                if (empty($cektelp)) {
                    $kanim_array['telp'] = $kanim_telp;
                }else{
                    $is_valid =  false;
                    $error_msg = "Nomer Telp [".$kanim_telp."] sudah digunakan. Mohon Import Nomor Lain.";
                    break;
                }
            }else {
                $is_valid = false;
                $error_msg = "No Telp Kanim Kosong, check Kembali No Telp tidak boleh kosong";
                break;
            }
            $kanim_array['latitude']=$value[4];
            $kanim_array['longitude']=$value[5];
            // $kanim_array['created_by'] = auth()->user()->id;
            $kanim_array['created_at'] = date('Y-m-d H:i:s');
            $kanim_array['updated_at'] = date('Y-m-d H:i:s');
            //Assign to formated array
            $formated_data[]=$kanim_array;
        }
        //dd($formated_data);
        if (!empty($formated_data)) {
            Kanim::insert($formated_data);
        }
        DB::commit();
        if ($is_valid) {
            //redirect
            return redirect()->route('kanims.index')->with(['message' => 'Data Berhasil Diimport!']);
        } else {
            //redirect
            return redirect()->route('kanims.index')->with(['error' => $error_msg]);

        }
    }catch (\Exception $e){
        DB::rollBack();
        return redirect()->route('kanims.index')->with(['error' => $e->getMessage()]);
    }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if($this->cek->tambah != 1) {
            abort(403);
        }
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
        if($this->cek->tambah != 1) {
            abort(403);
        }
        $validation = \Validator::make($request->all(),[
            "name" => "required|min:5|max:35",
            "alamat" => "required|min:15",
            "telp" => "required|digits_between:10,12|unique:kanims",
            

            
        ],
        [
            //message nama
            'name.required' => 'Nama Kanim harus diisi',
            'name.max' => 'Maximal 35 Digit',
            'name.min' => 'Minimal 5 Digit',
            //message network
            'alamat.required' => 'Alamat Kanim harus diisi',
            'alamat.min' => 'Alamat minimal 15 Digit',
            'telp.required' => 'No Telp Harus diisi',
            'telp.digits_between' => 'No Telp Antara 10 sampai 12 Digit',
            'telp.unique' => 'No Telp Telah digunakan di Kanim lain, Silahkan Gunakan Nomer telp Lain'
             
        ]
        )->validate();

        $new_kanim = new \App\Models\Kanim;
        $new_kanim->name = $request->get('name');
        $new_kanim->alamat = $request->get('alamat');
        $new_kanim->telp = $request->get('telp');
        $new_kanim->latitude = $request->get('latitude');
        $new_kanim->longitude = $request->get('longitude');
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
        if($this->cek->akses != 1) {
            abort(403);
        }

        $kanim = \App\Models\kanim::with('printer')->findOrFail($id);
        $printer = \App\Models\printer::where('kanim_id', $kanim->id)->paginate(10);
        // dd($kanim);
        // return view('kanims.show', ['kanim' => $kanim]);
        return view('kanims.show', compact('kanim','printer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if($this->cek->edit != 1) {
            abort(403);
        }
        

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
        if($this->cek->edit != 1) {
            abort(403);
        }
        $validation = \Validator::make($request->all(),[
            "name" => "required|min:5|max:35",
            "alamat" => "required|min:15",
            "telp" => "required|digits_between:10,12"
            

            
        ],
        [
            //message nama
            'name.required' => 'Nama Kanim harus diisi',
            'name.max' => 'Maximal 35 Digit',
            'name.min' => 'Minimal 5 Digit',
            //message network
            'alamat.required' => 'Alamat Kanim harus diisi',
            'alamat.min' => 'Alamat minimal 15 Digit',
            'telp.required' => 'No Telp Harus diisi',
            'telp.digits_between' => 'No Telp Antara 10 sampai 12 Digit',
            // 'telp.unique' => 'No Telp Telah digunakan di Kanim lain, Silahkan Gunakan Nomer telp Lain'
             
        ]
        )->validate();

        $name = $request->get('name');
        $alamat = $request->get('alamat');
        $telp = $request->get('telp');
        $latitude = $request->get('latitude');
        $longitude = $request->get('longitude');
        $kanim = \App\Models\Kanim::findOrFail($id);

        $kanim->name = $name;
        $kanim->alamat = $alamat;
        $kanim->telp = $telp;
        $kanim->latitude = $latitude;
        $kanim->longitude = $longitude;
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
        if($this->cek->hapus != 1) {
            // abort(403);
            return redirect()->back()->with("error", "Anda tidak memiliki akses untuk menghapus data");
            // return response()->json("error");
        }
        $kanim = \App\Models\Kanim::findOrFail($id);

        try {
            $kanim->delete();
            return redirect()->route('kanims.index')->with('message', 'Kanim Berhasil diHapus');
        } catch (\Illuminate\Database\QueryException $ex) {

            if($ex->getCode() === '23000') {
            return redirect()->route('kanims.index')->with('error', 'Kanim tidak dapat dihapus karena terhubung dengan Salah satu Printer, Silahkan Check di Relokasi Printer');
        }

        // $kanim->delete();
        // return redirect()->route('kanims.index')->with('message', 'Kanim Berhasil diHapus');
    }
}
}