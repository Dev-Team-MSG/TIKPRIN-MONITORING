@extends('layouts.master')
@section('title')
    Kanim
@endsection
@section('content')
    @push('lib-styles')
        <link rel="stylesheet" href="{{ asset('assets/modules/prism/prism.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/modules/datatables/datatables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
        {{-- <link rel="stylesheet" href="{{ asset('assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}"> --}}
    @endpush
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="button-action" style="margin-bottom: 20px">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#import"><i
                            class="far fa-user"></i>
                        IMPORT
                    </button>
                    <a href="{{ route('kanims.create') }}" class="btn btn-icon icon-left btn-primary"><i
                            class="far fa-edit"></i> Tambah Kanim</a>
                    <hr>
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
            <div class="alert alert-warning alert-dismissible show fade">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert">
                        <span>×</span>
                    </button>
                    {{ session('error') }}
                </div>
            </div>
        @endif
        
            {{$dataTable->table()}}
        {{-- <table class="table table-striped table-bordered table-sm">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Network Address</th>
                <th>Action</th>
            </tr>
            @foreach ($kanims as $no => $kanim)
                <tr>
                    <td>{{ $kanims->firstItem() + $no }}</td>
                    <td>{{ $kanim->name }}</td>
                    <td>{{ $kanim->network }}</td>
                    <td><a href="{{ route('kanims.edit', [$kanim->id]) }}" class="badge badge-success">Edit</a>
                        <a href="#" data-id="{{ $kanim->id }}" class="badge badge-danger swal-confirm" value="delete">Delete
                            <form action="{{ route('kanims.destroy', [$kanim->id]) }}" id="hapus{{ $kanim->id }}"
                                method="POST">
                                @csrf
                                @method('delete')
                            </form>
                        </a>
                        <a href="{{ route('kanims.show', [$kanim->id]) }}" class="badge badge-info">Detail</a>
                    </td>
                </tr>
            @endforeach
        </table>
        {{ $kanims->appends(Request::all())->links() }} --}}
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
                <form action="{{ route('kanims.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="modal-body">
                        <div class="form-group">
                            <label>PILIH FILE</label>
                            @if (count($errors) > 0)
                            <div class="row">
                                <div class="col-md-8 col-md-offset-1">
                                  <div class="alert alert-danger alert-dismissible">
                                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                      <h4><i class="icon fa fa-ban"></i> Error!</h4>
                                      @foreach($errors->all() as $error)
                                      {{ $error }} <br>
                                      @endforeach      
                                  </div>
                                </div>
                            </div>
                            @endif
              
                            @if (Session::has('success'))
                                <div class="row">
                                  <div class="col-md-8 col-md-offset-1">
                                    <div class="alert alert-success alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <h5>{!! Session::get('success') !!}</h5>   
                                    </div>
                                  </div>
                                </div>
                            @endif
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
    <script src="{{ asset('assets/modules/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/modules/jquery-ui/jquery-ui.min.js') }}"></script>
    {{ $dataTable->scripts() }}

@endpush
@push('specific-scripts')
    <script src="{{ asset('assets/js/page/bootstrap-modal.js') }}"></script>
    <script src="{{ asset('assets/js/page/modules-datatables.js') }}"></script>
    
    
@endpush
@push('after-scripts')

<script>
    function deleteData(id) {
        swal({
            title: "Yakin akan menghapus Data?",
            text: "Data yang sudah dihapus tidak dapat dikembalikan!",
            icon: "warning",
            buttons: true,
            showCancelButton: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                document.getElementById(`delete-form-${id}`).submit();
                console.log(willDelete)

            } else {
                swal("Batal Hapus, Data Anda Aman!");
            }
            $(`#kanim-table`).datatable().ajax.reload();
        });
    }
</script>
@endpush
