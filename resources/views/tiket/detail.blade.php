@extends('layouts.master')
@push('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush
@section('title', "$data->no_ticket")
@section('content')

    <section class="section">
        <div class="section-header">
            <h1>Semua Ticket</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Tiket</a></div>
                <div class="breadcrumb-item"><a href="#">Semua Tiket</a></div>
            </div>
        </div>
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
                                        {{ $data->description }}
                                    </p>
                                    @foreach ($data->files as $item)
                                        <a href="{{ asset("$item->path") }}">{{ $item->filename }}</a>
                                    @endforeach

                                    @if ($data->status == 'open')
                                        <div class="row">
                                            <div class="col-md">
                                                <form action="" method="post">
                                                    <button type="submit">Ambil</button>
                                                </form>
                                            </div>

                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="container py-5 mx-auto">
                                <div class="main-timeline">
                                    @foreach ($data->comments as $comment)
                                        @if ($comment->user_id == $data->owner_id)
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
                                                            {{ $comment->body }}
                                                        </p>
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
                                                            {{ $comment->body }}
                                                        </p>
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
                                        <form action="{{ route('store-comment', $data->no_ticket) }}" method="post">
                                            @csrf
                                            <textarea class="form-control" id="summary-ckeditor" name="summary-ckeditor"></textarea>
                                            <div class="section-title">File Browser</div>
                                            <div class="custom-file mb-4">
                                                <input type="file" class="custom-file-input" id="customFile">
                                                <label class="custom-file-label" for="customFile">Choose file</label>
                                            </div>

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
                                        <td>
                                            <select name="status" id="status_id" data-id="{{ $data->no_ticket }}"
                                                class="form-control" style="width: 10rem !important;">
                                                <option value="open" {{ $data->status == 'open' ? 'selected' : '' }}>Open
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
                                            <select name="priority" id="priority" data-id="dsadasdas" class="form-control"
                                                style="width: 10rem !important;" disabled>
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
                                        <td>
                                            <select name="assign_to" id="assign_to_dd" data-id="dsadasdas"
                                                class="form-control" style="width: 10rem !important;">
                                                <option value="{{ $data->assign_to->name }}">{{ $data->assign_to->name }}
                                                </option>
                                            </select>
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
            console.log(field)
            let value = this.value;
            console.log(value)
            let ticket_id = $(this).attr("data-id");
            console.log(ticket_id);
            let message = `Changed ${field} to ${value}`;
            console.log(message);
            // let plain_txt_message = "Changed " + field + " to " + value + ".";
            // let type = parseInt($(this).attr("data-type"));
            let data = {
                _token: '{{ csrf_token() }}',
                    id: ticket_id,
                
                //     // meta: {
                //     //     ticket_no,
                //     //     message,
                //     //     type,
                //     //     plain_txt_message,
                //     // },
            };
            data["status"] = value;
            // console.log(data);
            // // Handle if field assign to is change, so send only id from agent
            // // if (field === "assign_to") {
            // //     // Get text from select2 dropdown
            // //     const text = $("select.form-control").select2("data")[0].text;
            // //     data["update_data"][field] = value;
            // //     data.meta.message =
            // //         `Changed assigned to <span class="user-label" data-value="${text}" data-username="${text}"></span>`;
            // //     data.meta.plain_txt_message = `Changed assigned to ${text}.`;
            // //     data["update_data"]["assign_on"] = Date.now();
            // //     data["update_data"]["status"] = 50; //hardcoded assigned status;
            // // }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            // // Send data using ajax
            $.ajax({
                type: "POST",
                url: "{{ route('update-tiket') }}",
                // dataType: "text",
                dataType: 'json',
                // headers: { 'X-CSRF-TOKEN': $('meta[name=\'csrf-token\']').attr('content')},
                data: data,
                // beforeSend: function () {
                //   $("#au_result").html(
                //     '<img src="../../../assets/img/loader.gif" class="pull-right" style="width: 30px;">'
                //   );
                // },
                success: function(response) {
                    console.log("success");
                    console.log(data)
                    // if (JSON.parse(response)["data"]["result"]) {
                    //     showNotification("success", data.meta.message, {}, () =>
                    //         window.location.reload()
                    //     );
                    // } else {
                    //     showNotification("error", "Some error occured.");
                    // }
                },
            });
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
