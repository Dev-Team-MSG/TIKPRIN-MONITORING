@extends('layouts.master')
@section('title', 'Home')
@section('content')
    @push('lib-styles')
        <link rel="stylesheet" href="{{ asset('assets/modules/jqvmap/dist/jqvmap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/modules/weather-icon/css/weather-icons.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/modules/weather-icon/css/weather-icons-wind.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/modules/summernote/summernote-bs4.css') }}">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    @endpush

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h4>
                    Report
                </h4>
            </div>

            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="tiket-tab" data-toggle="tab" data-target="#tiket" type="button"
                            role="tab" aria-controls="tiket" aria-selected="true">Tiket</button>
                    </li>
                    {{-- <li class="nav-item" role="presentation">
                        <button class="nav-link" id="relokasi-printer-tab" data-toggle="tab" data-target="#relokasi-printer"
                            type="button" role="tab" aria-controls="relokasi-printer" aria-selected="false">Relokasi
                            Printer</button>
                    </li> --}}
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="tiket" role="tabpanel" aria-labelledby="home-tab">
                        <form action="{{ route('reports.tiket') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md">
                                    <div class="form-group row">
                                        <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">Dari
                                            Tanggal
                                        </label>
                                        <div class="col-sm-10">
                                            <input type="date" class="form-control form-control-sm" id="colFormLabelSm"
                                                placeholder="col-form-label-sm" name="tanggal_dari">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-group row">
                                        <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">Sampai
                                            Tanggal
                                        </label>
                                        <div class="col-sm-10">
                                            <input type="date" class="form-control form-control-sm" id="colFormLabelSm"
                                                placeholder="col-form-label-sm" name="tanggal_sampai">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="inputGroupSelect01">Status</label>
                                </div>
                                <select class="custom-select" id="inputGroupSelect01" name="status">
                                    <option selected value="all">Semua</option>
                                    <option value="open">Open</option>
                                    <option value="progress">Progress</option>
                                    <option value="close">Close</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Download Excel</button>
                        </form>
                    </div>
                    {{-- <div class="tab-pane fade" id="relokasi-printer" role="tabpanel" aria-labelledby="profile-tab">
                        <form action="{{ route('reports.relokasi-printer') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md">
                                    <div class="form-group row">
                                        <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">Dari
                                            Tanggal
                                        </label>
                                        <div class="col-sm-10">
                                            <input type="date" name="tanggal_dari" class="form-control form-control-sm"
                                                id="colFormLabelSm" placeholder="col-form-label-sm">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-group row">
                                        <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">Sampai
                                            Tanggal
                                        </label>
                                        <div class="col-sm-10">
                                            <input type="date" name="tanggal_sampai"
                                                class="form-control form-control-sm" id="colFormLabelSm"
                                                placeholder="col-form-label-sm">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Serial Number Printer</label>
                                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;"
                                    tabindex="-1" aria-hidden="true" name="lokasi">
                                    <option selected="selected" value="alabama">Alabama</option>
                                    <option value="alaska">Alaska</option>
                                    <option value="alaska">California</option>
                                    <option value="delaware">Delaware</option>
                                    <option value="tennese">Tennessee</option>
                                    <option value="texas">Texas</option>
                                    <option value="washington">Washington</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Kanim</label>
                                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;"
                                    tabindex="-1" aria-hidden="true" name="lokasi">
                                    <option selected="selected" value="alabama">Kanim Jakarta Barat</option>
                                    <option value="alaska">Kanim Alaska</option>
                                    <option value="alaska">Kanim California</option>
                                    <option value="delaware">Kanim Delaware</option>
                                    <option value="tennese">Kanim Tennessee</option>
                                    <option value="texas">Kanim Texas</option>
                                    <option value="washington">Kanim Washington</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Download Excel</button>
                        </form>
                    </div> --}}

                </div>
            </div>
        </div>
    </div>

@endsection
@push('page-scripts')
    <script src="{{ asset('assets/modules/simple-weather/jquery.simpleWeather.min.js') }}"></script>
    <script src="{{ asset('assets/modules/chart.min.js') }}"></script>
    <script src="{{ asset('assets/modules/jqvmap/dist/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('assets/modules/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset('assets/modules/summernote/summernote-bs4.js') }}"></script>
    <script src="{{ asset('assets/modules/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script type="text/javascript">
        date = $("[name=tanggal_dari]")
        date.val = new Date()
        @if (session('error'))
            swal({
                title: "Gagal Mengexport Data",
                text: "{{ session('error') }}",
                icon: "error",
                // buttons: true,
                // showCancelButton: true,
                dangerMode: true,
            })
        @endif
    </script>
@endpush
@push('specific-scripts')
    <script src="{{ asset('assets/js/page/index-0.js') }}"></script>
@endpush
