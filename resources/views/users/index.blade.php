@extends('layouts.master')
@section('title','Home')
@section('content')
@push('lib-styles')
<link rel="stylesheet" href="{{asset('assets/modules/prism/prism.css')}}">
@endpush
<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
          <div class="button-action" style="margin-bottom: 20px">
            <button type="button" class="btn btn-success"  data-toggle="modal" data-target="#import"><i class="far fa-user"></i>
                IMPORT
            </button>
            <a href="{{ route('users.tambah') }}" class="btn btn-icon icon-left btn-primary"><i class="far fa-edit"></i> Tambah Data</a>
            <hr>
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
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role User</th>
                    <th>Action</th>
                </tr>
                @foreach ($users as $no => $data)
                <tr>
                    <td>{{ $users->firstItem()+$no }}</td>
                    <td>{{ $data->name}}</td>
                    <td>{{ $data->email}}</td>
                    <td>{{ $data->roles}}</td>
                    <td><a href="{{ route ('users.edit', $data->id)}}" class="badge badge-success">Edit</a>
                        <a href="#" data-id="{{ $data->id }}" class="badge badge-danger swal-confirm">Delete
                            <form action="{{ route ('users.hapus', $data->id)}}" id="hapus{{ $data->id }}" method="POST">
                            @csrf
                            @method('delete')
                            </form>
                        </a>
                    </td>
                </tr>
                @endforeach    
            </table>
            {{ $users->links() }}
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
<script src="{{ asset('assets/modules/sweetalert/sweetalert.min.js')}}"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script> --}}
<script src="{{ asset('assets/modules/prism/prism.js')}}"></script>
<script src="http://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready( function () {
        $('#table').DataTable();
    } );
  </script>
@endpush
@push('specific-scripts')
<script src="{{ asset('assets/js/page/bootstrap-modal.js')}}"></script>
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