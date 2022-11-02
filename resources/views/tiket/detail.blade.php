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
                                    @can('ambil tiket')
                                        @if ($data->status == 'open')
                                            <div class="row mt-5">
                                                <div class="col-md">
                                                    <form action="{{ route('ambil-tiket', $data->no_ticket) }}" method="post">
                                                        @csrf
                                                        <input type="text" hidden value="{{ Auth::user()->id }}"
                                                            name="user_id" />
                                                        <button class="btn btn-warning"type="submit">Ambil</button>
                                                    </form>
                                                </div>

                                            </div>
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
                                            <textarea class="form-control" id="summary-ckeditor" name="body"
                                                @cannot("edit tiket")
                                                @disabled(true)
                                                @endcannot></textarea>
                                            <div class="section-title">File Browser</div>
                                            <div class="custom-file mb-4">
                                                <input type="file" class="custom-file-input" id="customFile"
                                                    name="fileName[]" multiple
                                                    @cannot("edit tiket")
                                                    @disabled(true)
                                                    @endcannot>
                                                <label class="custom-file-label" for="customFile">Choose file</label>
                                            </div>
                                            {{-- {{Auth::user()->role}} --}}
                                            <button class="btn btn-success" type="submit"
                                            @cannot("edit tiket")
                                            hidden
                                            @endcannot >Submit</button>
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
                                        <td>
                                            <select name="status" id="status_id" data-id="{{ $data->no_ticket }}"
                                                class="form-control" style="width: 10rem !important;" @cannot("edit tiket")
                                                @disabled(true)
                                                @endcannot>
                                                <option value="open" {{ $data->status == 'open' ? 'selected' : '' }}>
                                                    Open
                                                </option>
                                                <option value="progress"
                                                    {{ $data->status == 'progress' ? 'selected' : '' }}>Progress</option>
                                                <option value="close" {{ $data->status == 'close' ? 'selected' : '' }}>
                                                    Close</option>
                                            </select>
                                        </td>
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
                                            @endif</td>

                                        
                                    </tr>
                                    <tr>
                                        <th>Tenggat Waktu</th>
                                        <td><span class="rel-time" data-value="{{ $data->due_datetime }}">
                                                {{ $data->due_datetime }}</span></td>
                                    </tr>
                                    <tr>
                                        <th>Waktu Penyelesaian</th>
                                        <td><span class="rel-time" data-value="{{ $data->close_datetime }}">
                                                {{ $data->due_datetime }}</span>
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
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="//cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $("#status_id").on("change", function() {
            console.log("berubah")
            let field = $(this).attr("name");
            let value = this.value;
            let ticket_id = $(this).attr("data-id");
            let message = `Changed ${field} to ${value}`;
            let data = {
                _token: '{{ csrf_token() }}',
                id: ticket_id,
                user_id: {{ Auth::user()->id }},
                message: message,
            };
            data["status"] = value;


            Swal.fire({
                icon: 'warning',
                title: "Anda yakin ingin mengubah status tiket ?",
                showCancelButton: true,
                showDenyButton: false,
                confirmButtonText: 'Yes'
            }).then((res) => {
                $.ajax({
                    type: "POST",
                    data: data,
                    url: "{{ route('update-tiket') }}",
                    dataType: 'json',
                    success: function(result) {
                        console.log(result)
                        Swal.fire({
                            icon: 'success',
                            title: `Status tiket berhasil di ubah menjadi ${data["status"]}`,
                            showDenyButton: false,
                            showCancelButton: false,
                            confirmButtonText: 'Yes'
                        }).then(() => {
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
            })

            // // Send data using ajax

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
