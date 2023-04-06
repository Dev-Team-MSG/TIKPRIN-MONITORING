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
                <form action="{{ route('kanims.update', [$kanim->id]) }}" method="POST">
                    @csrf
                    <input type="hidden" value="PUT" name="_method">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Kanim</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nama Kanim</label>
                                        <input type="text"
                                            class="form-control {{ $errors->first('name') ? 'is-invalid' : '' }}" placeholder="Jakarta Pusat"
                                            placeholder="" name="name"
                                            value="{{ old('name') ? old('name') : $kanim->name }}">
                                        <div class="invalid-feedback">
                                            {{ $errors->first('name') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Telp Kantor</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-phone"></i>
                                                </div>
                                            </div>
                                            <input type="phone"
                                                class="form-control phone-number {{ $errors->first('telp') ? 'is-invalid' : '' }}" placeholder="0216541213" required=""
                                                name="telp" value="{{ old('telp') ? old('telp') : $kanim->telp }}">
                                            <div class="invalid-feedback">
                                                {{ $errors->first('telp') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Alamat Kantor</label>
                                        <textarea class="form-control {{$errors->first('alamat') ? "is-invalid" : ""}}" placeholder="Jl. Merpati No.3, Gn. Sahari Utara, Kec. Kemayoran, Kota Jakarta Pusat, Daerah Khusus Ibukota Jakarta 10720"
                                            name="alamat" id="alamat" required autocomplete="alamat"
                                            autofocus>{{{ old('alamat',$kanim->alamat) }}}</textarea>
                                        <div class="invalid-feedback">
                                            {{ $errors->first('alamat') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-group" id="mapCenterForm">
                                    <label>Latitude</label>
                                    <input type="text" id="latitude"
                                        class="form-control {{ $errors->first('latitude') ? 'is-invalid' : '' }}" placeholder="-6.1776323"
                                        placeholder="" name="latitude"
                                        value="{{ old('latitude') ? old('latitude') : $kanim->latitude }}">
                                    <div class="invalid-feedback">
                                        {{ $errors->first('latitude') }}
                                    </div>
                                    <label>Longitude</label>
                                    <input type="text" id="longitude"
                                        class="form-control {{ $errors->first('longitude') ? 'is-invalid' : '' }}" placeholder="106.8185349,16"
                                        placeholder="" name="longitude"
                                        value="{{ old('longitude') ? old('longitude') : $kanim->longitude }}">
                                    <div class="invalid-feedback">
                                        {{ $errors->first('longitude') }}
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
@endpush
