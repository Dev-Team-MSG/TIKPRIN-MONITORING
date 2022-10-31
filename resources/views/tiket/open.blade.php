@extends('layouts.master')
@section('title', 'Semua Tiket')
@section('content')

    <section class="section">
        <div class="section-header">
            <h1>Semua Ticket</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Tiket</a></div>
                <div class="breadcrumb-item"><a href="#">Semua Tiket</a></div>
                <div class="breadcrumb-item"><a href="#">Open</a></div>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4>Simple Table</h4>
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


@endsection
@push('page-scripts')
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

    <script type="text/javascript">
        
        $(function() {
            var table = $('#yajra-dt').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('list-open-ticket') }}",
                columns: [{
                        data: 'Tanggal Pengaduan',
                        name: 'Tanggal Penhaduan'
                    },
                    {
                        data: 'no_ticket',
                        name: 'no_ticket'
                    },

                    {
                        data: 'Jenis Pengaduan',
                        name: 'Jenis Pengaduan'
                    },
                    {
                        data: 'owner.name',
                        name: 'owner'
                    },
                    {
                        data: 'permasalahan',
                        name: 'permasalahan'
                    },
                    {
                        data: 'luarbiasa',
                        name: 'status tiket'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true
                    },
                ]
            });

        });
    </script>
@endpush
@section('scripts')

@endsection
