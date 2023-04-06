<?php

namespace App\Exports;

use App\Models\Ticket;
use Carbon\Carbon;
use Throwable;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Files\LocalTemporaryFile;
use Maatwebsite\Excel\Excel;
use PhpOffice\PhpSpreadsheet\Style\Color;

class TicketsExport implements WithColumnFormatting, FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithCustomStartCell, WithStyles, WithEvents
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
        $this->calledByEvent = false;
    }

    public function registerEvents(): array
    {

        return [
            BeforeWriting::class => function(BeforeWriting $event) {
                $templateFile = new LocalTemporaryFile(storage_path('app/Book1.xlsx'));
                $event->writer->reopen($templateFile, Excel::XLSX);
                $event->writer->getSheetByIndex(0);
                $this->calledByEvent = true; // set the flag
                $event->writer->getSheetByIndex(0)->export($event->getConcernable()); // call the export on the first sheet
    
                return $event->getWriter()->getSheetByIndex(0);
            },
        ];
    }
    

    public function headings(): array
    {
        return [
            'No Tiket',
            "Ditugaskan",
            'Pelapor',
            "Judul Tiket",
            "Deskripsi",
            "Status",
            "Tanggal Selesai",
            "Deadline",
            "Tanggal Dibuat",
            "Tanggal Diupdate"
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
                return Ticket::query()->whereBetween('created_at', [Carbon::parse($this->from_date)->toDateTimeString(), Carbon::parse($this->to_date)->toDateTimeString()]);
            }

            return Ticket::query()->whereBetween('created_at', [Carbon::parse($this->from_date)->toDateTimeString(), Carbon::parse($this->to_date)->toDateTimeString()])->where("status", $this->status);
        }
        // dd($this->to_date);
        if ($this->status == "all") {
            return Ticket::query()->whereBetween('created_at', [Carbon::parse($this->from_date)->toDateTimeString(), Carbon::parse($this->to_date)->toDateTimeString()]);
        }
        return Ticket::query()->whereBetween('created_at', [Carbon::parse($this->from_date)->toDateTimeString(), Carbon::parse($this->to_date)->toDateTimeString()])->where("status", $this->status);
    }

    public function map($invoice): array
    {
        // dd($invoice->assign_to->name);

        if (isset($invoice->assign_to->name)) {
            $assign_name = $invoice->assign_to->name;
        } else {
            $assign_name = " - ";
        }
        // dd($assign_name);
        return [

            $invoice->no_ticket,
            $assign_name,
            $invoice->owner == null ? "user tidak ditemukan" : $invoice->owner->name,
            $invoice->title,
            strip_tags($invoice->description),
            $invoice->status,
            $invoice->close_datetime,
            $invoice->due_datetime,
            $invoice->created_at,
            $invoice->updated_at
        ];
    }

    public function columnFormats(): array
    {
        return [
            'I' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'K' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'K' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }

    public function failed(Throwable $exception)
    {
        return redirect()->back()->with("error", "Gagal Mengeksport data, dengan error : " . $exception);
        // handle failed export
    }
    public function startCell(): string
    {
        return 'B6';
    }
    public function styles(Worksheet $sheet)
    {
        return [
            // Styling an entire column.
            '6'  => ['font'  => ['size' => 12, 'bold' => true, 'color' => [ 'argb' => Color::COLOR_WHITE]], 
                      'fill' => ['fillType'   => Fill::FILL_SOLID,
                                  'startColor' => ['argb' => Color::COLOR_DARKRED],
                                ],
                    ],
        ];
    }
}
