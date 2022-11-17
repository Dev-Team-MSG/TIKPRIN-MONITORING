<?php

namespace App\Exports;

use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TicketsExport implements FromQuery, WithHeadings
{
    use Exportable;
    /**
     * 
     * @return \Illuminate\Support\Collection
     */

    public function __construct($tanggal_dari,  $tanggal_sampai, $status)
    {
        $this->from_date = $tanggal_dari;
        $this->to_date = $tanggal_sampai;
        $this->status = $status;
    }

    public function headings(): array
    {
        return [
            'id',
            'no_tiket',
            "assign_to",
            'owner_id',
            "title",
            "description",
            "status",
            "close_datetime",
            "due_datetime",
            "created_at",
            "updated_at"
        ];
    }

    public function collection()
    {
        return Ticket::all();
    }

    public function query()
    {
        if (($this->from_date == null) && ($this->to_date == null)) {
            if ($this->status == "all") {
                return Ticket::query();
            }
            return Ticket::query()->where("status", $this->status);
        }

        if ($this->from_date == null || $this->to_date == null) {
            if ($this->status == "all") {
                dd("asdas");
                return Ticket::query()->whereBetween('created_at', [Carbon::parse($this->from_date)->toDateTimeString(), Carbon::parse($this->to_date)->toDateTimeString()]);
            }

            return Ticket::query()->whereBetween('created_at', [Carbon::parse($this->from_date)->toDateTimeString(), Carbon::parse($this->to_date)->toDateTimeString()])->where("status", $this->status);
        }
        // dd($this->to_date);
        if($this->status == "all") {
            return Ticket::query()->whereBetween('created_at', [Carbon::parse($this->from_date)->toDateTimeString(), Carbon::parse($this->to_date)->toDateTimeString()]);
        }
        return Ticket::query()->whereBetween('created_at', [Carbon::parse($this->from_date)->toDateTimeString(), Carbon::parse($this->to_date)->toDateTimeString()])->where("status", $this->status);
    }
}
