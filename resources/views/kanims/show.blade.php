@extends('layouts.master')
@section('title')
    Detail Kanim
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
                            <img alt="image" src="{{ asset('assets/img/kanim.png') }}"
                                class="rounded-circle author-box-picture">
                            <div class="clearfix"></div>
                            <a href="{{ route('kanims.index') }}" class="btn btn-primary mt-3">Kembali</a>
                        </div>
                        <div class="author-box-details">
                            <div class="author-box-name">
                                <h3 style="color:#394eea">Info Kantor</h3>
                            </div>
                            {{-- <div class="author-box-job">{{$printer->roles}}</div> --}}
                            <div class="author-box-description">
                                <b>Nama:</b><br>
                                {{ $kanim->name }}
                                <br>
                                <br>
                                <b>Alamat</b> <br>
                                {{ $kanim->alamat }}
                                <br><br>
                                <b>Telp</b> <br>
                                {{ $kanim->telp }}
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
                            <h3 style="color:#394eea">Daftar Printer</h3>
                        </div>
                        <div class="author-box-left">
                            <table class="table table-striped table-bordered table-sm">
                                <tr>
                                    <th>No</th>
                                    <th>Serial Number</th>
                                    <th>Mac Address</th>
                                </tr>
                                @foreach ($printer as $no => $data)
                                <tr>
                                    <td>{{ $printer->firstItem()+$no }}</td>
                                    <td>{{ $data->serial_number}}</td>
                                    <td>{{ $data->mac_address}}</td>
                                </tr>
                                @endforeach    
                            </table>
                            {{ $printer->links() }}
                            <form action="{{ route('printers.index') }}">
                                <button type="submit"  class="btn btn-success"><i class="fas fa-plug"></i>
                                    LIHAT SEMUA PRINTER
                                </button>
                                </form>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

    </div>
@endsection

@push('page-scripts')
    <script src="{{ asset('assets/modules/owlcarousel2/dist/owl.carousel.min.js') }}"></script>
@endpush
@push('specific-scripts')
    <script src="{{ asset('assets/js/page/components-user.js') }}"></script>
@endpush
@push('after-scripts')
@endpush
