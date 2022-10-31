@extends('layouts.master')
@section('title')
    Detail User
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
                            @if ($user->image)
                                <img alt="image" src="{{ asset('storage/' . $user->image) }}"
                                    class="rounded-circle author-box-picture">
                            @else
                                No Image
                            @endif
                            <div class="clearfix"></div>
                            <a href="{{ route('users') }}" class="btn btn-primary mt-3">Kembali</a>
                        </div>
                        <div class="author-box-details">
                            <div class="author-box-name">
                                <a href="#">{{ $user->name }}</a>
                            </div>
                            <div class="author-box-job">{{$user->roles}}</div>
                            <div class="author-box-description">
                                <b>Username:</b><br>
                                {{ $user->username }}
                                <br>
                                <br>
                                <b>Email</b> <br>
                                {{ $user->email }}
                                <br><br>
                                <b>Telepon</b> <br>
                                {{ $user->phone }}
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
