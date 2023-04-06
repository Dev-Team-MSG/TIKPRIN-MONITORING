<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UserDataTable extends DataTable
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
            ->addColumn("role", function($row) {

                if(empty($row->roles[0]->name)) {
                    return strtoupper($row->roles[0]->name);
                }
                return strtoupper($row->roles[0]->name);
            })
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $action = '<a href='.route('users.edit', $row->id).' class="btn btn-icon btn-primary btn-sm action"><i class="far fa-edit"></i></a>
                <a href='.route('users.detail', $row->id).' class="btn btn-icon btn-info btn-sm action"><i class="far fas fa-info-circle"></i></a>
                <a href="javascript:;" class="btn btn-icon btn-danger btn-sm action" onclick="deleteData('. $row->id.')"><i class="fas fa-times"></i></a>
                <form id="delete-form-'. $row->id .'"
                    action='.route("users.hapus",$row->id).' method="POST"
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
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model): QueryBuilder
    {
        // dd($model);
        return $model->newQuery()->with("roles");
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
                    ->setTableId('user-table')
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
            Column::make('DT_RowIndex')->title('No')->searchable(false)->orderable(false),
            Column::make('name'),
            Column::make('email'),
            Column::make('role'),
            Column::make('created_at')->title('Dibuat Pada'),
            // Column::make('updated_at'),
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
        return 'User_' . date('YmdHis');
    }
}
