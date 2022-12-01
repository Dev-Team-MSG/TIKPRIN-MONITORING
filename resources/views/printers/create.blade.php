@extends('layouts.master')
@section('title')
    Tambah Printer
@endsection
@section('content')
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                @if (session('message'))
                    <div class="alert alert-success alert-dismissible show fade">
                        <div class="alert-body">
                            <button class="close" data-dismiss="alert">
                                <span>×</span>
                            </button>
                            {{ session('message') }}
                        </div>
                    </div>
                @endif
                <form enctype="multipart/form-data" action="{{ route('printers.store') }}" method="POST">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h4>Tambah Printer</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Serial Number</label>
                                        <input type="text"
                                            class="form-control {{ $errors->first('serial_number') ? 'is-invalid' : '' }}"
                                            placeholder="Serial Number" name="serial_number"
                                            value="{{ old('serial_number') }}">
                                        <div class="invalid-feedback">
                                            {{ $errors->first('serial_number') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>MAC Address</label>
                                        <input type="text" id="mac"
                                            class="form-control {{ $errors->first('mac_address') ? 'is-invalid' : '' }}"
                                            placeholder="00:AA:11:BB:22:CC" name="mac_address"
                                            value="{{ old('mac_address') }}">
                                        <div class="invalid-feedback">
                                            {{ $errors->first('mac_address') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tahun Pengadaan</label>
                                        <input type="text"  class="form-control datepicker"
                                            placeholder="2021" name="tahun_pengadaan"
                                            value="{{ old('tahun_pengadaan') }}">
                                        <div class="invalid-feedback">
                                            {{ $errors->first('tahun_pengadaan') }}
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-primary mr-1" type="submit" value="Save">Submit</button>
                        <button class="btn btn-secondary" type="reset">Reset</button>
                    </div>
            </div>
            </form>
        </div>
    </div>
    </div>
@endsection
@push('page-scripts')
@endpush
@push('after-scripts')
@endpush
@push('specific-scripts')
    <script>
        $("#mac").on("keyup", function(event) {

            var limitField = $(this).val().trim().length;
            var limit = "17";

            if (event.keyCode != 8) {
                var mac_value = $(this).val().trim().concat(':');
                switch (limitField) {
                    case 2:
                    case 5:
                    case 8:
                    case 11:
                    case 14:
                        $("#mac").val(mac_value);
                        break;
                }
            }

            if (limitField > limit) {
                $("#mac").val($(this).val().trim().substring(0, limit));
            }
        });
    </script>
@endpush
