@extends('layouts.master')
@section('title', 'Semua Tiket')
@push('lib-styles')
    <link rel="stylesheet" href="{{ asset('assets/modules/prism/prism.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables/datatables.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
@endpush
@section('content')

    <section class="section">
        <div class="section-body">
            <div class="row">
                {{-- <div class="col-12 col-md-12 col-lg-12">
                    <div class="button-action" style="margin-bottom: 20px">
                        <a href="{{ route('view-create-ticket') }}" class="btn btn-success">Buat Tiket</a>
                        <hr>
                    </div>
                </div> --}}
            </div>
        </div>
        {{ $dataTable->table() }}
    </section>


@endsection
@push('page-scripts')
    <script src="{{ asset('assets/modules/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets/modules/prism/prism.js') }}"></script>
    <script src="{{ asset('assets/modules/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/modules/jquery-ui/jquery-ui.min.js') }}"></script>
    {{ $dataTable->scripts() }}
@endpush
@push('specific-scripts')
    <script src="{{ asset('assets/js/page/bootstrap-modal.js') }}"></script>
    <script src="{{ asset('assets/js/page/modules-datatables.js') }}"></script>
@endpush