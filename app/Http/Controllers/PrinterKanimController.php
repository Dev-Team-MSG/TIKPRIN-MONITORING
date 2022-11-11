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
use App\Models\PrinterKanim;
use App\Models\Kanim;
use App\Models\Printer;
use App\DataTables\PrinterKanimDataTable;
use Illuminate\Database\Eloquent\Builder;

class PrinterKanimController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PrinterKanimDataTable $dataTable)
    {

        return $dataTable->render('printerkanims.index');

        // $printers = \App\Models\Printer::get();
        // $kanims = \App\Models\Kanim::get();
        // $printerkanims = \App\Models\PrinterKanim::paginate(10);
        // $filterKeyword = $request->get('keyword');
        // if($filterKeyword){
        //     $printerkanims = \App\Models\PrinterKanim::where('printer_id', 'LIKE', "%$filterKeyword%")
        //     ->paginate(10);
        // }

        // // return view('printerkanims');
        // return view('printerkanims.index', ['printerkanims' => $printerkanims]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $printers = \App\Models\Printer::get();
        // $kanimId = 1;
        // $printers = Printer::whereDoesntHave('kanims.id', function (Builder $query) {
        //     $query->where('banned', 0);
        // })->get();
        $new_printerkanim = new \App\Models\PrinterKanim;
        $printeronkanim = $new_printerkanim->printeronkanim();
        $kanims = \App\Models\Kanim::get();

        return view('printerkanims.create', compact("printeronkanim", "kanims"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $new_printerkanim = new \App\Models\PrinterKanim;
        $new_printerkanim->printer_id = $request->get('printer_id');
        $new_printerkanim->kanim_id = $request->get('kanim_id');
        // $new_kanim->created_by = \Auth::user()->id;
        $new_printerkanim->save();
        return redirect()->route('printerkanims.index')->with('message', 'Relokasi Printer Berhasil Dilakukan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $printeronkanim = \App\Models\PrinterKanim::findOrFail($id);
        $printeronkanim->delete();
        return redirect()->back()->with('message', 'Relokasi Berhasil dihapus');
    }
}
