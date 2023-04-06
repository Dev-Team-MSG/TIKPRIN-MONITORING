@extends('layouts.master')
@section('title')
    Detail Printer
@endsection
@section('content')
    @push('lib-styles')
        <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-social/bootstrap-social.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css') }}">
    @endpush
    <div class="section-body">

        <div class="row">
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card author-box card-primary">
                    <div class="card-body">
                        <div class="author-box-left">
                            <img alt="image" src="{{ asset('assets/img/printer-entrust.png') }}"
                                class="rounded-circle author-box-picture">
                            <div class="clearfix"></div>
                            <a href="{{ route('printers.index') }}" class="btn btn-primary mt-3">Kembali</a>
                        </div>
                        <div class="author-box-details">
                            <div class="author-box-name">
                                <h3 style="color:#394eea">Info Printer</h3>
                            </div>
                            {{-- <div class="author-box-job">{{$printer->roles}}</div> --}}
                            <div class="author-box-description">
                                <b>Serial Number:</b><br>
                                {{ $printer->serial_number }}
                                <br>
                                <br>
                                <b>MAC Address</b> <br>
                                {{ $printer->mac_address }}
                                <br><br>
                                <b>Tahun Pengadaan</b> <br>
                                {{ showDateTime($printer->created_at, 'l, d F Y') }}
                                <br><br>
                            </div>
                            <div class="w-100 d-sm-none"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card card-primary">
                    <div class="card-body">
                        <div class="author-box-name">
                            <h3 style="color:#394eea">Info Lainnya</h3>
                        </div>
                        <div class="author-box-left">
                            <b>Lokasi Saat ini</b> <br>
                            {{ old('location->name', isset($printer->location->name) ? $printer->location->name : null) }}
                            <br><br>
                            <b>Ditambahkan Oleh</b> <br>
                            {{ old('creator->name', isset($printer->creator->name) ? $printer->creator->name : null) }}
                            <br><br>
                            <b>Diperbaharui Oleh</b> <br>
                            {{ old('editor->name', isset($printer->editor->name) ? $printer->editor->name : null) }}
                            <br><br>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

    </div>
    {{-- <div class="col-12 col-md-6 col-lg-6">
                <div class="card card-primary">
                    <div class="card-body">
                        <div class="author-box-name">
                            <a href="#"><h4>Info Kanim</h4></a>
                        </div>
                        <div class="author-box-left">
                                <b>Kantor Imigrasi:</b><br>
                                {{ $user->kanim_id }}
                                <br>
                                <br>
                                <b>IP Address/Network</b> <br>
                                {{ $user->email }}
                                <br><br>
                                <b>Telepon</b> <br>
                                {{ $user->phone }}
                                <br><br>
                        </div>
                    </div>
                </div>
            </div> --}}
@endsection

@push('page-scripts')
    <script src="{{ asset('assets/modules/owlcarousel2/dist/owl.carousel.min.js') }}"></script>
@endpush
@push('specific-scripts')
    <script src="{{ asset('assets/js/page/components-user.js') }}"></script>
@endpush
@push('after-scripts')
@endpush
