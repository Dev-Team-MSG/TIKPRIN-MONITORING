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
                return $row->created_at->format('d-m-Y H:i:s');
            })
            ->editColumn('updated_at', function ($row) {
                return $row->updated_at->format('d-m-Y H:i:s');
            })
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $action = '<form action='.route('kanims.destroy', $row->id).' id=hapus'.$row->id.' method="POST">';
                $action .= '<a href='.route('kanims.edit', $row->id).' class="btn btn-icon btn-primary btn-sm action"><i class="far fa-edit"></i></a>
                <button type="submit" data-id=' .$row->id. ' class="swal-confirm btn btn-icon btn-danger btn-sm action" value="delete"><i class="fas fa-times"></i></button>
                    '.csrf_field().'
                    '.method_field('delete').'   
                </form>';
                // $action .= '<a href='.route('kanims.show', $row->id).' class="btn btn-icon btn-info"><i class="far fas fa-info-circle"></i></a>';
                $action .= '<script>
                $(".swal-confirm").click(function(e) {
                    e.preventDefault()
                    id = e.target.dataset.id;
                    swal({
                            title: "Yakin akan menghapus Data?",
                            text: "Data yang sudah dihapus tidak dapat dikembalikan!",
                            icon: "warning",
                            buttons: true,
                            showCancelButton: true,
                            dangerMode: true,
                        })
                        .then((willDelete) => {
                            if (willDelete) {
                                $(`#hapus${id}`).submit();
                                console.log(willDelete)
                                
                            } else {
                                swal("Batal Hapus, Data Anda Aman!");
                            }$(`#kanim-table`).datatable().ajax.reload();
                        });

                });
            </script>';
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

            // Column::make('id'),
            Column::make('DT_RowIndex')->title('No')->searchable(false)->orderable(false),
            Column::make('name'),
            Column::make('network'),
            Column::make('created_at')->title('Dibuat Pada'),
            Column::make('updated_at')->title('Diperbaharui Pada'),
            Column::computed('action')
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
        return 'Kanim_' . date('YmdHis');
    }
}
