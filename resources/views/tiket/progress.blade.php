@extends('layouts.master')
@section('title', 'Semua Tiket Progress')
@section('content')

    <section class="section">
        <div class="section-header">
            <h1>Semua Ticket</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Tiket</a></div>
                <div class="breadcrumb-item"><a href="#">Semua Tiket</a></div>
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
                                <th>Id</th>
                                <th>No tiket</th>
                                <th>Pelapor</th>
                                <th>Jenis Pengaduan</th>
                                <th>title</th>
                                <th>description</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                  </div>
                </div>
                <div class="card-footer text-right">
                  <nav class="d-inline-block">
                    <ul class="pagination mb-0">
                      <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1"><i class="fas fa-chevron-left"></i></a>
                      </li>
                      <li class="page-item active"><a class="page-link" href="#">1 <span class="sr-only">(current)</span></a></li>
                      <li class="page-item">
                        <a class="page-link" href="#">2</a>
                      </li>
                      <li class="page-item"><a class="page-link" href="#">3</a></li>
                      <li class="page-item">
                        <a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a>
                      </li>
                    </ul>
                  </nav>
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
    $(function () {
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
                    data: 'owner',
                    name: 'owner'
                },
                {
                    data: 'Jenis Pengaduan',
                    name: 'Jenis Pengaduan'
                },
                {
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'description',
                    name: 'description'
                },
                {
                    data: 'status',
                    name: 'status'
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
@section("scripts")

@endsection

