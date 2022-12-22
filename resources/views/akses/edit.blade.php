@extends('layouts.master')
@section('title')
    User
@endsection
@push('page-styles')
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
    <style>
        .toggle.ios,
        .toggle-on.ios,
        .toggle-off.ios {
            border-radius: 20rem;
        }

        .toggle.ios .toggle-handle {
            border-radius: 20rem;
        }
    </style>
@endpush
@section('content')
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="button-action" style="margin-bottom: 20px">
                    <div class="row">
                        <a href="#" class="btn btn-icon icon-left btn-primary mr-2"></i> Role:
                            {{ $role->name }}</a>

                        <button class="btn btn-danger btn-flat btn-sm remove-access" data-id="{{ request()->permission }}"
                            data-action="{{ route('delete-access', request()->permission) }}"> Delete</button>
                        {{-- <form action="{{ route('delete-access', request()->permission) }}" method="POST" class="inline">
                            @csrf
                            @method('delete')
                            <button class="btn btn-danger">Delete</button>
                        </form> --}}
                    </div>
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
                        <div class="form-group" id="form{{ $loop->iteration }}">


                            <td>
                                @if ($lm->level == 'main_menu')
                                    <strong>{{ $lm->kode_menu }}</strong>
                                @else
                                    {{ $lm->kode_menu }}
                                @endif
                            </td>
                            <td>
                                @if ($lm->level == 'main_menu')
                                    <strong>{{ $lm->nama_menu }}</strong>
                                @else
                                    &nbsp &nbsp &nbsp {{ $lm->nama_menu }}
                                @endif
                            </td>
                            @if ($lm->nama_menu == 'Open' ||
                                $lm->nama_menu == 'Progress' ||
                                $lm->nama_menu == 'Close' ||
                                $lm->nama_menu == 'Dashboard' ||
                                $lm->nama_menu == 'Konfigurasi' ||
                                $lm->nama_menu == 'Printer')
                                <td>
                                    <div class="form-check">
                                        <input
                                            class="form-check-input {{ $lm->level == 'main_menu' ? 'select-all' : 'checkboxlistitem' }}"
                                            type="checkbox" data-toggle="toggle" data-style="ios"
                                            name="akses{{ $loop->iteration }}" {{ $lm->akses == 1 ? 'checked' : '' }}>
                                    </div>
                                </td>
                            @else
                                <td>
                                    <div class="form-check">
                                        <input
                                            class="form-check-input {{ $lm->level == 'main_menu' ? 'select-all' : 'checkboxlistitem' }}"
                                            type="checkbox" data-toggle="toggle" data-style="ios"
                                            name="akses{{ $loop->iteration }}" {{ $lm->akses == 1 ? 'checked' : '' }}>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" data-toggle="toggle"
                                            data-style="ios" name="tambah{{ $loop->iteration }}"
                                            {{ $lm->tambah == 1 ? 'checked' : '' }}>
                                    </div>
                                </td>

                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" data-toggle="toggle"
                                            data-style="ios" name="edit{{ $loop->iteration }}"
                                            {{ $lm->edit == 1 ? 'checked' : '' }}>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" data-toggle="toggle"
                                            data-style="ios" name="hapus{{ $loop->iteration }}"
                                            {{ $lm->hapus == 1 ? 'checked' : '' }}>
                                    </div>
                                </td>
                            @endif
                        </div>
                    </tr>
                @endforeach
            </table>
            <button class="btn btn-icon icon-left btn-primary mr-2" type="submit"> <i
                    class="far fa-edit"></i>Simpan</button>
        </form>
    @endsection

    @push('page-scripts')
        <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
        {{-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> --}}
        <script src="{{ asset('assets/modules/sweetalert/sweetalert.min.js') }}"></script>
        <script type="text/javascript">
            $("body").on("click", ".remove-access", function() {
                var current_object = $(this);
                swal({
                    title: "Anda Yakin ?",
                    text: "Apakah anda yakin mau menghapusnya ?",
                    icon: "warning",
                    buttons: true,
                    showCancelButton: true,
                    dangerMode: true,
                }).then((data) => {
                    if (data) {
                        var action = current_object.attr('data-action');
                        var token = jQuery('meta[name="csrf-token"]').attr('content');
                        var id = current_object.attr('data-id');

                        $('body').html("<form class='form-inline remove-form' method='post' action='" + action +
                            "'></form>");
                        $('body').find('.remove-form').append(
                            '<input name="_method" type="hidden" value="delete">');
                        $('body').find('.remove-form').append('<input name="_token" type="hidden" value="' +
                            token + '">');
                        $('body').find('.remove-form').append('<input name="id" type="hidden" value="' + id +
                            '">');
                        $('body').find('.remove-form').submit();
                    } else {
                        swal({
                            title: "Data anda aman",
                            text: "Data tidak terhapus !",
                        })
                    }
                })
            });

            $(".select-all").change(function() {
                $(this).siblings().prop('checked', $(this).prop("checked"));
                console.log($(this).siblings());
            });

            $(".checkboxlistitem").change(function() {
                var checkboxes = $(this).parent().find('.checkboxlistitem');
                var checkedboxes = checkboxes.filter(':checked');
                // console.log(checkboxes);

                if (checkboxes.length === checkedboxes.length) {
                    $(this).closest(".select-all").prop('checked', true);
                } else {

                    $(this).closest(".select-all").prop('checked', false);
                }
            });
        </script>
    @endpush
    @section('scripts')
