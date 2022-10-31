@extends('layouts.master')
@section('title')
    Printer
@endsection
@section('content')
    @push('lib-styles')
        <link rel="stylesheet" href="{{ asset('assets/modules/prism/prism.css') }}">
    @endpush
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="button-action" style="margin-bottom: 20px">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#import"><i
                            class="far fa-user"></i>
                        IMPORT
                    </button>
                    <a href="{{ route('printers.create') }}" class="btn btn-icon icon-left btn-primary"><i
                            class="far fa-edit"></i> Tambah Printer</a>
                    <hr>
                    <form action="{{ route('printers.index') }}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <input value="{{ Request::get('keyword') }}" name="keyword"
                                        class="form-control col-md-10" type="text" placeholder="Cari berdasarkan SN" />
                                    <input type="submit" value="Filter" class="btn btn-primary">
                                    {{-- <div class="input-group-append">
                                        <input type="submit" value="Filter" class="btn btn-primary">
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </form>
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
        <table class="table table-striped table-bordered table-sm">
            <tr>
                <th>No</th>
                <th>Serial Number</th>
                <th>MAC Address</th>
                <th>Action</th>
            </tr>
            @foreach ($printers as $no => $printer)
                <tr>
                    <td>{{ $printers->firstItem() + $no }}</td>
                    <td>{{ $printer->serial_number }}</td>
                    <td>{{ $printer->mac_address }}</td>
                    <td><a href="{{ route('printers.edit', [$printer->id]) }}" class="badge badge-success">Edit</a>
                        <a href="#" data-id="{{ $printer->id }}" class="badge badge-danger swal-confirm" value="Trash">Delete
                            <form action="{{ route('printers.destroy', [$printer->id]) }}" id="hapus{{ $printer->id }}"
                                method="POST">
                                @csrf
                                @method('delete')
                            </form>
                        </a>
                        <a href="{{ route('printers.show', [$printer->id]) }}" class="badge badge-info">Detail</a>
                    </td>
                </tr>
            @endforeach
        </table>
        {{ $printers->appends(Request::all())->links() }}
    </div>
    </div>
    </div>
@endsection
@section('modal')
    <div class="modal fade" id="import" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">IMPORT DATA</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('printers.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>PILIH FILE</label>
                            <input type="file" name="file" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                        <button type="submit" class="btn btn-success">IMPORT</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('page-scripts')
    <script src="{{ asset('assets/modules/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets/modules/prism/prism.js') }}"></script>
    <script src="http://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#table').DataTable();
        });
    </script>
@endpush
@push('specific-scripts')
    <script src="{{ asset('assets/js/page/bootstrap-modal.js') }}"></script>
@endpush
@push('after-scripts')
    <script>
        $(".swal-confirm").click(function(e) {
            id = e.target.dataset.id;
            swal({
                    title: 'Yakin akan menghapus Data?',
                    text: 'Data yang sudah dihapus tidak dapat dikembalikan!',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        // swal('Berhasil! Data Anda telah terhapus!', {
                        //   icon: 'success',
                        // });
                        $(`#hapus${id}`).submit();
                    } else {
                        swal('Batal Hapus, Data Anda Aman!');
                    }
                });
        });
    </script>
    {{-- <script>
    $('#import').on('shown.bs.import', function() {
        $(document).off('focusin.import');
    });
    </script> --}}
@endpush
