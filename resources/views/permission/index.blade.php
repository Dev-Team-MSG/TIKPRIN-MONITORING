@extends('layouts.master')
@section('title', 'Semua Tiket')
@section('content')
    <section class="section">


        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4>Permission</h4>
                    <div class="card-header-action">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#formModal">
                            Tambah Permission
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Permission</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody id='permission-list' name="permission-list">
                                @empty($permission)
                                    <tr>
                                        <td valign="top" colspan="3" class="dataTables_empty text-center">No data available
                                            in table</td>
                                    </tr>
                                @endempty
                                @foreach ($permission as $item)
                                    <tr id="permission{{ $item->id }}" data-iter={{ $loop->iteration }}>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            {{-- <form method="post">
                                                @csrf
                                                {{ method_field('delete') }} --}}
                                            {{-- <input value="delete"> --}}
                                            <a href="javascript:void(0)" class="btn btn-warning edit-permission"
                                                data-toggle="modal" {{-- data-target="#formEditModal"  --}}
                                                data-url="{{ route('permission.show', $item->id) }}">Edit</a>
                                            <a href="javascript:void(0)" id="edit-kategori"
                                                data-url="{{ route('permission.destroy', $item->id) }}"
                                                class="btn btn-danger edit-kategori">Delete</a>
                                            {{-- <input type="hidden" id="categoryId" name="categoryId" value="{{$item->id}}" />
                                                <button class="btn btn-danger" type="button" id="btn-delete">Delete</button>
                                            </form> --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

@section('modal')
    <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModalLabel">Tambah Permission</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="myForm" name="myForm" class="form-horizontal" novalidate>
                        @csrf
                        <div class="form-group
                    col-md">
                            <label for="inputPermission">Permission</label>
                            <input type="text" class="form-control" id="inputPermission" placeholder="permission"
                                name="permission" required value="{{ old('permission') }}" />
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn-save" value="add">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="formEditModal" tabindex="-1" role="dialog" aria-labelledby="formEditModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModalLabel">Edit Permission</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="myFormEdit" name="myForm" class="form-horizontal" novalidate>
                        @csrf
                        <div class="form-group
                col-md">
                            <label for="inputEditPermission">Permission</label>
                            <input type="text" class="form-control" id="inputEditPermission" placeholder="permission"
                                name="permission" required />
                            <input type="hidden" name="idPermission" class="editId">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn-edit" value="edit">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@endsection
@push('page-scripts')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(".edit-permission").click(function(e) {
        var type = "GET";
        var ajaxurl = $(this).data('url');
        console.log(ajaxurl)
        $.ajax({
            type: type,
            url: ajaxurl,
            dataType: 'json',
            success: function(data) {
                console.log(data)
                $('#formEditModal').modal('show');
                $("#inputEditPermission").val(data.name)
                $("input[name=idPermission]").val(data.id)
            },
            error: function(data) {

                console.log("error")
            }
        });
    })


    $(".edit-kategori").click(function(e) {
        var trObj = $(this);
        var ajaxurl = $(this).data('url');
        e.preventDefault()
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        var type = "DELETE";
        Swal.fire({
            icon: 'warning',
            title: "Anda Yakin ingin menghapus Data",
            showCancelButton: true,
            showDenyButton: false,
            confirmButtonText: 'Yes'
        }).then((data) => {
            $.ajax({
                type: type,
                url: ajaxurl,
                dataType: 'json',
                success: function(data) {
                    console.log(data)
                    Swal.fire({
                        icon: 'success',
                        title: "Data berhasil Dihapus",
                        showDenyButton: false,
                        showCancelButton: false,
                        confirmButtonText: 'Yes'
                    }).then(() => {
                        // window.location.reload()
                        trObj.parents("tr").remove();
                    })

                },
                error: function(data) {
                    Swal.fire({
                        icon: 'warning',
                        title: data.responseJSON.message,
                        showCancelButton: true,
                    })

                }
            });
        })
    })


    $("#btn-save").click(function(e) {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        e.preventDefault();
        var formData = {
            name: jQuery('#inputPermission').val(),
        };
        console.log(formData);
        var state = $('#btn-save').val();
        var type = "POST";
        var ajaxurl = "permission";
        var table = $("#permission-list")
        console.log(state == "add")

        $.ajax({
            type: type,
            url: ajaxurl,
            data: formData,
            dataType: 'json',
            success: function(data) {
                console.log(data)
                Swal.fire({
                    icon: 'success',
                    title: "Data berhasil ditambahkan",
                    showDenyButton: false,
                    showCancelButton: false,
                    confirmButtonText: 'Yes'
                }).then((_) => {
                    console.log("success : " + data)
                    // console.log("result : " + result.kategori)
                    // window.location.reload()

                    var permission = `
                                     <tr>
                                        <td>${data.id}</td>
                                        <td>${data.name}</td>
                                        <td>
                                            {{-- <form method="post">
                                                @csrf
                                                {{ method_field('delete') }} --}}
                                            {{-- <input value="delete"> --}}
                                            <a href="" class="btn btn-warning">Edit</a>
                                            <a href="javascript:void(0)" id="edit-kategori"
                                                data-url=""
                                                class="btn btn-danger">Delete</a>
                                            {{-- <input type="hidden" id="permissionId" name="permissionId" value="{{$item->id}}" />
                                                <button class="btn btn-danger" type="button" id="btn-delete">Delete</button>
                                            </form> --}}
                                        </td>
                                    </tr>
                                     `
                    table.append(permission)
                })

            },
            error: function(data) {
                console.log("error")
                Swal.fire({
                    icon: 'warning',
                    // title: data.responseJSON.message,
                    showCancelButton: true,
                })

            }
        });
    });

    $("#btn-edit").click(function(e) {
        var ajaxurl = "permission";

        var id = $("input[name=idPermission]").val()
        var index = $("#permission" + id).data('iter')
        console.log("index" + index)
        console.log(id)
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        e.preventDefault();
        var formData = {
            _method: 'PUT',
            name: jQuery('#inputEditPermission').val(),
        };
        console.log(formData);
        // var table = $("#permission-list")
        $.ajax({
            type: "PUT",
            url: `${ajaxurl}/${id}`,
            data: formData,
            dataType: 'json',
            success: function(data) {
                console.log(data)
                Swal.fire({
                    icon: 'success',
                    title: "Data berhasil ditambahkan",
                    showDenyButton: false,
                    showCancelButton: false,
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    console.log("data success : " + data.id)
                    // console.log("result : " + result.kategori)
                    window.location.reload()
                    var permission = `
                                     <tr>
                                        <td>${index}</td>
                                        <td>${data.name}</td>
                                        <td>
                                            {{-- <form method="post">
                                                @csrf
                                                {{ method_field('delete') }} --}}
                                            {{-- <input value="delete"> --}}
                                            <a href="" class="btn btn-warning">Edit</a>
                                            <a href="javascript:void(0)" id="edit-kategori"
                                                data-url=""
                                                class="btn btn-danger">Delete</a>
                                            {{-- <input type="hidden" id="categoryId" name="categoryId" value="{{$item->id}}" />
                                                <button class="btn btn-danger" type="button" id="btn-delete">Delete</button>
                                            </form> --}}
                                        </td>
                                    </tr>
                                     `
                    $("#permission" + id).replaceWith(permission)
                })

            },
            error: function(data) {
                console.log(data)
                Swal.fire({
                    icon: 'warning',
                    title: data.responseJSON.message,
                    showCancelButton: true,
                })
            }
        })
    })
</script>
@endpush
@section('scripts')

@endsection
