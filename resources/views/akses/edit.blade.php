@extends('layouts.master')
@section('title')
    User
@endsection
@section('content')
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="button-action" style="margin-bottom: 20px">

                    <a href="" class="btn btn-icon icon-left btn-primary"><i class="far fa-edit"></i> Role: {{$role->name}}</a>
                    <hr>
                </div>
            </div>
        </div>
        <form action="{{ route('permission.update', $role->id) }}" method="post">
            @csrf
            @method('PUT')
            <table class="table table-striped table-bordered table-sm">
                <tr>
                    <th>Kode Menu</th>
                    <th>Nama Menu</th>
                    <th>Akses</th>
                    <th>Tambah</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                @foreach ($list_menu as $lm)
                    <tr>


                        <td>{{ $lm->kode_menu }}</td>
                        <td>{{ $lm->nama_menu }}</td>
                        <td>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="check1" name="akses{{$loop->iteration}}"
                                 {{ $lm->akses == 1 ? 'checked' : '' }}>
                            </div>
                        </td>
                        <td>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="check1" name="tambah{{$loop->iteration}}"
                                {{ $lm->tambah == 1 ? 'checked' : '' }}>
                            </div>
                        </td>
                        </td>
                        <td>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="check1" name="edit{{$loop->iteration}}"
                                {{ $lm->edit == 1 ? 'checked' : '' }}>
                            </div>
                        </td>
                        </td>
                        <td>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="check1" name="hapus{{$loop->iteration}}"
                                {{ $lm->hapus == 1 ? 'checked' : '' }}>
                            </div>
                        </td>
                        </td>
                    </tr>
                @endforeach

            </table>
            <button type="submit">Submit</button>
        </form>


    </div>
    </div>
    </div>
@endsection

@push('page-scripts')
@endpush
@section('scripts')
