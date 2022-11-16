<?php

namespace App\DataTables;

use App\Models\Printer;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PrinterDataTable extends DataTable
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
            ->editColumn('created_at', function($row){
                return $row->created_at->format('d-m-Y H:i:s');
            })
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $action = '<a href='.route('printers.edit', $row->id).' class="btn btn-icon btn-primary btn-sm action"><i class="far fa-edit"></i></a>';
                $action .= '<a href="#" data-id=' .$row->id. ' class="swal-confirm btn btn-icon btn-danger btn-sm action"><i class="fas fa-times"></i>
                <form action='.route('printers.destroy', $row->id).' id=hapus'.$row->id.' method="POST">
                    '.csrf_field().'
                    '.method_field('delete').'   
                </form>
            </a>';
                $action .= '<a href='.route('printers.show', $row->id).' class="btn btn-icon btn-info btn-sm action"><i class="far fas fa-info-circle"></i></a>';
                $action .= '<script>
                $(".swal-confirm").click(function(e) {
                    id = e.target.dataset.id;
                    swal({
                            title: "Yakin akan menghapus Data?",
                            text: "Data yang sudah dihapus tidak dapat dikembalikan!",
                            icon: "warning",
                            buttons: true,
                            dangerMode: true,
                        })
                        .then((willDelete) => {
                            if (willDelete) {
                                $(`#hapus${id}`).submit();
                            } else {
                                swal("Batal Hapus, Data Anda Aman!");
                            }
                        });
                });
            </script>';
                return $action;
            });
            // ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Printer $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Printer $model): QueryBuilder
    {
        return $model->newQuery();
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
                    ->setTableId('printer-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1);
                    // ->selectStyleSingle()
                    // ->buttons([
                    //     Button::make('excel'),
                    //     Button::make('csv'),
                    //     Button::make('pdf'),
                    //     Button::make('print'),
                    //     Button::make('reset'),
                    //     Button::make('reload')
                    // ]);
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
            Column::make('mac_address'),
            Column::make('created_at')->title('Dibuat Pada'),
            // Column::make('updated_at'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(120)
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
        return 'Printer_' . date('YmdHis');
    }
}
