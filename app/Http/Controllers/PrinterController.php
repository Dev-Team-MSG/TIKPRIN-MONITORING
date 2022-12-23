<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;
use App\Models\Printer;
use App\DataTables\PrinterDataTable;
use App\Providers\Carbon;

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
    public function index(PrinterDataTable $dataTable)
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
        return $dataTable->render('printers.index');

        // $printers = \App\Models\Printer::paginate(10);
        // $filterKeyword = $request->get('keyword');
        // if($filterKeyword){
        //     $printers = \App\Models\Printer::where('serial_number', 'LIKE', "%$filterKeyword%")->paginate(10);
        // }
        // return view('printers.index', ['printers' => $printers]);

    }
    private function _validation(Request $request)
    {
        $validation = \Validator::make($request->all(),[
            "serial_number" => "required|min:5|max:35|unique:printers",
            "mac_address" => "required|min:17|max:17|unique:printers",
            "tahun_pengadaan" => "required|digits_between:4,4"
            
        ],
        [
            //message serial_number
            'serial_number.required' => 'Serial Number harus diisi',
            'serial_number.max' => 'Maximal 35 Digit',
            'serial_number.min' => 'Minimal 5 Digit',
            'serial_number.unique' => 'Serial Number Sudah terdaftar, ganti dengan yang lain',
            //message mac_address
            'mac_address.required' => 'MAC Address harus diisi',
            'mac_address.max' => 'Harus 17 Digit',
            'mac_address.min' => 'Harus 17 Digit',
            'mac_address.unique' => 'MAC Address sudah terdaftar, ganti dengan yang lain',
             //message tahun pengadaan
            'tahun_pengadaan.required' => 'Tahun Pengadaan harus diisi',
            'tahun_pengadaan.digits_between' => 'Tahun harus 4 Digit',
            // 'tahun_pengadaan.min' => 'Tahun Max harus 4 Digit',
             'tahun_pengadaan.numeric' => 'Tahun harus menggunakan Angka'
             
        ]
        )->validate();

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
        $printer_array = [];
        $is_valid = true;
        $error_msg = '';
        DB::beginTransaction();
        
        try {
        
        foreach ($imported_data as $key => $value) {
            //Row Serial
            $printer_serial = trim($value[1]);
            if(!empty($printer_serial)){
                $cekserial = Printer::where('serial_number', $printer_serial)->first();
                if (empty($cekserial)) {
                    $printer_array['serial_number'] = $printer_serial;
                }else{
                    $is_valid =  false;
                    $error_msg = "Printer serial [".$printer_serial."] sudah ada. Mohon Import Serial Lain.";
                    break;
                }
            }else {
                $is_valid = false;
                $error_msg = "Serial Kosong, check Kembali Serial tidak boleh kosong";
                break;
            }

            //Row MAC Address
            $printer_mac = trim($value[2]);
            if(!empty($printer_mac)){
                $cekmac = Printer::where('mac_address', $printer_mac)->first();
                if (empty($cekmac)) {
                    $printer_array['mac_address'] = $printer_mac;
                }else{
                    $is_valid =  false;
                    $error_msg = "Printer Mac Address [".$printer_mac."] sudah ada. Mohon Import Mac Address Lain.";
                    break;
                }
            }else {
                $is_valid = false;
                $error_msg = "Mac Address Kosong, check Kembali Mac Address tidak boleh kosong";
                break;
            }
            $printer_array['tahun_pengadaan']=$value[3];
            $printer_array['created_by'] = auth()->user()->id;
            $printer_array['created_at'] = date('Y-m-d H:i:s');
            $printer_array['updated_at'] = date('Y-m-d H:i:s');
            //Assign to formated array
            $formated_data[]=$printer_array;
        }
        //dd($formated_data);
        if (!empty($formated_data)) {
            Printer::insert($formated_data);
        }
        DB::commit();
        if ($is_valid) {
            //redirect
            return redirect()->route('printers.index')->with(['message' => 'Data Berhasil Diimport!']);
        } else {
            //redirect
            return redirect()->route('printers.index')->with(['error' => $error_msg]);

        }
    }catch (\Exception $e){
        DB::rollBack();
        return redirect()->route('printers.index')->with(['error' => $e->getMessage()]);
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
        $new_printer->tahun_pengadaan = $request->get('tahun_pengadaan');
        $new_printer->created_by = Auth::user()->id;
        $new_printer->save();
        return redirect()->route('printers.index')->with('message', 'Printer Berhasil ditambahkan');
        
    
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
        $tahun_pengadaan = $request->get('tahun_pengadaan');
        $printer = \App\Models\Printer::findOrFail($id);

        $printer->serial_number = $serial_number;
        $printer->mac_address = $mac_address;
        $printer->tahun_pengadaan = $tahun_pengadaan;
        $printer->updated_by = Auth::user()->id;
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
        $printer = Printer::findOrFail($id);
        if ($printer->kanim_id == 1){
            $printer->delete();
            return redirect()->back()->with('message', 'Printer Berhasil dihapus');
        }else 
        {
            return redirect()->back()->with('error', 'Printer Tidak boleh di hapus karena masih digunakan di Kanim, Silahkan kembalikan ke Pusat terlebih dahulu');
        } 

    }
}
