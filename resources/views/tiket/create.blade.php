@extends('layouts.master')
@section('title', 'Semua Tiket')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Tambah Ticket</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Tiket</a></div>
                <div class="breadcrumb-item"><a href="#">Tambah Tiket</a></div>
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
                    <form action="{{route("store-create-ticket")}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md">
                                <label for="inputEmail4">Pengaduan</label>
                                <input type="text" class="form-control" id="inputEmail4" placeholder="pengaduan" name="title">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputState">Kategori</label>
                            <select id="inputState" class="form-control" name="category_ticket_id">
                                <option selected>Choose...</option>
                                @foreach ($category as $item)
                                    <option value="{{$item->id}}">{{$item->category}}</option>
                                    
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="inputState">Severity</label>
                            <select id="inputState" class="form-control" name="severity_id">
                                <option selected>Choose...</option>
                                @foreach ($severity as $item)
                                    <option value="{{$item->id}}">{{$item->severity}}</option>
                                    
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="user_id" value="1" />
                            <label for="">Deskripsi Pengaduan</label>
                            <textarea class="form-control" id="summary-ckeditor" name="description"></textarea>
                            <label class="mt-4">File Browser</label>
                            <div class="custom-file mb-4">
                                <input type="file" class="custom-file-input" id="customFile" name="fileName[]" multiple>
                                <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Buat</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('page-scripts')
    <script src="//cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>

    <script>
        CKEDITOR.replace('summary-ckeditor', {
            filebrowserUploadMethod: 'form',
            toolbar: [{
                    name: 'document',
                    items: ['Undo', 'Redo']
                },
                {
                    name: 'basicstyles',
                    items: ['Bold', 'Italic', 'Strike', '-', 'RemoveFormat']
                },
                {
                    name: 'links',
                    items: ['Link', 'Unlink', 'Anchor']
                },
                {
                    name: 'insert',
                    items: ['Image', 'Format']
                },
                {
                    name: 'tools',
                    items: ['Maximize', 'ShowBlocks', 'About']
                }
            ],
            toolbarGroups: [{
                    "name": "basicstyles",
                    "groups": ["basicstyles"]
                },
                {
                    "name": "styles",
                    "groups": ["styles"]
                },
            ],
        });
    </script>
@endpush