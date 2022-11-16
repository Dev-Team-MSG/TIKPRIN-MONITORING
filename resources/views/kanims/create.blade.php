@extends('layouts.master')
@section('title')
    Tambah Kanim
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
                <form action="{{ route('kanims.store') }}" method="POST">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h4>Tambah Kanim</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nama Kanim</label>
                                        <input type="text"
                                            class="form-control {{ $errors->first('name') ? 'is-invalid' : '' }}"
                                            placeholder="" name="name"
                                            value="{{ old('name') }}">
                                        <div class="invalid-feedback">
                                            {{ $errors->first('name') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Network Address</label>
                                        <input type="text" id="mac"
                                            class="form-control {{ $errors->first('network') ? 'is-invalid' : '' }}"
                                            placeholder="192.168.2.1" name="network"
                                            value="{{ old('network') }}">
                                        <div class="invalid-feedback">
                                            {{ $errors->first('network') }}
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
@push('specific-scripts')
    {{-- <script>
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
    </script> --}}
@endpush
