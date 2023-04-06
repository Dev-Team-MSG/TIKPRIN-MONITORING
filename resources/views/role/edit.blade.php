@extends('layouts.master')
@section('title', 'Semua Role')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Edit Role</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Role</a></div>
                <div class="breadcrumb-item"><a href="#">Edit Role</a></div>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4>
                        Ajukan Pengaduan
                    </h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('roles.update', $role->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="flex flex-col space-y-2">
                            <label for="role_name" class="text-gray-700 select-none font-medium">Role Name</label>
                            <input id="role_name" type="text" name="name" value="{{ old('name', $role->name) }}"
                                placeholder="Placeholder"
                                class="px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-200" />
                        </div>

                        <h3 class="text-xl my-4 text-gray-600">Permissions</h3>
                        <div class="grid grid-cols-3 gap-4">
                            @foreach ($permissions as $permission)
                                <div class="flex flex-col justify-cente">
                                    <div class="flex flex-col">
                                        <label class="inline-flex items-center mt-3">
                                            <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600"
                                                name="permissions[]" value="{{ $permission->id }}"
                                                @if (count($role->permissions->where('id', $permission->id))) checked @endif><span
                                                class="ml-2 text-gray-700">{{ $permission->name }}</span>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="text-center mt-16">
                            <button type="submit"
                                class="btn btn-primary ">Update</button>
                        </div>
                </div>
                </form>
            </div>
        </div>
        </div>
    </section>
@endsection
@push('page-scripts')
@endpush
