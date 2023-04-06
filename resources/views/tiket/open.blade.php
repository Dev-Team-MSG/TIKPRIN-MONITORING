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
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="button-action" style="margin-bottom: 20px">
                        <a href="{{ route('view-create-ticket') }}" class="btn btn-success">Buat Tiket</a>
                        <hr>
                    </div>
                </div>
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

{{-- @extends('layouts.master')
@section('title', 'Semua Tiket')
@section('content')

    <section class="section">
        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4>Tiket</h4>
                    <div class="card-header-form">
                        <a href="{{route("view-create-ticket")}}" class="btn btn-success">Buat Tiket</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table-striped table-md" id="yajra-dt">
                            <thead>
                                <tr>
                                    <th>Tanggal Tiket</th>
                                    <th>No tiket</th>
                                    <th>Jenis Pengaduan</th>
                                    <th>Pelapor</th>
                                    <th>Permasalahan</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                
            </div>
        </div>
    </section>


@endsection --}}
@push('page-scripts')
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script> --}}
    <script src="{{ asset('assets/modules/sweetalert/sweetalert.min.js') }}"></script>


    {{-- <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script> --}}
    {{-- <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script> --}}

    <script type="text/javascript">
        @if (session('error'))
            swal({
                title: "Akses dibatasi",
                text: "Anda tidak memiliki akses ke fitur ini !",
                icon: "error",
                // buttons: true,
                // showCancelButton: true,
                dangerMode: true,
            })
        @endif
        // $(function() {
        //     var table = $('#yajra-dt').DataTable({
        //         processing: true,
        //         serverSide: true,
        //         ajax: "{{ route('list-open-ticket') }}",
        //         columns: [{
        //                 data: 'Tanggal Pengaduan',
        //                 name: 'Tanggal Pengaduan'
        //             },
        //             {
        //                 data: 'no_ticket',
        //                 name: 'no_ticket'
        //             },

        //             {
        //                 data: 'Jenis Pengaduan',
        //                 name: 'Jenis Pengaduan'
        //             },
        //             {
        //                 data: 'owner.name',
        //                 name: 'owner'
        //             },
        //             {
        //                 data: 'permasalahan',
        //                 name: 'permasalahan'
        //             },
        //             {
        //                 data: 'Status',
        //                 name: 'status tiket'
        //             },
        //             {
        //                 data: 'action',
        //                 name: 'action',
        //                 orderable: true,
        //                 searchable: true
        //             },
        //         ]
        //     });

        // });
    </script>
@endpush
{{-- @section('scripts')

@endsection --}}
