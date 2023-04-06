<?php

namespace App\Http\Controllers;

use App\Exports\TicketsExport;
use App\Http\Requests\StoreReportRequest;
use App\Http\Requests\UpdateReportRequest;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view("reports.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreReportRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReportRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateReportRequest  $request
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        //
    }

    public function reportTiket(Request $request)
    {
        
        if($request->tanggal_dari == null) {
            return redirect()->back()->with("error", "Tanggal mulai tidak boleh kosong");
        }

        if($request->type_file == "pdf"){
            return (new TicketsExport($request->tanggal_dari, $request->tanggal_sampai, $request->status))->download('invoices.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
        }
        return (new TicketsExport($request->tanggal_dari, $request->tanggal_sampai, $request->status))->download('tickets.xlsx');
    }
    public function reportRelokasiPrinter(Request $request)
    {
        dd($request);
    }
}
