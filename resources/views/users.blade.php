@extends('layouts.master')
@section('title')
    User
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
                    <a href="{{ route('users.tambah') }}" class="btn btn-icon icon-left btn-primary"><i
                            class="far fa-edit"></i> Tambah User</a>
                    <hr>
                    <form action="{{ route('users') }}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <input value="{{ Request::get('keyword') }}" name="keyword"
                                        class="form-control col-md-10" type="text"
                                        placeholder="Filter berdasarkan email" />
                                    {{-- <div class="input-group-append">
                                        <input type="submit" value="Filter" class="btn btn-primary">
                                    </div> --}}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <input {{ Request::get('roles') == 'admin' ? 'checked' : '' }} value="admin" name="roles"
                                    type="radio" class="form-group" id="admin">
                                <label for="admin">Admin</label>

                                <input {{ Request::get('roles') == 'kanim' ? 'checked' : '' }} value="kanim" name="roles"
                                    type="radio" class="form-group" id="kanim">
                                <label for="kanim">Kanim</label>

                                <input {{ Request::get('roles') == 'eos' ? 'checked' : '' }} value="eos" name="roles"
                                    type="radio" class="form-group" id="eos">
                                <label for="eos">EOS</label>
                                <input type="submit" value="Filter" class="btn btn-primary">
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
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible show fade">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert">
                        <span>×</span>
                    </button>
                    {{ session('error') }}
                </div>
            </div>
        @endif
        <table class="table table-striped table-bordered table-sm">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role User</th>
                <th>Action</th>
            </tr>

            @foreach ($users as $no => $data)
                <tr>
                    <td>{{ $users->firstItem() + $no }}</td>
                    <td>{{ $data->name }}</td>
                    <td>{{ $data->email }}</td>

                    @if (sizeof($data->roles) == 1)
                        <td>
                            @if ($data->roles[0]->name == "admin")
                                <span class="badge badge-primary">
                                    {{ $data->roles[0]->name }}
                                </span>
                            @elseif ($data->roles[0]->name == 'kanim')
                                <span class="badge badge-secondary">
                                    {{ $data->roles[0]->name }}
                                </span>
                            @else
                                <span class="badge badge-light">
                                    {{ $data->roles[0]->name }}
                                </span>
                            @endif
                        </td>
                    @else
                        <td>
                            <span class="badge badge-danger">
                                undefined
                            </span> 
                        </td>
                    @endif
                    {{-- @php
                    dd($data->roles[0]);
                @endphp --}}
                    <td><a href="{{ route('users.edit', $data->id) }}" class="badge badge-success">Edit</a>
                        <a href="#" data-id="{{ $data->id }}" class="badge badge-danger swal-confirm">Delete
                            <form action="{{ route('users.hapus', $data->id) }}" id="hapus{{ $data->id }}"
                                method="POST">
                                @csrf
                                @method('delete')
                            </form>
                        </a>
                        <a href="{{ route('users.detail', [$data->id]) }}" class="badge badge-info">Detail</a>
                    </td>
                </tr>
            @endforeach
        </table>
        {{ $users->appends(Request::all())->links() }}
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
                <form action="{{ route('users.import') }}" method="POST" enctype="multipart/form-data">
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
