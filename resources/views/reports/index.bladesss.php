@extends('layouts.master')
@push('page-styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
@endpush

@section('title', 'Report')
@section('content')
    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h4>
                    Report
                </h4>
            </div>

            <div class="card-body">
                {{-- <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="tiket-tab" data-toggle="tab" data-target="#tiket" type="button"
                            role="tab" aria-controls="tiket" aria-selected="true">Tiket</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="relokasi-printer-tab" data-toggle="tab" data-target="#relokasi-printer"
                            type="button" role="tab" aria-controls="relokasi-printer" aria-selected="false">Relokasi
                            Printer</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="tiket" role="tabpanel" aria-labelledby="home-tab">
                        <form action="{{route("reports.tiket")}}" method="post">
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
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="relokasi-printer" role="tabpanel" aria-labelledby="profile-tab">
                        <form action="{{route("reports.relokasi-printer")}}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md">
                                    <div class="form-group row">
                                        <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">Dari
                                            Tanggal
                                        </label>
                                        <div class="col-sm-10">
                                            <input type="date" name="tanggal_dari" class="form-control form-control-sm" id="colFormLabelSm"
                                                placeholder="col-form-label-sm">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-group row">
                                        <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">Sampai
                                            Tanggal
                                        </label>
                                        <div class="col-sm-10">
                                            <input type="date" name="tanggal_sampai" class="form-control form-control-sm" id="colFormLabelSm"
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
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>

                </div> --}}
            </div>
        </div>
    </div>
@endsection
@push('page-scripts')
    <script src="{{ asset('assets/modules/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets/modules/prism/prism.js') }}"></script>
    <script src="{{ asset('assets/modules/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/modules/jquery-ui/jquery-ui.min.js') }}"></script>
@endpush
@push('page-scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                closeOnSelect: false
            });
        });
    </script>
@endpush
