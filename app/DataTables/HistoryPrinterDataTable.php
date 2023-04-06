<?php

namespace App\DataTables;

use App\Models\HistoryPrinter;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class HistoryPrinterDataTable extends DataTable
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
        ->editColumn('created_at', function ($row) {
            return showDateTime($row->created_at, 'l, d F Y');
        })
        
        ->addIndexColumn()
            ->addColumn('action', 'historyprinter.action')
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\HistoryPrinter $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(HistoryPrinter $model): QueryBuilder
    {
        return $model->newQuery()->with('location_lama', 'location_baru');
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
                    ->setTableId('historyprinter-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(5, 'desc');
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('No')->searchable(false)->orderable(false),
            Column::make('serial_number'),
            'kanim_name' => new Column(['title'=>"Dari Kanim", 'data'=>'location_lama.name']),
            'kanim_name2' => new Column(['title'=>"Ke Kanim", 'data'=>'location_baru.name']),  
            Column::make('catatan'),
            Column::make('created_at')->title('Direlokasi Pada')
                  ->exportable(false)
                  ->printable(false)
                  ->width(150)
                  ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'HistoryPrinter_' . date('YmdHis');
    }
}
