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
use App\Models\Kanim;
use App\Models\Printer;
use App\DataTables\RelokasiPrinterDataTable;
use Illuminate\Database\Eloquent\Builder;

use function App\Helpers\cek_akses_user;

class RelokasiPrinterController extends Controller
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
    public function index(RelokasiPrinterDataTable $dataTable)
    {

        return $dataTable->render('relokasiprinters.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     if($this->cek->tambah != 1) {
    //         abort(403);
    //     }
    //     // $printers = \App\Models\Printer::get();
    //     // $kanimId = 1;
    //     // $printers = Printer::whereDoesntHave('kanims.id', function (Builder $query) {
    //     //     $query->where('banned', 0);
    //     // })->get();
    //     $new_printerkanim = new \App\Models\PrinterKanim;
    //     $printeronkanim = $new_printerkanim->printeronkanim();
    //     $kanims = \App\Models\Kanim::get();

    //     return view('printerkanims.create', compact("printeronkanim", "kanims"));
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($this->cek->tambah() != 1) {
            abort(403);
        }
        $new_printerkanim = new \App\Models\PrinterKanim;
        $new_printerkanim->printer_id = $request->get('printer_id');
        $new_printerkanim->kanim_id = $request->get('kanim_id');
        $new_printerkanim->catatan = $request->get('catatan');
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
        $printer = \App\Models\Printer::findOrFail($id);
        $kanims = \App\Models\Kanim::get();
        return view('relokasiprinters.edit', compact("printer", "kanims"));
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
        $printer = \App\Models\Printer::findOrFail($id);
        $printer->kanim_id = $request->get('kanim_id');
        $printer->catatan = $request->get('catatan');
        $printer->updated_by = Auth::user()->id;
        $printer->save();
        return redirect()->route('relokasiprinters.index', [$id])->with('message', 'Relokasi Printer Berhasil');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     if($this->cek->hapus != 1) {
    //         abort(403);
    //     }
    //     $printeronkanim = \App\Models\PrinterKanim::findOrFail($id);
    //     $printeronkanim->delete();
    //     return redirect()->back()->with('message', 'Relokasi Berhasil dihapus');
    // }
}
