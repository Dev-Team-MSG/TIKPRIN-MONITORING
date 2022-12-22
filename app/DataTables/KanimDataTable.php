<?php

namespace App\DataTables;

use App\Models\Kanim;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class KanimDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->editColumn('created_at', function ($row) {
                return showDateTime($row->created_at, 'l, d F Y');
            })
            ->editColumn('updated_at', function ($row) {
                return showDateTime($row->updated_at, 'l, d F Y');
            })
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $action = '<a href='.route('kanims.edit', $row->id).' class="btn btn-icon btn-primary btn-sm action"><i class="far fa-edit"></i></a>
                <a href='.route('kanims.show', $row->id).' class="btn btn-icon btn-info btn-sm action"><i class="far fas fa-info-circle"></i></a>
                <a href="javascript:;" class="btn btn-icon btn-danger btn-sm action" onclick="deleteData('. $row->id.')"><i class="fas fa-times"></i></a>
                <form id="delete-form-'. $row->id .'"
                    action='.route("kanims.destroy",$row->id).' method="POST"
                    style="display: none;">
                    '.csrf_field().'
                    '.method_field('delete').'
                </form>';
                return $action;
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Kanim $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Kanim $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->parameters(['searchDelay' => 1000])
            ->setTableId('kanim-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(4, 'desc');
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

            // Column::make('id'),
            Column::make('DT_RowIndex')->title('No')->searchable(false)->orderable(false),
            Column::make('name')->title('Nama Kantor'),
            Column::make('telp')->title('No Telp'),
            Column::make('created_at')->title('Dibuat Pada'),
            Column::make('updated_at')->title('Diperbaharui Pada'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(160)
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
        return 'Kanim_' . date('YmdHis');
    }
}
