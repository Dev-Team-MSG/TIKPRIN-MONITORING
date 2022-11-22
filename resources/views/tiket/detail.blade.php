@extends('layouts.master')
@push('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush
@section('title', "$data->no_ticket")
@section('content')

    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-md-2 badge status-{{ $data->status }}">
                                                {{ $data->status }}
                                            </div>
                                            <div class="col-md">
                                                Terakhir diupdate : {{ $data->updated_at->diffForHumans() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h4 class="mb-0 text-center">
                                        {{ $data->title }}
                                    </h4>
                                    <p>
                                        {!! $data->description !!}
                                    </p>
                                    @foreach ($data->files as $item)
                                        <a href="{{ asset("$item->path") }}" target="_blank">{{ $item->filename }}</a>
                                    @endforeach
                                    @if ($permission->edit == 1)
                                        @if ($data->status == 'open')
                                            @if (Auth::user()->roles[0]->name == 'engineer')
                                                <div class="row mt-5">
                                                    <div class="col-md">
                                                        <button class="btn btn-warning btn-flat btn-sm ambil-tiket"
                                                            data-id="{{ $data->id }}"
                                                            data-action="{{ route('ambil-tiket', $data->no_ticket) }}">
                                                            Ambil</button>
                                                    </div>

                                                </div>
                                            @endif
                                        @endif
                                        @if ($data->status == 'progress')
                                            @if (Auth::user()->roles[0]->name == 'kanim')
                                                <div class="row mt-5">
                                                    <div class="col-md">
                                                        <button class="btn btn-danger btn-flat btn-sm close-tiket"
                                                            data-id="{{ $data->id }}"
                                                            data-action="{{ route('close-tiket', $data->no_ticket) }}">
                                                            Close</button>
                                                    </div>

                                                </div>
                                            @endif
                                            {{-- @if (Auth::user()->roles[0]->name == 'engineer')
                                            @php
                                                var_dump("Engineer : ", Auth::user()->roles[0]->name == 'engineer');
                                            @endphp
                                            @if ($data->status == 'open')
                                               
                                            @endif
                                            @endif --}}

                                        @endif
                                    @endcan

                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="container py-5 mx-auto">
                            <div class="main-timeline">
                                @foreach ($data->comments as $comment)
                                    @if ($comment->user_id != Auth::user()->id)
                                        <div class="timeline left">
                                            <div class="card">
                                                <div class="card-header d-flex justify-content-between p-3">
                                                    <p class="fw-bold mb-0">{{ $comment->user->name }}</p>
                                                    <p class="text-muted small mb-0"><i class="far fa-clock"></i>
                                                        {{ $comment->created_at->diffForHumans() }}
                                                    </p>
                                                </div>
                                                <div class="card-body">
                                                    <p class="mb-0">
                                                        {!! $comment->body !!}
                                                    </p>
                                                    @foreach ($comment->files as $item)
                                                        <a href="{{ asset("$item->path") }}" target="_blank"
                                                            rel="noopener noreferrer">{{ $item->filename }}</a>
                                                    @endforeach

                                                    {{-- <a --}}
                                                    {{-- href="{{ asset("$comment->path") }}">{{ $comment->filename }}</a> --}}

                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="timeline right">
                                            <div class="card">
                                                <div class="card-header d-flex justify-content-between p-3">
                                                    <p class="fw-bold mb-0">{{ $comment->user->name }}</p>
                                                    <p class="text-muted small mb-0"><i class="far fa-clock"></i>
                                                        {{ $comment->created_at->diffForHumans() }}
                                                    </p>
                                                </div>
                                                <div class="card-body">
                                                    <p class="mb-0">
                                                        {!! $comment->body !!}
                                                    </p>
                                                    @foreach ($comment->files as $item)
                                                        <a href="{{ asset("$item->path") }}"
                                                            target="_blank">{{ $item->filename }}</a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="container">
                            <div class="card">
                                <div class="card-body">
                                    <div class="section-title">Tinggalkan Pesan</div>
                                    <form action="{{ route('store-comment', $data->no_ticket) }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" />
                                        <textarea class="form-control" id="summary-ckeditor" name="body"></textarea>
                                        <div class="section-title">File Browser</div>
                                        <div class="custom-file mb-4">
                                            <input type="file" class="custom-file-input" id="customFile"
                                                name="fileName[]" multiple>
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>
                                        {{-- {{Auth::user()->role}} --}}
                                        <button class="btn btn-success" type="submit">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <div class="col-md-4 ticket-details-right">
                <div class="card custom-border-radius sticky-this">
                    <div class="card-header d-flex align-items-center custom-border-radius">
                        <h3 class="h4"><i class="fa fa-ticket"></i> Detail</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsiveW">
                            <table class="table">
                                <tr>
                                    <th class="border-0">Nomor Tiket</th>
                                    <td class="border-0">{{ $data->no_ticket }}</td>
                                </tr>
                                <tr>
                                    <th class="border-0">Jenis Pengaduan</th>
                                    <td class="border-0">{{ $data->category->category }}</td>
                                </tr>
                                <tr>
                                    <th>Pembuatan</th>
                                    <td><span class="rel-time"
                                            data-value="{{ $data->created_at }}">{{ $data->created_at->format('d/m/Y') }}
                                            &nbsp; ({{ $data->created_at->diffForHumans() }})</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Pemilik</th>
                                    <td><span class="user-label"
                                            data-username="{{ $data->owner->name }}">{{ $data->owner->name }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    @if ($data->status == 'open')
                                        <td>
                                            <select name="status" id="status_id" data-id="{{ $data->no_ticket }}"
                                                class="form-control" style="width: 10rem !important;" disabled>
                                                <option value="open" {{ $data->status == 'open' ? 'selected' : '' }}>
                                                    Open
                                                </option>
                                                <option value="progress"
                                                    {{ $data->status == 'progress' ? 'selected' : '' }}>Progress
                                                </option>
                                                <option value="close"
                                                    {{ $data->status == 'close' ? 'selected' : '' }}>
                                                    Close</option>
                                            </select>
                                        </td>
                                    @else
                                        <td>
                                            <select name="status" id="status_id" data-id="{{ $data->no_ticket }}"
                                                class="form-control" style="width: 10rem !important;" disabled>
                                                <option value="open"
                                                    {{ $data->status == 'open' ? 'selected' : '' }}>
                                                    Open
                                                </option>
                                                <option value="progress"
                                                    {{ $data->status == 'progress' ? 'selected' : '' }}>Progress
                                                </option>
                                                <option value="close"
                                                    {{ $data->status == 'close' ? 'selected' : '' }}>
                                                    Close</option>
                                            </select>
                                        </td>
                                    @endif

                                </tr>
                                <tr>
                                    <th>Prioritas</th>
                                    <td>
                                        <select name="priority" id="priority" data-id="dsadasdas"
                                            class="form-control" style="width: 10rem !important;" disabled>
                                            <option value="rendah"
                                                {{ $data->severity->severity == 'rendah' ? 'selected' : '' }}>Rendah
                                            </option>
                                            <option value="sedang" {{ $data->status == 'sedang' ? 'selected' : '' }}>
                                                Sedang</option>
                                            <option value="Tinggi" {{ $data->status == 'tinggi' ? 'selected' : '' }}>
                                                Tinggi</option>
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <th>Ditugaskan Kepada</th>

                                    <td class="border-0">
                                        @if ($data->assign_to != null)
                                            {{ $data->assign_to->name }}
                                        @endif
                                    </td>


                                </tr>
                                <tr>
                                    <th>Tenggat Waktu</th>
                                    <td><span class="rel-time" data-value="{{ $data->due_datetime }}">
                                            {{ $data->due_datetime }}</span></td>
                                </tr>
                                <tr>
                                    <th>Waktu Penyelesaian</th>
                                    <td><span class="rel-time" data-value="{{ $data->close_datetime }}">
                                            {{ $data->close_datetime }}</span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@push('page-scripts')
<script src="{{ asset('assets/modules/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/modules/prism/prism.js') }}"></script>
<script src="//cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>

<script>
    @if (session('error'))
        swal({
            title: "Gagal Menambahkan komentar !",
            text: "{{ session('error') }} !",
            icon: "error",
            dangerMode: true,
        })
    @endif
    @if (session('success'))
        swal({
            title: "Berhasil!",
            text: "{{ session('success') }} !",
            icon: "success",
            dangerMode: true,
        })
    @endif
    $("body").on("click", ".ambil-tiket", function() {
        var current_object = $(this);
        swal({
            title: "Warning",
            text: "Anda yakin ingin mengambil tiket ini ?",
            icon: "warning",
            buttons: true,
            showCancelButton: true,
            dangerMode: true,
        }).then((data) => {
            if (data) {
                var action = current_object.attr('data-action');
                var token = jQuery('meta[name="csrf-token"]').attr('content');
                var id = current_object.attr('data-id');

                $('body').html("<form class='form-inline ambil-tiket' method='post' action='" + action +
                    "'></form>");
                $('body').find('.ambil-tiket').append('<input name="_token" type="hidden" value="' +
                    token + '">');
                $('body').find('.ambil-tiket').append(
                    '<input type="text" hidden value="{{ Auth::user()->id }}" name="user_id" />');
                $('body').find('.ambil-tiket').submit();
            }
        })
    });
    $("body").on("click", ".close-tiket", function() {
        var current_object = $(this);
        swal({
            title: "Warning",
            text: "Anda yakin ingin mengclose tiket ini ?",
            icon: "warning",
            buttons: true,
            showCancelButton: true,
            dangerMode: true,
        }).then((data) => {
            if (data) {
                var action = current_object.attr('data-action');
                var token = jQuery('meta[name="csrf-token"]').attr('content');
                var id = current_object.attr('data-id');

                $('body').html("<form class='form-inline close-tiket' method='post' action='" + action +
                    "'></form>");
                $('body').find('.close-tiket').append('<input name="_token" type="hidden" value="' +
                    token + '">');
                $('body').find('.close-tiket').append(
                    '<input type="text" hidden value="{{ Auth::user()->id }}" name="user_id" />');
                $('body').find('.close-tiket').submit();
            }
        })
    });


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
