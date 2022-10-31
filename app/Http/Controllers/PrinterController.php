<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrinterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $printers = \App\Models\Printer::paginate(10);
        $filterKeyword = $request->get('keyword');
        if($filterKeyword){
            $printers = \App\Models\Printer::where('serial_number', 'LIKE', "%$filterKeyword%")->paginate(10);
        }
        return view('printers.index', ['printers' => $printers]);

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