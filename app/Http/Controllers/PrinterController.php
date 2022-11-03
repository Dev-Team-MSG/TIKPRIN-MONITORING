<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PrintersImport;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;

class PrinterController extends Controller
{
    public function __construct()
    {
        // $this->middleware("can:access printer")->only("index");
        // $this->middleware("can:create printer")->only(["create", "store", "import"]);
        // $this->middleware("can:edit printer")->only(["edit", "update"]);
        // $this->middleware("can:delete printer")->only("destroy");
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
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
        $printers = \App\Models\Printer::paginate(10);
        $filterKeyword = $request->get('keyword');
        if($filterKeyword){
            $printers = \App\Models\Printer::where('serial_number', 'LIKE', "%$filterKeyword%")->paginate(10);
        }
        return view('printers.index', ['printers' => $printers]);

    }
    private function _validation(Request $request)
    {
        $validation = \Validator::make($request->all(),[
            "serial_number" => "required|min:5|max:35|unique:printers",
            "mac_address" => "required|min:17|max:17|unique:printers"
            
        ],
        [
            //message nama
            'serial_number.required' => 'Serial Number harus diisi',
            'serial_number.max' => 'Maximal 35 Digit',
            'serial_number.min' => 'Minimal 5 Digit',
            'serial_number.unique' => 'Serial Number Sudah terdaftar, ganti dengan yang lain',
            //message username
            'mac_address.required' => 'MAC Address harus diisi',
            'mac_address.max' => 'Harus 17 Digit',
            'mac_address.min' => 'Harus 17 Digit',
            'mac_address.unique' => 'MAC Address sudah terdaftar, ganti dengan yang lain'
             
        ]
        )->validate();

    }
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

        $import = Excel::import(new PrintersImport(), storage_path('app/public/excel/' . $nama_file));

        //remove from server
        Storage::delete($path);

        if ($import) {
            //redirect
            return redirect()->route('printers.index')->with(['message' => 'Data Berhasil Diimport!']);
        } else {
            //redirect
            return redirect()->route('printers.index')->with(['message' => 'Data Gagal Diimport!']);

        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('printers.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->_validation($request);
        $new_printer = new \App\Models\Printer;
        $new_printer->serial_number = $request->get('serial_number');
        $new_printer->mac_address = $request->get('mac_address');
        $new_printer->created_by = \Auth::user()->id;
        $new_printer->save();
        return redirect()->route('printers.create')->with('message', 'Printer Berhasil ditambahkan');
        
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $printer = \App\Models\Printer::findOrFail($id);
        
        return view('printers.show', ['printer' => $printer]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $printer_to_edit = \App\Models\Printer::findOrFail($id);
        return view('printers.edit', ['printer' => $printer_to_edit]);
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
            "serial_number" => "required|min:5|max:35",
            "mac_address" => "required|min:17|max:17"
            
        ],
        [
            //message nama
            'serial_number.required' => 'Serial Number harus diisi',
            'serial_number.max' => 'Maximal 35 Digit',
            'serial_number.min' => 'Minimal 5 Digit',
            
            //message username
            'mac_address.required' => 'MAC Address harus diisi',
            'mac_address.max' => 'Harus 17 Digit',
            'mac_address.min' => 'Harus 17 Digit'
            
             
        ]
        )->validate();

        $serial_number = $request->get('serial_number');
        $mac_address = $request->get('mac_address');
        $printer = \App\Models\Printer::findOrFail($id);

        $printer->serial_number = $serial_number;
        $printer->mac_address = $mac_address;
        $printer->updated_by = \Auth::user()->id;
        $printer->save();

        return redirect()->route('printers.index', [$id])->with('message', 'Data Printer Berhasil diUpdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $printer = \App\Models\Printer::findOrFail($id);
        $printer->delete();
        return redirect()->route('printers.index')->with('message', 'Printer Berhasil diHapus ke Trash');

    }
}
