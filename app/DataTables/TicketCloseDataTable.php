<?php

namespace App\DataTables;

use App\Models\Ticket;
use App\Models\TicketClose;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class TicketCloseDataTable extends DataTable
{
   /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
        ->editColumn("created_at", function ($row) {
            return $row->created_at . " ( " . Carbon::parse($row['created_at'])->diffForHumans() . " )";
        })
        ->editColumn("owner_id", function ($row) {
            if ($row->owner != null) {
                return $row->owner->name;
            }
            return "User Tidak ditemukan";
        })
        ->editColumn("assign_id", function ($row) {
            if (!isset($row->assign_to)) {

                $data = "";
            } else {
                $data = $row->assign_to->name;
            }
            return $data;
        })
        ->addColumn("description", function ($row) {
            if (strlen($row->description) > 50) {
                $str = substr($row->description, 0, 7) . '...';
                return $str;
            }
            return $row->description;
        })
        ->addColumn("category_ticket_id", function ($row) {
            return $row->category->category;
        })
        ->addColumn('action', function ($row) {
            $action = '<a href=' . route("detail-ticket", $row->no_ticket) . ' class="btn btn-icon btn-primary btn-sm action"><i class="far fa-edit"></i></a>';
            return $action;
        })
        ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Ticket $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): QueryBuilder
    {
        if (Auth::user()->roles[0]->name == "engineer") {
            $data = Ticket::with(["category", "owner"])->select("*")->where("status", "close")->where("assign_id", Auth::user()->id);
        } else if (Auth::user()->roles[0]->name == "kanim") {
            $data = Ticket::with(["category", "owner"])->select("*")->where("status", "close")->where("owner_id", Auth::user()->id);
        } else {
            $data = Ticket::with(["category", "owner"])->select("*")->where("status", "close");
        }
        return $data->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->parameters(['searchDelay' => 1000])
            ->setTableId('ticket-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1);
            // ->selectStyleSingle();
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [
            Column::make('no_ticket'),
            Column::make("assign_id")->title("Ditugaskan Ke"),
            Column::make("category_ticket_id")->title("Kategori"),
            Column::make('title'),
            Column::make("owner_id")->title("Pembuat"),
            Column::make('created_at'),
            Column::make('action'),

            // Column::make('updated_at'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Ticket_' . date('YmdHis');
    }
}
