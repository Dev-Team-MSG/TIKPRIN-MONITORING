@extends('layouts.master')
@section('title')
    Edit Kanim
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
                <form enctype="multipart/form-data" action="{{ route('kanims.update', [$kanim->id]) }}" method="POST">
                    @csrf
                    <input type="hidden" value="PUT" name="_method">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Printer</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Serial Number</label>
                                        <input type="text" class="form-control {{$errors->first('name') ? "is-invalid" : ""}}" placeholder="Serial Number"
                                            name="name"
                                            value="{{ old('name') ? old('name') : $kanim->name }}">
                                        <div class="invalid-feedback">
                                            {{ $errors->first('name') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>MAC Address</label>
                                        <input type="text" id="mac" class="form-control {{$errors->first('name') ? "is-invalid" : ""}}"
                                            placeholder="00:AA:11:BB:22:CC" name="network"
                                            value="{{ old('network') ? old('network') : $kanim->network }}">
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
