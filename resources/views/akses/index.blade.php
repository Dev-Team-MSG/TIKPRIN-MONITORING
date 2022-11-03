@extends('layouts.master')
@section('title')
    User
@endsection
@section('content')
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="button-action" style="margin-bottom: 20px">
                    <button type="button" class="btn btn-icon icon-left btn-primary" data-toggle="modal" data-target="#formModal">
                        Tambah Role
                    </button>
                    <hr>
                </div>
            </div>
        </div>

        <table class="table table-striped table-bordered table-sm">
            <tr>
                <th>No</th>
                <th>Role</th>
                <th>Action</th>
            </tr>

            @foreach ($role as $item)
                @php
                    $i = 1;
                @endphp
                <tr>

                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->name }}</td>
                    <td>
                        <form action="{{ route('konfigurasi.destroy', $item->id) }}" method="POST"
                            class="inline">
                            <a href="{{ route('konfigurasi.edit', $item->id) }}"
                                class="btn btn-warning edit-role" {{-- data-target="#formEditModal"  --}}>Edit</a>
                            @csrf
                            @method('delete')
                            <button class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach

        </table>

    </div>
    </div>
    </div>
@endsection
@section('modal')
    <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModalLabel">Tambah role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="myForm" name="myForm" method="POST" class="form-horizontal" novalidate action="{{route("roles.store")}}">
                        @csrf
                        <div class="form-group
                    col-md">
                            <label for="inputrole">Role</label>
                            <input type="text" class="form-control" id="inputrole" placeholder="role" name="role"
                                required />
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="btn-save" value="add">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('page-scripts')
@endpush
@section('scripts')