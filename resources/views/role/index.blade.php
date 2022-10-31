@extends('layouts.master')
@section('title', 'Semua Tiket')
@section('content')
    <section class="section">


        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4>Role</h4>
                    <div class="card-header-action">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#formModal">
                            Tambah Role
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Permission</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody id='role-list' name="role-list">
                                @if (count($role) == 0)
                                    <tr>
                                        <td valign="top" colspan="3" class="dataTables_empty text-center">No data
                                            available
                                            in table</td>
                                    </tr>
                                @endif
                                @foreach ($role as $item)
                                    <tr id="todo{{ $item->id }}" data-iter={{ $loop->iteration }}>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td class="py-4 px-6 border-b border-grey-light">
                                            @foreach ($item->permissions as $permission)
                                                <span
                                                    class="badge badge-pill badge-secondary">{{ $permission->name }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            <a href="{{ route('roles.edit', $item->id) }}" class="btn btn-warning edit-role"
                                                {{-- data-target="#formEditModal"  --}}>Edit</a>
                                            <form action="{{ route('roles.destroy', $item->id) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-danger">Delete</button>
                                            </form>

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
                    <h5 class="modal-title" id="formModalLabel">Tambah role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="myForm" name="myForm" class="form-horizontal" novalidate>
                        @csrf
                        <div class="form-group
                    col-md">
                            <label for="inputrole">role</label>
                            <input type="text" class="form-control" id="inputrole" placeholder="role" name="role"
                                required />
                        </div>
                        <div class="form-group">
                            <h5 class="text-xl my-4 text-gray-600">Permissions</h5>
                            <div class="grid grid-cols-3 gap-4">
                                @foreach ($permissions as $permission)
                                    <div class="flex flex-col justify-cente">
                                        <div class="flex flex-col">
                                            <label class="inline-flex items-center mt-3">
                                                <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600"
                                                    name="permissions" value="{{ $permission->id }}"
                                                    id="inputPermission"><span
                                                    class="ml-2 text-gray-700">{{ $permission->name }}</span>
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
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
@endsection



@endsection
@push('page-scripts')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $("#btn-save").click(function(e) {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        e.preventDefault();
        var permit = []
        $("input:checkbox[name=permissions]:checked").each(function() {
            permit.push($(this).val());
        });
        var formData = {
            name: jQuery('#inputrole').val(),
            permissions: permit
        };
        var state = $('#btn-save').val();
        var type = "POST";
        var ajaxurl = "roles";

        $.ajax({
            type: type,
            url: ajaxurl,
            data: formData,
            dataType: 'json',
            success: function(data) {
                console.log()
                Swal.fire({
                    icon: 'success',
                    title: "Data berhasil ditambahkan",
                    showDenyButton: false,
                    showCancelButton: false,
                    confirmButtonText: 'Yes'
                }).then((_) => {
                    // console.log("result : " + result.role)
                    window.location.reload()


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
    });
</script>
@endpush
@section('scripts')

@endsection
