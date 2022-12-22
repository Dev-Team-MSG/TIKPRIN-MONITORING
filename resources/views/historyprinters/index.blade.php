@extends('layouts.master')
@section('title')
    History Printer
@endsection
@section('content')
    @push('lib-styles')
        <link rel="stylesheet" href="{{ asset('assets/modules/prism/prism.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/modules/datatables/datatables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    @endpush
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="button-action" style="margin-bottom: 20px">
                    {{-- <a href="{{ route('printerkanims.create') }}" class="btn btn-icon icon-left btn-primary"><i
                            class="far fa-edit"></i> Relokasi Printer</a>
                    <hr> --}}
                </div>
            </div>
        </div>

        @if (session('message'))
            <div class="alert alert-success alert-dismissible show fade">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert">
                        <span>×</span>
                    </button>
                    {{ session('message') }}
                </div>
            </div>
        @endif
        {{-- <table class="table table-striped table-bordered table-sm"> --}}
            {{$dataTable->table()}}
        {{-- </table> --}}
        {{-- {{ $printerkanims->appends(Request::all())->links() }} --}}
    </div>
    </div>
    </div>
@endsection
@section('modal')
@endsection
@push('page-scripts')
    <script src="{{ asset('assets/modules/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets/modules/prism/prism.js') }}"></script>
    <script src="{{ asset('assets/modules/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/modules/jquery-ui/jquery-ui.min.js') }}"></script>
@endpush
@push('specific-scripts')
    <script src="{{ asset('assets/js/page/bootstrap-modal.js') }}"></script>
    <script src="{{ asset('assets/js/page/modules-datatables.js') }}"></script>
    {{ $dataTable->scripts() }}
    {{-- <script>
        const modal = new bootstrap.Modal($('#modalAction'))
        $('#printer-table').on('click', '.action', function(){
            let data = $(this).data()
            let id = data.id
            let jenis = data.jenis
            modal.show()
            console.log(data);
            

        })
    </script> --}}
@endpush
@push('after-scripts')
@endpush