@extends('layouts.master')
@section('title')
    Relokasi Printer
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
                <form action="{{ route('printerkanims.store') }}" method="POST">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h4>Relokasi Printer</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group" id="printer">
                                        <label for="exampleInputEmail1">Printer </label>
                                        <br>
                                        <select class="form-control" name="printer_id">
                                            @foreach ($printeronkanim as $printer)
                                            @if(isset($post))
                                            <option value="{{ $printer->id }}" {{ $post->printers->id == $printer->id? 'selected="selected"':'' }}>{{ $printer->serial_number }} - {{ $printer->mac_address }}</option>
                                        @else
                                            <option value="{{ $printer->id }}">{{ $printer->serial_number }} - {{ $printer->mac_address }}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" id="kanim">
                                        <label for="exampleInputEmail1">Kantor Imigrasi </label>
                                        <br>
                                        <select class="form-control" name="kanim_id">
                                            @foreach ($kanims as $kanim)
                                            @if(isset($post))
                                            <option value="{{ $kanim->id }}" {{ $post->kanims->id == $kanim->id? 'selected="selected"':'' }}>{{ $kanim->name }} - {{ $kanim->network }}</option>
                                        @else
                                            <option value="{{ $kanim->id }}">{{ $kanim->name }} - {{ $kanim->network }}</option>
                                            @endif
                                            @endforeach
                                        </select>
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
